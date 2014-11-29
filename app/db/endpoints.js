var _ = require('underscore');

function addCheckDigit(str) {
  digits = Math.random() * 10;
  digits = digits + '';
  return str + digits[0];
}

function getId(machineId, seqId, site) {
  do {
    seqId = '0' + seqId;
  } while (seqId.length < 4);
  var ret = site + seqId + machineId;
  ret = addCheckDigit(ret);
  ret = addCheckDigit(ret);
  return ret;
}

module.exports = function (app, BFT) {
  app.get('/db/participants', function (request, response, next) {
    //for now do nothing
    fail(reponse);
    return;

    var keys = request.query.keys;
    if(keys){
      keys = keys.split(/,/g);
    }

    function done(results) {
      response.json(results);
    }

    BFT.getValues(undefined, keys, undefined, done);
  });
  app.post('/db/participants', function (request, response, next) {
    BFT.getMeta('participantSeq', function (oldId) {
      if (!oldId) {
        oldId = 0;
      }
      oldId++;
      function idIncremented() {
        BFT.getMeta('machine', function (machine) {
          response.json({id: getId(machine, oldId, request.query.site)});
        });
      }

      BFT.setMeta('participantSeq', oldId, idIncremented);
    });
  });
  //TODO GN add endpoints to generate a survey url
  app.get('/db/participants/:id', function (request, response, next) {
    //TODO GN validate that this user has access to this id
    var id = parseInt(request.params.id);
    var logKeys = request.query.logKeys;
    if (logKeys) {
      logKeys = logKeys.split(/,/g);
    }
    function done(results, logbook) {
      participant = results[id];
      if (participant) {
        response.json({
          participant: participant,
          logbook: logbook
        });
      }
      else {
        response.status(404, 'No participant with id found.').end();
      }
    }

    BFT.getValues([id], undefined, logKeys, done);
  });
  app.get('/db/meta/:key', function (request, response) {
    //for now do nothing
    fail(reponse);
    return;

    BFT.getMeta(request.params.key, _.bind(response.json, response));
  });
  app.post('/db/meta/:key', function (request, response) {
    //for now do nothing
    fail(reponse);
    return;

    function done() {
      response.status(200).end();
    }
    BFT.setMeta(request.params.key, request.body.value, done);
  });
  function checkDefined(obj, key){
    if(!obj[key]){
      throw 'key:' + key + ' not defined in ' + obj;
    }
  }
  app.post('/db/', function (request, response, next) {
    //for now do nothing
    fail(reponse);
    return;

    var r = request.body;

    checkDefined(r, 'ra');
    checkDefined(r, 'key');
    checkDefined(r, 'participantID');

    function done() {
      response.status(200).end();
    }

    BFT.getMeta('machine', function (machine) {
      if(!machine){
        throw "undefined machineid:" + machine;
      }
      var fields = {
        ra: r.ra,
        participantID: r.participantID,
        key: r.key,
        machine: machine,
        value: r.value
      };
      BFT.insert(fields, request.query.coalesce == 'true', done);
    });
  });
};
