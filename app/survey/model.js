angular.module('csm').service('surveyModel', function($location, $timeout, participantModel, loginModel, db, survey) {
  var self = this;
  var surveySchema;
  var backStack = [];
  var surveyBranching;
  var pageNames;
  var inited = false;

  this.getAllKeysForAllParticipants = db.getAllKeysForAllParticipants;

  this.findPage = function(name){
    return pageNames[pageNames.indexOf(name) + 1]
  };

  this.getSurveyBranching = function(fnName){
    return surveyBranching[fnName];
  };

  this.getSurveyFunction = function(fnName){
    return surveyFunctions[fnName];
  };

  this.getParticipant = participantModel.getParticipant;

  this.getBackStack = function(){
    return backStack;
  };

  this.getSchema = function() {
    if(!surveySchema){
      surveySchema = survey.findSurvey($location.search().survey);
      if(!surveySchema){
        alert('survey schema not found');
      }
    }
    return surveySchema;
  };

  this.isLoading = function(){
    return participantModel.getParticipant() === undefined;
  };

  this.getParticipantId = participantModel.getParticipantId;

  this.set = participantModel.setValue;
  this.get = participantModel.getValue;

  this.getAnswer = function (questionName) {
    return self.get(self.getSchema().name + '.' + questionName);
  }

  this.setAnswer = function (questionName, value, coalesce) {
    value = value && (value + "").trim();
    self.set(self.getSchema().name + '.' + questionName, value, coalesce);
  }
  function load(){
    if(!survey.schema()){
      $timeout(load, 50);
      return;
    }
    if(!inited){
      inited = true;
      participantModel.init(self.getSchema().name);
    }

    if(!participantModel.getLog()){
      $timeout(load, 50);
      return;
    }
    surveyBranching = BRANCHES[self.getSchema().name];
    pageNames = _.pluck(self.getSchema().pages, 'name');

    backStack.push(pageNames[0]);
    _.each(_.pluck(participantModel.getLog(), 'a'), function(element) {
      if (element === '!back') {
        backStack.pop();
      } else if (element === '!clear') {
        backStack.length = 0;
        backStack.push(pageNames[0]);
      } else {
        backStack.push(element);
      }
    });
  }
  this.load = load;
});
