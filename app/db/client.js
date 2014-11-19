angular.module('csm').service('db', function($http) {
  var self = this;

  this.set = function(key, value, participantId, ra, callback) {
    self._set(key, value, participantId, ra, false, callback);
  };
  this.setCoalesce = function(key, value, participantId, ra, callback) {
    self._set(key, value, participantId, ra, true, callback);
  };
  this._set = function(key, value, participantId, ra, coalesce, callback) {
    var promise = $http.post('/db/?coalesce=' + coalesce, {
      ra: ra,
      participantID: participantId,
      key: key,
      value: value
    });
    if (callback) {
      promise.success(callback);
    }
  };

  this.getLog = function(keyNames, participantId, callback) {
    var endpoint = '/db/participants/' + participantId;
    endpoint += '?logKeys=' + keyNames;
    $http.get(endpoint).success(function(details) {
      callback(details.logbook[participantId] || [], details.participant);
    });
  };

  this.getAllKeysForAllParticipants = function(keys, callback){
    if(!_.isString(keys)){
      keys = keys.join(',');
    }
    $http.get('/db/participants?keys=' + keys).success(callback);
  };

  this.addParticipant = function(site, siteId, ra, status, callback) {
    if (siteId === 0 || siteId === 1) {
      //0 results in stripping when participant id is converted to an integer
      //1 is confusing when we get into the thousands of participants
      throw 'site id cant be 0 or 1';
    }
    $http.post('/db/participants?site=' + siteId).success(function(data) {
      var sets = 0;

      function done() {
        sets++;
        if (sets === 3) {
          callback(data.id);
        }
      }
      self.set('id', data.id, data.id, ra, done);
      self.set('site', site, data.id, ra, done);
      self.set('status', status, data.id, ra, done);
    });
  };

  //machine
  this.getMeta = function(name, callback){
    $http.get('/db/meta/' + name).success(callback);
  };
  this.setMeta = function(name, value, callback){
    $http.post('/db/meta/' + name, {
      value: value
    }).success(callback);
  };
});
