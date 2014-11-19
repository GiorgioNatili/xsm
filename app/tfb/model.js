angular.module('csm').service('tfbModel', function(loginModel, participantModel, db, survey) {
  var self = this;

  this.isLoading = function(){
    return participantModel.getParticipant() === undefined;
  }

  this.get = function(key){
    return participantModel.getParticipant()[key];
  };
  this.set = function(key, value){
    participantModel.getParticipant()[key] = value;
    db.set(key, value, self.getParticipantId(), loginModel.getUserName(), false);
  };

  this.getParticipantId = participantModel.getParticipantId;

  this.getNextSurvey = function(){
    return survey.findSurvey('tfb').next;
  };
  this.getLog = participantModel.getLog;

  participantModel.init('tfb');
});
