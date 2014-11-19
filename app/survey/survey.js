csmModule = angular.module('csm');

csmModule.controller('loadingCtrl', function($scope, surveyModel) {
  $scope.isLoading = surveyModel.isLoading;
});

csmModule.controller('surveyCtrl', function($scope, $sce, $timeout, surveyModel, router) {
  $scope.trust = $sce.trustAsHtml;
  surveyModel.load();
  function load(){
    if(surveyModel.isLoading()){
      $timeout(load, 50);
    }else{
      startSurvey($scope, $sce, surveyModel, router);
      document.title = surveyModel.getSchema().title + ' Survey - CSM';
    }
  }
  load();
});


csmModule.controller('numpadCtrl', function($scope) {
  $scope.press = function(digit){
    var v = $scope.question.value || "";
    v += "" + digit;
    $scope.question.value = parseFloat(v);
  };
  $scope.delete = function(){
    var v = $scope.question.value + "";
    if(v.length > 0){
      v = v.substring(0, v.length - 1);
    }
    $scope.question.value = parseFloat(v);
  }
});


function startSurvey($scope, $sce, model, router) {
  $scope.survey = model.getSchema();

  var currentWatchDeregs = [];

  //vary page by page
  $scope.page = undefined;
  $scope.hasErrors = undefined;
  $scope.nextVisible = true;
  $scope.nextQuestions = function(noHistory) {
    $scope.hasErrors = validate($scope.page.questions);
    if ($scope.hasErrors) {
      return;
    }
    leavePage();
    if (!noHistory) {
      model.getBackStack().push($scope.page.name);
    }
    var nextPage = computeNextPage();
    if(nextPage === 'Done!'){
      router.open(model.getSchema().next, model.getParticipantId());
    }else{
      loadPage(nextPage);
      if($scope.page.type !== 'function'){
        model.set('survey.page.' + model.getSchema().name, nextPage, false);
      }
    }
  };
  $scope.prevQuestions = function() {
    leavePage();
    model.set('survey.page.' + model.getSchema().name, '!back', false);
    loadPage(model.getBackStack().pop());
  };
  $scope.hasBack = function() {
    return model.getBackStack().length !== 0;
  };

  function validate(questions) {
    if(!questions){
      return false;
    }
    var errors = false;
    _.each(questions, function(question, index) {
      value = model.getAnswer(question.name);
      if (value === undefined || value === null || value === '') {
        if (question.required == 'required') {
          question.error = '*Required';
          errors = true;
        } else if (question.required == 'warning') {
          if (!question.error) {
            question.error = '* Please answer this question or press "next >" to continue.';
            errors = true;
          }
        } else {
          question.error = '';
        }
      } else {
        if ((question.type == 'numeric' || question.type == 'numpad') && !/^\d+$/.test(value)) {
          question.error = '*Please enter a number';
        }
      }
    });
    return errors;
  }

  function leavePage() {
    _.map(currentWatchDeregs, function(dereg) {
      dereg();
    });
    _.each($scope.page.questions, function(question) {
      question.error = '';
    });
  }

  function computeNextPage() {
    var pageBranching = $scope.page.branching || {};
    var next = model.findPage($scope.page.name) || 'Done!';
    if(pageBranching.type == 'simple') {
      if ($scope.page.type == 'page') {
        val = '';
      } else {
        val = model.getAnswer($scope.page.questions[0].name);
      }
      if(pageBranching.value == val || pageBranching.value == '*'){
        return pageBranching.target;
      }
    }else if(pageBranching.type == 'complex'){
      var branchingFn = model.getSurveyBranching(pageBranching.fn);
      if (branchingFn === undefined) {
        alert('couldnt find branching logic for "' + $scope.page.name + '"');
      }
      return branchingFn(model.getParticipant()) || next;
    }
    return next;
  }

  function loadPage(pageTitle) {
    $scope.nextVisible = true;
    $scope.page = _.findWhere(
      model.getSchema().pages,
      {name: pageTitle}
    );
    if (!$scope.page) {alert("couldnt find page '" + pageTitle + "'"); return;}
    if($scope.page.type == 'function'){
        $scope.nextVisible = false;
        if (!model.getSurveyFunction($scope.page.fn)) {
          alert('couldnt find function ' + $scope.page.fn);
        }
        model.getSurveyFunction($scope.page.fn)(model, function() {
          $scope.nextQuestions(true);
        });
    }else if($scope.page.type == 'page'){
      $scope.bodyHTML = $sce.trustAsHtml(replaceTokens($scope.page.body));
    }else{
      if($scope.page.type != 'questions'){
        throw 'unexpected page type: ' + $scope.page.type;
      }
      if ($scope.page.questions.length === 1) {
        window.setTimeout(function() {
          $('input[type=text],input[type=number],input[type=date]').focus();
        }, 50);
      }
      _.each($scope.page.questions, function(question, questionIndex) {
        question.textHTML = $sce.trustAsHtml(replaceTokens(question.text));
        if(question.header){
          question.headerHTML = $sce.trustAsHtml(question.header);
        }
        var initialValue = model.getAnswer(question.name);
        if (model.getSchema().type == 'simpleQuestions') {
          initialValue = undefined;
        }
        if (question.type == 'check' ) {
          initialValue = setupChecks(initialValue, question.options, questionIndex);
        } else {
          if ((question.type == 'numeric' || question.type == 'numpad') && initialValue) {
            initialValue = parseFloat(initialValue);
          }
          if(question.type == 'date' && initialValue){
            initialValue = moment(initialValue, 'YYYY-MM-DD').format('MM/DD/YYYY');
          }
          setupSimpleField(questionIndex);
        }
        question.value = initialValue;
        if(question.hasOther){
          setupOtherField(questionIndex);
        }
      });
    }
  }
  function replaceTokens(text) {
    text = replaceOneToken(text, 'CurrentMonth', moment().format('MMMM'));
    text = replaceOneToken(text, 'AlcDays1y', model.get('tfb.alcDays12m'));
    text = replaceOneToken(text, 'AlcDays90', model.get('tfb.alcDays90'));
    text = replaceOneToken(text, 'MJDrugDays90', model.get('tfb.mjOthDays90'));
    text = replaceOneToken(text, 'MJDrugDays1y', model.get('tfb.mjOthDays12m'));
    text = replaceOneToken(text, 'Doctor', model.get('doctor'));
    text = replaceOneToken(text, 'bingeNumber', model.get('screen.bingeNumber'));
    text = replaceOneToken(text, 'CRAFFTScore', model.get('screen.CRAFFTScore'));
    text = replaceOneToken(text, 'riskLevel', model.get('screen.risk'));
    text = replaceOneToken(text, 'DriverUse', model.get('assess.DriverWords'));
    return text;
  }
  function replaceOneToken(text, token, value){
    return text.replace('%' + token, value);
  }
  function nextSurvey() {
    model.set('survey.done', model.getSchema().name, false);
  }

  function setupChecks(initialValue, options, questionIndex) {
    if (initialValue) {
      initialValue = initialValue.split(';');
    } else {
      initialValue = [];
    }
    var ret = [];
    $scope.page.questions[questionIndex].showOther = _.contains(initialValue, 'Other');
    _.each(options, function(option, checkIndex) {
      ret[checkIndex] = initialValue.indexOf(option) != -1;

      watch = 'page.questions[' + questionIndex + '].value[' + checkIndex + ']';
      dereg = $scope.$watch(watch, function(newValue, oldValue) {
        if (oldValue === newValue) {
          return;
        }
        var question = $scope.page.questions[questionIndex];
        var value = question.value;
        value = combineCheckedOptions(question.options, value);
        if(question.options[checkIndex] == 'Other'){
          question.showOther = newValue;
        }
        model.setAnswer(question.name, value, false);
      });
      currentWatchDeregs.push(dereg);
    });
    return ret;
  }
  function setupOtherField(questionIndex) {
    var question = $scope.page.questions[questionIndex];
    question.otherValue = model.getAnswer(question.name + '-other');
    var dereg = $scope.$watch('page.questions[' + questionIndex + '].otherValue',
      function(newValue, oldValue) {
        if (oldValue === newValue) {
          return;
        }
        model.setAnswer(question.name + '-other', newValue, true);
      });
    currentWatchDeregs.push(dereg);
  }
  $scope.checkSelected = function(question, option){
    return question.value[question.options.indexOf(option)];
  };
  $scope.radioSelected = function(question, option){
    return question.value === option;
  };
  $scope.selectCheck = function(question, option){
    //UNCLEAR why isnt this implemented?
  };
  $scope.selectRadio = function(question, option){
    question.value = option;
  };

  function setupSimpleField(questionIndex) {
    var question = $scope.page.questions[questionIndex];
    var dereg = $scope.$watch('page.questions[' + questionIndex + '].value',
      function(newValue, oldValue) {
        if(question.hasOther){
          question.showOther = newValue == 'Other';
        }
        if (oldValue === newValue) {
          return;
        }
        if(question.type == 'date'){
          newValue = moment(newValue, 'MM/DD/YYYY');
          if(newValue.year() > 1914){
            newValue = newValue.format('YYYY-MM-DD');
          }else{
            newValue = undefined;
          }
        }
        model.setAnswer(question.name, newValue,
          question.type == 'text' ||
          question.type == 'numeric' ||
          question.type == 'numpad' ||
          question.type == 'date');
        if (model.getSchema().type == 'simpleQuestions') {
          $scope.nextQuestions();
        }
    });
    currentWatchDeregs.push(dereg);
  }
  model.set('survey.start', model.getSchema().name, false);
  loadPage(model.getBackStack().pop());
}

function combineCheckedOptions(options, checks) {
  var value = [];
  _.each(checks, function(checked, index) {
    if (checked) {
      value.push(options[index]);
    }
  });
  return value.join(';');
}

function digitsOnly(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode(key);
  var regex = /[0-9]|\./;
  if (!regex.test(key)) {
    theEvent.returnValue = false;
    if (theEvent.preventDefault) theEvent.preventDefault();
  }
}
