angular.module('csm').controller('loadingCtrl', function($scope, setMachineModel, model){
  $scope.isLoading = function(){
    return setMachineModel.isLoading() || !model.headers;
  };
});


angular.module('csm').service('model', function($interval, $http, db, survey, $location, $timeout, loginModel){
  var self = this;

  this.logout = loginModel.logout;

  var logEntryTypes = [{
    key: "phone",
    title: "Phone"
  }, {
    key: "email",
    title: "Email"
  }, {
    key: "inPerson",
    title: "In Person"
  }];
  this.logEntryTypes = function(){
    return logEntryTypes;
  };
  var logKeys = _.pluck(logEntryTypes, 'key').
    map(function(key) {
      return 'contact.' + key;
    }).
    join();
  logKeys += ',survey.start,survey.done,survey.clear';

  this.schema = survey.schema;

  var headers, detailsSchema, headerKeys;



  this.detailsSchema = function(){
    return detailsSchema;
  };
  this.headers = function(){
    return headers;
  };

  function processSchema(){
    if(!survey.schema()){
      $timeout(processSchema, 10);
      return;
    }
    headers = _.where(survey.schema().roster, {
      section: 'header'
    });
    detailsSchema = _.where(survey.schema().roster, function(row){
      return row.section === 'details1' || row.section === 'details2';
    });
    headerKeys = _.pluck(this.headers, 'key').join();

    self.refresh();
  };
  processSchema();

  this.refresh = function(){
    self.updateParticipants();
    self.updateCurrentParticipant();
  }

  var participants, sites, countsByStatusBySite;
  this.participants = function(){
    return participants;
  };
  this.sites = function(){
    return sites;
  };
  this.countsByStatusBySite = function(){
    return countsByStatusBySite;
  };

  this.updateParticipants = function(){
    participants = undefined;
    //TODO pull out /db/
    db.getAllKeysForAllParticipants(headerKeys, function(results) {
      participants = results;
      updateCounts();
    });
  };

  function updateCounts() {
    var countsByStatusAndSite = _.countBy(participants, function(row) {
      //TODO extract this constant
      return row.status + ',' + row['site'];
    });
    var counts = {};
    sites = [];
    _.each(countsByStatusAndSite, function(count, statusAndSite) {
      statusAndSite = statusAndSite.split(',');
      if (!counts[statusAndSite[0]]) {
        counts[statusAndSite[0]] = {};
      }
      if (sites.indexOf(statusAndSite[1]) === -1) {
        sites.push(statusAndSite[1]);
      }
      counts[statusAndSite[0]][statusAndSite[1]] = count;
    });
    countsByStatusBySite = counts;
  }

  var currentParticipant, logbook;
  this.currentParticipant = function(){
    return currentParticipant;
  }
  this.logbook = function(){
    return logbook;
  }

  this.updateCurrentParticipant = function() {
    currentParticipant = undefined;
    logbook = undefined;
    var participantId = self.getParticipantId();
    if (!participantId) {
      return;
    }
    //TODO extract $http
    var url = '/db/participants/' + participantId + '?logKeys=' + logKeys;
    $http.get(url).success(function(details) {
      currentParticipant = details.participant;
      logbook = details.logbook[participantId];
    });
  };
  this.setParticipantId = function(id) {
    $location.search('participantId', id);
    self.updateCurrentParticipant();
  };
  this.getParticipantId = function() {
    return $location.search().participantId;
  };
  this.set = function(key, value, callback){
    db.set(key, value, self.getParticipantId(), loginModel.getUserName(), callback)
  };
  this.clear = function(surveyName, done) {
    var keysToDelete = [];
    var keysDeleted = 0;
    _.each(_.keys(currentParticipant), function(key) {
      if (key.indexOf(surveyName + '.') === 0) {
        keysToDelete.push(key);
      }
    });

    function clearComplete() {
      keysDeleted++;
      //TODO generalize this logic
      if (keysToDelete.length + 2 == keysDeleted) {
        if(surveyName === 'useHistory'){
          self.clear('tfb', done);
        }else{
          self.refresh();
          done();
        }
      }
    }

    self.set('survey.clear', surveyName, clearComplete);
    self.set('survey.page.' + surveyName, '!clear', clearComplete);
    _.each(keysToDelete, function(key) {
      self.set(key, undefined, clearComplete);
    });
  };

  this.addParticipant = function(site, siteId){
    db.addParticipant(site, siteId, loginModel.getUserName(),
        survey.schema().initialStatus, function(participantId){
      self.setParticipantId(participantId);
      self.updateParticipants();
    });
  };

  //update
  var needsUpdate = false, isDataBehind = false, hasNewData = false;
  function checkForUpdate() {
    $http.get('/is_updated').success(function(response) {
      if (response === 'true') {
        needsUpdate = false;
      } else if (response === 'false') {
        needsUpdate = true;
      }
    });
  }
  this.doesNeedUpdate = function() {
    return needsUpdate;
  };
  this.dataBehind = function(){
    return isDataBehind && ! hasNewData;
  };
  this.newData = function(){
    return hasNewData;
  };
  function checkData(){
    $http.get('/db/meta/hasNonCopied').success(function(response){
      hasNewData = response === 'true';
    });
    $http.get('/db/meta/lastUpdated').success(function(response){
      response = response || '';
      var lastUpdated = parseFloat(response.replace('"', ''));
      var now = new Date().getTime();
      if(!lastUpdated || (lastUpdated - now > 1000 * 60 * 60 * 8)){ //8hrs ago
          isDataBehind = true;
      }else{
        isDataBehind = false;
      }
    });
  };
  checkData();
  $interval(checkData, 2000);

  $interval(checkForUpdate, 60 * 1000);
  checkForUpdate();
});
