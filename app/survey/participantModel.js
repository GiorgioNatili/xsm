angular.module('csm').service('participantModel', function($location, loginModel, db) {
  var participant, log;
  var self = this;

  this.getParticipant = function(){
    return participant;
  }
  this.getLog = function(){
    return log;
  }

  this.getParticipantId = function(){
    var ret = $location.search().participantId;
    if(!ret){
      alert('participantId not defined');
    }
    return ret;
  }
  this.init = function(pageName){
     db.getLog('survey.page.' + pageName, self.getParticipantId(), function(logbook, fields) {
       log = logbook;
       participant = fields;
     });
  };

  this.setValue = function(key, value, coalesce, callback){
    participant[key] = value;
    db._set(key, value, self.getParticipantId(), loginModel.getUserName(), coalesce, callback);
  };
  this.getValue = function(key){
    if(!participant){
      return undefined;
    }
    return participant[key];
  };
});
