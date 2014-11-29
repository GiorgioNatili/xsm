var fs = require('fs');
var _ = require('underscore');
var sqlite3 = require("sqlite3").verbose();
var levenshtein = require('levenshtein');
var constants = require('../constants');
var randtoken = require('rand-token');

function BFT(dbFile, initCallback) {
  var dbExists = fs.existsSync(dbFile);

  this.db = new sqlite3.Database(dbFile);

  //counter used to distinguish rows created in the same millsecond
  this.createSeq = 0;
  this.metaCache = {};

  if (!dbExists) {
    this.init(initCallback);
  } else {
    setImmediate(initCallback);
  }
}

var method = BFT.prototype;

method.trace = function () {
  this._trace('run');
  this._trace('each');
  this._trace('all');
};
method._trace = function (fn) {
  var orig = this.db[fn];
  this.db[fn] = function () {
    console.log(fn, _.toArray(arguments));
    return orig.apply(this, arguments);
  };
};

method.init = function (callback) {
  var that = this;
  that.db.serialize(function () {
    //primary key is (machine, timestamp, createseq)
    that.db.run("CREATE TABLE BFT (" +
      "machine   INTEGER," + //which machine created this row
      "timestamp INTEGER," + //when was this row created
      "createSeq INTEGER," + //see create seq above
      "copied    INTEGER," + //boolean indicating sync status
      "ra        TEXT," + //which ra created this row
      "participantID INTEGER," + //who this data applies to
      "key       TEXT," +
      "value     TEXT)");

    that.db.run("CREATE TABLE META (key TEXT PRIMARY KEY, value TEXT)");

    that.db.run("CREATE TABLE TOKENS (token TEXT PRIMARY KEY, " +
      "participantId TEXT, timestamp DATETIME DEFAULT CURRENT_TIMESTAMP)");

    that.db.run("CREATE INDEX key_index ON BFT(key)");
    that.db.run("CREATE INDEX copied_index ON BFT(copied)");
    that.db.run("CREATE INDEX participant_index ON BFT(participantID)",
      logErrOver(callback));
  });
};

method.getMeta = function (key, callback, err) {
  var that = this;
  if (key in this.metaCache) {
    setTimeout(function () {
      callback(that.metaCache[key]);
    });
  } else {
    that.db.get('SELECT value FROM META WHERE key = ?', [key],
      logErrOver(function (result) {
        if (!result) {
          result = {value: undefined};
        }
        that.metaCache[key] = result.value;
        callback(result.value);
      }, err)
    );
  }
};

method.createToken = function (participantId, callback, err) {
  if(particpantId){
    var token = randtoken.generate(16);
    this.db.run('INSERT INTO TOKENS (token, participantId)'+
      ' VALUES (?, ?)',
      [token, participantId],
      logErrOver(callback, err));
    return token;
  }else{
    throw new Error('participantId falsey');
  }
}

//pass to callback participantId for unexpired login token or call err
method.getParticipantForToken = function (token, callback, err) {
  //TODO GN
}

method.setMeta = function (key, value, callback, err) {
  if (key in this.metaCache) {
    this.metaCache[key] = value;
  }
  var that = this;
  that.db.serialize(function () {
    that.db.run('DELETE FROM META WHERE key = ?', [key], logErrOver());
    that.db.run('INSERT INTO META (key, value) VALUES (?, ?)',
      [key, value], logErrOver(callback, err));
  });
};

//delete all rows from bft
method.deleteBFT = function (callback) {
  this.db.run("DELETE FROM BFT", logErrOver(callback));
};

//required data in fields:
//machine, ra, participantID, key, value
//timestamp and copied will be set automatically if not given
//if coalesce is true:
//row will be inserted into db and any rows with value with levestein distance
//less than 2 inserted for the the same key within COALESCE_DELAY ms
//will be delted if the key type is string and they were on the same machine
method.insert = function (fields, coalesce, callback) {
  var that = this;

  function doCoalesce() {
    that.db.all('SELECT DISTINCT value, timestamp, createSeq FROM BFT ' +
        ' WHERE machine = ? AND key = ? and timestamp > ?',
      [fields.machine, fields.key, fields.timestamp - constants.COALESCE_DELAY],
      logErrOver(processSimilar)
    );
  }

  function processSimilar(maybeSimilarRows) {
    _.each(maybeSimilarRows, deleteMaybeSimilar);
    _insert();
  }

  function deleteMaybeSimilar(maybeSimilarRow) {
    if (new levenshtein('' + fields.value, '' + maybeSimilarRow.value).distance <= 2) {
      that.db.run('DELETE FROM BFT WHERE' +
          ' key = ?' +
          ' AND timestamp = ?' +
          ' AND machine = ?' +
          ' AND createSeq = ?',
        [
          fields.key,
          maybeSimilarRow.timestamp,
          fields.machine,
          maybeSimilarRow.createSeq
        ]
      );
    }
  }

  function _insert() {
    that.db.run('INSERT INTO BFT (' +
        'createSeq,' +
        ' timestamp,' +
        ' copied,' +
        ' machine,' +
        ' ra,' +
        ' participantID,' +
        ' key,' +
        ' value)' +
        ' VALUES (?,?,?,?,?,?,?,?)',
      [that.createSeq,
        fields.timestamp,
        fields.copied,
        fields.machine,
        fields.ra,
        fields.participantID,
        fields.key,
        fields.value],
      logErrOver(callback));
    that.createSeq++;
  }

  fields = _.clone(fields);
  if (!fields.timestamp) {
    fields.timestamp = new Date().getTime();
  }
  if (!fields.copied) {
    fields.copied = false;
  }

  this.setMeta('hasNonCopied', true, function () {
    if (coalesce) {
      doCoalesce();
    } else {
      _insert();
    }
  });
};

