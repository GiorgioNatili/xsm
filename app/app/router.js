angular.module('csm').service('router', function(survey){
  this.open = function(surveyName, participantId){
    var participantQuery = 'participantId=' + participantId;
    var surveyUrl = '/survey/#?survey=' + surveyName + '&';
    if(surveyName === 'tfb'){
      surveyUrl = '/tfb/#?';
    }
    if(surveyName){
      window.open(surveyUrl + participantQuery, '_blank');
    }
    window.setTimeout(function(){
      window.close();
    });
  };
});
