csmModule = angular.module('csm');

csmModule.controller('rosterCtrl', function($scope, $filter, $timeout, $modal, model, loginModel, router) {
  $scope.logout = loginModel.logout;
  $scope.user = loginModel.getUserName;

  $scope.headers = model.headers;

  $scope.loading = function() {
    return $scope._loading || !model.participants;
  };
  $scope.newData = model.newData;
  $scope.dataBehind = model.dataBehind;
  $scope.schema = model.schema;
  $scope.getParticipantId = model.getParticipantId;
  $scope.currentParticipant = model.currentParticipant;
  $scope.logbook = model.logbook;
  $scope.sites = model.sites;
  $scope.countsByStatusBySite = model.countsByStatusBySite;

  $scope.reverse = false;
  $scope.order = 'status';

  $scope.searchBy = function(value) {
    if ($scope.searchText) {
      $scope.searchText += ' ' + value;
    } else {
      $scope.searchText = value;
    }
  };
  $scope.orderBy = function(attribute) {
    $scope._loading = true;
    $timeout(function() {
      if ($scope.order == attribute) {
        $scope.reverse = !$scope.reverse;
      } else {
        $scope.order = attribute;
        $scope.reverse = false;
      }
      $scope._loading = false;
    }, 500);
  };

  $scope.queryDetails = function(id) {
    model.setParticipantId(id);
  };

  var callsPending = 0;
  $scope.$watch('searchText', function() {
    $scope._loading = true;
    callsPending++;
    $timeout(function() {
      callsPending--;
      if (callsPending === 0) {
        $scope._loading = false;
      }
    }, 500);
  });

  $scope.filteredParticipants = function() {
    if ($scope._loading) {
      return undefined;
    }
    var ret = model.participants();
    if (ret) {
      ret = _.map(ret, _.identity);
      var query = $scope.searchText;
      if (query) {
        _.each(query.split(/[, ]/g), function(term) {
          ret = $filter("filter")(ret, term);
        });
      }
      ret = _.sortBy(ret, $scope.order);
      if ($scope.reverse) {
        ret.reverse();
      }
    }
    $scope.showOverflow = ret && ret.length > 150;
    return ret;
  };

  $scope.addContact = function() {
    $modal({
      template: '/roster/contact.html'
    });
  };

  $scope.addParticipant = function() {
    $modal({
      template: '/roster/create.html'
    });
  };
  $scope.isEnabled = function(survey) {
    var status = model.currentParticipant().status;
    if (!model.schema().statuses[status]) {
      console.log('status: ' + status + 'not defined!');
      return true;
    }
    return model.schema().statuses[status][survey.name];
  };

  $scope.runSurvey = function(survey) {
    loginModel.softLogout();
    router.open(survey.name, model.getParticipantId());
  };
  $scope.needsUpdate = model.doesNeedUpdate;

  $scope.clearSurvey = function() {
    $modal({
      template: '/roster/clear.html'
    });
  };
  $scope.needs_update = undefined;

  $scope.editField = function(label, key) {
    if(key === 'id'){
      return;
    }
    $scope.label = label;
    $scope.key = key;
    $modal({
      template: '/roster/edit.html',
      scope: $scope
    });
  };

  var showMoreDetails = false;
  $scope.detailsMoreOrLess = function(){
    return showMoreDetails ? 'Less' : 'More';
  };
  $scope.toggleDetails = function(){
    showMoreDetails = !showMoreDetails;
  };
  $scope.detailsFeilds = function(){
    var fields = model.detailsSchema();
    if(!showMoreDetails){
      fields = _.where(fields, {section:'details1'});
    }
    return fields;
  };
});

csmModule.controller('clearCtrl', function($scope, model) {
  $scope.schema = model.schema();
  $scope.clear = function(survey) {
    $scope.clearing = true;
    model.clear(survey.name, function() {
      $scope.clearing = false;
      $scope.$hide();
    });
  };
});

csmModule.controller('editCtrl', function($scope, model) {
  $scope.value = model.currentParticipant()[$scope.key];

  $scope.maybeEnter = function(evt, key, value) {
    if (evt.which === 13) {
      $scope.set(key, value);
    }
  };
  $scope.set = function(key, value) {
    model.set(key, value, function() {
      model.refresh();
    });
    $scope.$hide();
  };
});

csmModule.controller('contactCtrl', function($scope, model) {
  var defEntryType = 'email';
  $scope.logEntryType = 'email';
  $scope.allLogEntryTypes = model.logEntryTypes;
  $scope.submitLogEntry = function(logEntry, logEntryType) {
    $scope.logEntry = '';
    $scope.logEntryType = defEntryType;
    model.set('contact.' + logEntryType, logEntry, function() {
      model.updateCurrentParticipant();
      $scope.$hide();
    });
  };
});

csmModule.controller('createCtrl', function($scope, $http, model) {
  //TODO extract $http into survey
  $http.get('/survey-schema/clinics.json').success(function(sites) {
    $scope.sites = sites;
  });
  $scope.submit = function() {
    if (!$scope.clinicSite) {
      return;
    }
    model.addParticipant($scope.clinicSite, $scope.sites[$scope.clinicSite]);
    $scope.$hide();
  };
});
