var request = require('request');
var _ = require('underscore');

var ENDPOINT = 'https://www.myvyou.com/csm/xas1n4c5Y0/db.php';

remote = function (name) {
  this.name = name;
};

remote.prototype.request = function (method, req_body, queryParameters, callback, err) {
  if (!queryParameters) {
    queryParameters = {};
  }
  queryParameters['table'] = this.name;
  request({
    url: ENDPOINT,
    qs: queryParameters,
    method: method,
    body: req_body
  }, function (e, r, body) {
    if (r && r.statusCode != 200 && !e) {
      e = 'unexpected status code:' + r.statusCode
        + '\nfor ' + method + ' ' + ENDPOINT + '?' + JSON.stringify(queryParameters)
        + '\nREQUEST:' + req_body
        + '\nRESPONSE:' + body;
    }
    if (!e) {
      try {
        callback(JSON.parse(body.toString()));
      } catch (ex) {
        console.log(ex.stack);
        e = 'parseError:' + ex + ":" + body;
      }
    }
    if (e) {
      if (err) {
        err(e);
      } else {
        console.log(e);
      }
    }
  });
};

//underscore is used to prefix reserved keywords in mysql
SCHEMA = '';
SCHEMA += 'id            int(8) NOT NULL AUTO_INCREMENT,';
SCHEMA += 'machine       int(8),';
SCHEMA += '_timestamp    varchar(255),';//int(16) still overflows?
SCHEMA += 'createSeq     int(8),';
SCHEMA += 'ra            varchar(255),';
SCHEMA += 'participantID int(8),';
SCHEMA += '_key	         varchar(255),';
SCHEMA += 'value         varchar(32000),';
SCHEMA += 'unique        (machine,_timestamp,createSeq),';
SCHEMA += 'primary key   (id)';

remote.prototype.create = function (callback, err) {
  this.request('PUT', SCHEMA, undefined, callback, err);
};

remote.prototype.destroy = function (callback, err) {
  this.request('DELETE', undefined, undefined, callback, err);
};

remote.prototype.sync = function (inRows, maxPostedRow, machineName, callback, err) {
  _.each(inRows, function (row) {
    row._timestamp = row.timestamp;
    row._key = row.key;
    delete row.machine;
    delete row.copied;
    delete row.timestamp;
    delete row.key;
  });
  function callbackWrap(data) {
    var outRows = [];
    _.each(data[1], function (row) {
      row.key = row._key;
      row.timestamp = row._timestamp;
      if (row.machine != machineName) {
        outRows.push(row);
      }
    });
    callback(outRows);
  }

  this.request('POST',
    JSON.stringify(inRows),
    {maxPostedRow: maxPostedRow, postingMachine: machineName + ""},
    callbackWrap,
    err
  );
};

module.exports = remote;