method.getNonCopiedRows = function (start, callback, err) {
  var db = this.db;
  var that = this;

  function done(rows) {
    if (rows && rows.length) {
      callback(rows);
    } else {
      that.setMeta('hasNonCopied', false, logErrOver(_.bind(callback, _, []), err));
    }
  }

  function get(nonCopied) {
    if (!nonCopied) {
      setTimeout(_.bind(done, _, []));
    } else {
      db.all('SELECT * FROM BFT WHERE copied = 0 ' +
        'AND timestamp <= ' + start, logErrOver(done, err));
    }
  }

  this.getMeta('hasNonCopied', get, err);
};

method.multiInsert = function (rows, callback, err) {
  var db = this.db;
  db.serialize(function () {
    var stmt = db.prepare('INSERT INTO BFT (' +
      'createSeq,' +
      ' timestamp,' +
      ' copied,' +
      ' machine,' +
      ' ra,' +
      ' participantID,' +
      ' key,' +
      ' value)' +
      ' VALUES (?,?,1,?,?,?,?,?)');
    _.each(rows, function (row) {
      stmt.run([row.createSeq,
        row.timestamp,
        row.machine,
        row.ra,
        row.participantID,
        row.key,
        row.value]);
    });
    stmt.finalize();

    callback();
  });
};

method.markAsCopied = function (start, callback, err) {
  var that = this;
  function marked(){
    that.setMeta('hasNonCopied', false, logErrOver(callback, err));
  }
  this.db.run('UPDATE BFT SET copied = ? WHERE timestamp <= ' +
    '? AND copied = ?', [1, start, 0], logErrOver(marked, err));
};

//passes to callback two hashes:

//the first contains the most recent values for all keys in keys
//for all participants in participants. If keys or participants
//is not defined all keys/participants are returned.

//the second contains all key, value, participant, ra, machine rows
//for each participant for all keys in looggedKeys

method.getValues = function (participants, keys, loggedKeys, callback) {
  var columns = 'participantID, key, value';

  var logbook = {};
  if (!loggedKeys) {
    loggedKeys = [];
  }
  if (true) {//loggedKeys.length != 0){ if we don't take all the keys
    //then select distinct may ignore newer entries
    //causing old values to take precedence
    columns += ', timestamp, machine, ra, createSeq';
  }

  var where;
  if (keys) {
    var wrappedkeys = _.map(keys, function (key) {
      if (key.indexOf('\'') != -1) {
        //TODO implement escaping?
        throw 'invalid key name:' + key;
      }
      return '\'' + key + '\'';
    });
    where = 'key IN (' + wrappedkeys.join() + ')';
  }
  if (participants) {
    if (!where) {
      where = '';
    } else {
      where += ' ';
    }
    where += 'participantID IN (' + participants.join() + ')';
  }
  //need to select distinct incase duplicate logbook entries got inserted on race
  var q = 'SELECT DISTINCT ' + columns + ' FROM BFT';
  if (where) {
    q += ' WHERE ' + where;
  }
  q += ' ORDER BY timestamp ASC, createSeq ASC';
  var results = {};

  function processRow(row) {
    setcreate(results, row.participantID, row.key, row.value);

    if (_.contains(loggedKeys, row.key)) {
      var logEntry = {
        q: row.key,
        a: row.value,
        t: row.timestamp,
        m: row.machine,
        ra: row.ra
      };
      addcreate(logbook, row.participantID, logEntry);
    }
  }

  function done() {
    callback(results, logbook);
  }

  this.db.each(q, logErrOver(processRow), done);
};

//UTILITIES --------------------------------------------------------------------

function setcreate(hash, pk, k, v) {
  var t = hash[pk];
  if (!t) {
    t = hash[pk] = {};
  }
  t[k] = v;
}

function addcreate(hash, k, v) {
  var t = hash[k];
  if (!t) {
    t = hash[k] = [];
  }
  t.push(v);
}

//returns a function that log error if any is passed
//otherwise pass result to success function
function logErrOver(success, errCallback) {
  errCallback = errCallback || console.log;
  return function (error, result) {
    if (error) {
      errCallback(error);
    } else {
      if (success || result) {
        success(result);
      }
    }
  };
}

//EXPORTS ----------------------------------------------------------------------

module.exports = BFT;
