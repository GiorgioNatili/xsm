//maximum number of days to inquire about use in daily format
DAILY_USE_MAX_DAYS = 20;
SUBSTANCES = ['alcohol', 'pot', 'tobacco'];
SUBSTANCES_AND_EVENTS = ['alcohol', 'pot', 'tobacco', 'event', 'iceCream'];
HITS = ['drink', 'hit', 'cigarette'];
OTHER_SUBSTANCES = [
  'meth',
  'cocaine',
  'LSD',
  'heroin'
];

STANDARD_EVENTS = [
  'Birthday',
  'Prom',
  'Party',
  'Vacation'
];

csmModule = angular.module('csm');

csmModule.controller('loadingCtrl', function($scope, tfbModel) {
  $scope.isLoading = tfbModel.isLoading;
});

csmModule.controller('tfbCtrl', function($scope, $http, $timeout, tfbModel, router) {
  function load(){
    if(tfbModel.isLoading()){
      $timeout(load, 50);
    }else{
      start($scope, $http, tfbModel, router);
    }
  }
  load();
});

function start($scope, $http, model, router){
  function getUseDays(key){
    return parseInt(model.get('useHistory.' + key + 'YrDays') || 0);
  }
  //WARNING: this might break back behavior
  function getSubstanceUseDays(substance){
    if(substance == 'alcohol'){
      return getUseDays('Alc');
    }else if(substance == 'pot'){
      return getUseDays('MJ');
    }else if(substance == 'tobacco'){
      return getUseDays('Cig') + getUseDays('Chew');
    }else if(substance == 'other'){
      return getUseDays('Rx') + getUseDays('Drug');
    }else{
      throw 'unexpected substance:' + substance;
    }
  }

  $scope.a = {};

  $scope.substances = SUBSTANCES.slice(0);
  $scope.multipliers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
  $scope.otherSubstances = OTHER_SUBSTANCES;
  $scope.standardEvents = STANDARD_EVENTS;
  var record = true;
  var inAdditional = false;
  var useReported = false;

  $scope.startsWith = function(actual, expected) {
    var lowerStr = (actual + "").toLowerCase();
    return lowerStr.indexOf(expected.toLowerCase()) === 0;
  };

  var markedWeek, markedYear, daysOfMarkedWeek;

  function weekMarked(date) {
    return date.week() == markedWeek && date.year() == markedYear;
  }

  $scope.weekSelected = function() {
    return !!markedWeek;
  };
  var today = moment();
  var oneYearAgo = today.clone().subtract(1, 'year');
  $scope.startDate = oneYearAgo.format('MMMM DD, YYYY');
  var startMonth = oneYearAgo.clone().set('date', 1);
  var calendar = {};
  $scope.months = [];
  for (var monthOffset = 0; monthOffset < 13; monthOffset++) {
    var month = {};
    var monthDate = startMonth.clone().add(monthOffset, 'months');
    month.title = monthDate.format('MMMM YYYY');
    month.key = monthOffset + '';
    month.firstDay = monthDate.clone();
    month.weeks = [];
    for (var weekOffset = 0; weekOffset < 6; weekOffset++) {
      var week = {};
      week.key = monthOffset + '-' + weekOffset;
      week.days = [];
      for (var dayOffset = 0; dayOffset < 7; dayOffset++) {
        var day = {};
        var date = monthDate.clone().add(weekOffset, 'weeks');
        date.weekday(dayOffset);

        day.outOfRange = date.isBefore(oneYearAgo) || date.isAfter(today);
        day.outOfMonth = date.month() !== monthDate.month();

        day.isWeekend = dayOffset === 0 || dayOffset === 6;
        day.isNull = day.outOfRange || day.outOfMonth;
        day.title = date.date();
        day.date = date;
        day.weekMarked = _.bind(weekMarked, _, date);
        key = date.format('MM/DD/YY');
        if (!calendar[key]) {
          calendar[key] = {};
        }
        day.data = calendar[key];
        day.key = monthOffset + '-' + weekOffset + '-' + dayOffset;

        if (day.outOfMonth && dayOffset === 0 && weekOffset > 4) {
          break;
        } else {
          week.days.push(day);
        }
      }
      month.weeks.push(week);
    }
    $scope.months.push(month);
    $scope.days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
  }

  var context = [];
  var dayClickHandler, weekClickHandler, monthClickHandler;
  $scope.question = '';
  $scope.editMode = 'remove';
  $scope.tapped = false;

  function question(value, showCalendar) {
    $scope.question = value;
    $scope.showCalendar = showCalendar;
    if (record) {
      window.setTimeout(function() { //bugs up if called inside digest loop
        $('.overlay-wrap').effect("bounce", {
          times: 2,
          distance: -80
        }, 500);
        $('input').focus();
      }, 10);
    }
  }

  function setDayClickHandler(fn) {
    $scope.tapped = false;
    $scope.selectionEnabled = !! fn;
    dayClickHandler = fn;
  }

  function setWeekClickHandler(fn) {
    $scope.tapped = false;
    $scope.weekSelectionEnabled = !! fn;
    weekClickHandler = fn;
  }

  function setMonthClickHandler(fn) {
    $scope.tapped = false;
    $scope.monthSelectionEnabled = !! fn;
    monthClickHandler = fn;
  }

  $scope.a.dayClicked = function(day) {
    if (dayClickHandler) {
      $scope.tapped = true;
      day = day.split('-');
      dayClickHandler(
        $scope.months[parseInt(day[0])].weeks[parseInt(day[1])].days[parseInt(day[2])]
      );
    }
  };
  $scope.a.weekClicked = function(week) {
    if (weekClickHandler) {
      $scope.tapped = true;
      week = week.split('-');
      weekClickHandler(
        $scope.months[parseInt(week[0])].weeks[parseInt(week[1])]
      );
    }
  };
  $scope.a.monthClicked = function(month) {
    if (monthClickHandler) {
      $scope.tapped = true;
      monthClickHandler($scope.months[parseInt(month)]);
    }
  };

  function stripEvent(e) {
    //strip up to first ", " or entire string if no comma
    return e.replace(/^.*?((, )|($))/, '');
  }

  $scope.a.addEvent = function() {
    $scope.eventText = '';
    question('promptEventText', false);
    $scope.error = false;
  };
  $scope.a.tapToAddEvent = function(eventText) {
    $scope.eventText = eventText;
    if (eventText.trim()) {
      $scope.error = false;
      question('tapToAddEvent', true);
      setDayClickHandler(function(day) {
        if (eventText === '') {
          return;
        }
        var e = day.data.event;
        if (e) {
          if (e.indexOf(eventText) === 0) {
            day.data.event = stripEvent(e);
            return;
          }
          e = ", " + e;
        } else {
          e = '';
        }
        day.data.event = eventText + e;
      });
    } else {
      $scope.error = true;
    }
  };
  $scope.a.removeEvent = function() {
    question('removeEvent', true);
    setDayClickHandler(function(day) {
      var e = day.data.event;
      if (e) {
        day.data.event = stripEvent(e);
      }
    });
  };
  $scope.a.gotoStart = function() {
    gotoStart();
  };

  function gotoStart() {
    setDayClickHandler(undefined);
    question('start', true);
  }

  $scope.a.startSubstance = function(substance, hit) {
    startSubstance(substance, hit);
  };

  function startSubstance(substance, hit) {
    if (!substance) {
      if (!$scope.substance) {
        substance = SUBSTANCES[0];
        hit = HITS[0];
      } else {
        index = SUBSTANCES.indexOf($scope.substance);
        if (index != -1) {
          substance = SUBSTANCES[index + 1];
          hit = HITS[index + 1];
        }
      }
    }
    $scope.substanceDays = '';
    setDayClickHandler();
    setWeekClickHandler();
    markedWeek = markedYear = daysOfMarkedWeek = undefined;
    $scope.substance = substance;
    $scope.hit = hit;
    $scope.error = false;

    //skip this question and go directly to correct branch
    //of days entered if this is a known substance
    if(!substance){
      if(getSubstanceUseDays('other') == 0){
        if(!useReported){
          $scope.substance = 'iceCream';
          promptUseDays();
        }else{
          promptCheck();
        }
      }else{
        if(inAdditional){
          question('usedOther', false);
        }else{
          promptOther();
          inAdditional = true;
        }
      }
    }else if(_.contains(SUBSTANCES, substance)){
      daysEntered(getSubstanceUseDays(substance));
    }else{
      question('howManyDays', false);
    }
  }

  $scope.a.daysEntered = function(days) {
    daysEntered(days);
  };
  function daysEntered(days){
    days = parseInt(days);
    if (days) {
      $scope.error = false;
      if (days > DAILY_USE_MAX_DAYS) {
        promptUseWeeks();
      } else {
        promptUseDays();
      }
    } else if (days === 0) {
      $scope.error = false;
      startSubstance();
    } else {
      $scope.error = true;
    }
  }
  $scope.$watch('hitMultiplier', function(newValue, oldValue) {
    if (newValue !== oldValue) {
      $scope.a.setHitMultipler(newValue);
    }
  });
  $scope.a.setHitMultipler = function(hitMultiplier) {
    $scope.hitMultiplier = hitMultiplier;
  };

  function setupDayUseHandler() {
    $scope.hitMultiplier = 1;
    setDayClickHandler(function(day) {
      useReported = true;
      if (markedWeek && !day.weekMarked()) {
        return;
      }
      var multiplier = $scope.hitMultiplier;
      var substance = $scope.substance;
      if (day.data[substance]) {
        day.data[substance] += multiplier;
      } else {
        day.data[substance] = multiplier;
      }
    });
  }

  function scrollToBottom() {
    window.setTimeout(function() {
      var endTag = $("#end");
      if (endTag.offset()) {
        $('html,body').animate({
          scrollTop: endTag.offset().top
        }, 'fast');
      } else {
        scrollToBottom();
      }
    });
  }

  function promptUseDays() {
    $scope.error = false;
    scrollToBottom();
    if($scope.substance !== 'iceCream'){
      question('promptUseOnDays', true);
      setupDayUseHandler();
    }else{
      question('iceCream', true);
      setDayClickHandler(function(day) {
        if (day.data.iceCream) {
          day.data.iceCream += 1;
        } else {
          day.data.iceCream = 1;
        }
        console.log(day.data);
      });
    }
  }

  $scope.a.fixDayUseMistakes = function() {
    if($scope.substance == 'iceCream'){
      $scope.fixPrompt = 'ice cream consumption';
    }else{
      $scope.fixPrompt = $scope.substance + ' use';
    }
    question('fixDayUse', true);
    $scope.error = false;
    setDayClickHandler(function(day) {
      if (markedWeek && !day.weekMarked()) {
        return;
      }
      substance = $scope.substance;
      day.data[substance] = 0;
      console.log(day.data);
    });
  };

  $scope.a.resumeDayUse = function() {
    promptUseDays();
    $scope.tapped = true;
  };

  function setupUseWeekClickHandler() {
    setWeekClickHandler(function(week) {
      setWeekClickHandler(undefined);
      markedWeek = week.days[0].date.week();
      markedYear = week.days[0].date.year();
      question('markUseOnWeek', true);
      $scope.weekMode = true;
      setupDayUseHandler();
      daysOfMarkedWeek = week.days;
    });
  }

  function promptUseWeeks() {
    question('selectLastWeek', true);
    scrollToBottom();
    setupUseWeekClickHandler();
  }

  $scope.a.backToSelectWeek = function() {
    setDayClickHandler();
    setWeekClickHandler();
    for (var i = 0; i < 7; i++) {
      daysOfMarkedWeek[i].data[$scope.substance] = 0;
    }
    markedWeek = markedYear = daysOfMarkedWeek = undefined;
    $scope.weekMode = false;
    promptUseWeeks();
  };

  $scope.a.markRepeats = function() {
    $scope.weekMode = false;
    question('markRepeats', true);
    setDayClickHandler();
    setWeekClickHandler(function(week) {
      var weekEqual = 0;
      for (var i = 0; i < 7; i++) {
        if (week.days[i].data[$scope.substance] !== daysOfMarkedWeek[i].data[$scope.substance]) {
          weekEqual = 1;
        }
      }
      for (var i = 0; i < 7; i++) {
        if (daysOfMarkedWeek[i].data !== week.days[i].data) {
          if (daysOfMarkedWeek[i].data[$scope.substance] !== undefined) {
            week.days[i].data[$scope.substance] = weekEqual * daysOfMarkedWeek[i].data[$scope.substance];
          } else {
            week.days[i].data[$scope.substance] = undefined;
          }
        }
      }
    });
    setMonthClickHandler(function(month) {
      var date = month.firstDay.clone();
      var monthEqual = 0;
      do {
        if (calendar[date.format('MM/DD/YY')][$scope.substance] !==
          daysOfMarkedWeek[date.weekday()].data[$scope.substance]) {
          monthEqual = 1;
        }
        date.add(1, 'day');
      } while (month.firstDay.month() == date.month());
      var date = month.firstDay.clone();
      do {
        if (calendar[date.format('MM/DD/YY')] !== daysOfMarkedWeek[date.weekday()].data) {
          if (daysOfMarkedWeek[date.weekday()].data[$scope.substance] !== undefined) {
            calendar[date.format('MM/DD/YY')][$scope.substance] =
              monthEqual * daysOfMarkedWeek[date.weekday()].data[$scope.substance];
          } else {
            calendar[date.format('MM/DD/YY')][$scope.substance] = undefined;
          }
        }
        date.add(1, 'day');
      } while (month.firstDay.month() == date.month());
    });
  };
  $scope.a.repeatPromptUseWeeks = function() {
    question('selectLastWeekAgain', true);
    setupUseWeekClickHandler();
    setMonthClickHandler();
  };
  $scope.a.promptOther = promptOther;
  function promptOther(){
    $scope.error = false;
    question('selectOtherSubstance', false);
  }
  $scope.a.enterOther = function(other) {
    if (other) {
      $scope.error = false;
      startSubstance(other, 'dose');
    } else {
      $scope.error = true;
    }
  };
  $scope.hasOther = function(day) {
    return $scope.countOther(day) !== 0;
  }
  $scope.countOther = function(day) {
    return _.reduce(_.omit(day, SUBSTANCES_AND_EVENTS), function(memo, value) {
      return memo + (value || 0);
    }, 0);
  };
  $scope.a.promptCheck = function() {
    promptCheck();
  };
  function promptCheck(){
    question('checkCalendar', true);
    setDayClickHandler();
  }
  $scope.$watch('editMode', function(newValue, oldValue) {
    if (newValue !== oldValue) {
      $scope.a.setEditMode(newValue);
    }
  });
  $scope.a.setEditMode = function(editMode) {
    $scope.editMode = editMode;
  };
  $scope.a.promptEdit = function() {
    question('promptEdit', false);
  };
  $scope.a.promptRemove = function() {
    question('promptRemove', true);
    setDayClickHandler(function(day) {
      _.each(day.data, function(value, key) {
        day.data[key] = undefined;
      });
    });
  };
  $scope.a.promptAdd = function(substance) {
    $scope.substance = substance;
    question('promptAdd', true);
    setDayClickHandler(function(day) {
      useReported = true;
      if (day.data[substance]) {
        day.data[substance]++;
      } else {
        day.data[substance] = 1;
      }
    });
  };
  $scope.a.confirmClear = function() {
    question('confirmClear', true);
  };
  $scope.a.restart = function() {
    _.each($scope.months, function(month) {
      _.each(month.weeks, function(week) {
        _.each(week.days, function(day) {
          _.each(day.data, function(value, key) {
            day.data[key] = undefined;
          });
        });
      });
    });
    addHolidays();
    gotoStart();
  };
  $scope.finish = function() {
    //have to open window first b/c time delay triggers popup blocker
    //TODO optimize away time delay
    router.open(model.getNextSurvey(), model.getParticipantId());

    var calendarCollapsed = {};
    _.each(calendar, function(val, key) {
      if (!_.isEmpty(val)) {
        calendarCollapsed[key] = val;
      }
    });
    model.set('tfb-full', JSON.stringify(calendarCollapsed));
    computeTFBVars(model, calendar);
  };

  function logAction(value) {
    model.set('survey.page.tfb', value);
  };

  function encodeActionValue(name, parameter) {
    if (parameter === undefined) {
      return name;
    } else {
      return JSON.stringify({
        n: name,
        p: parameter
      });
    }
  }

  function decodeActionValue(value) {
    if (value[0] === '{') {
      return JSON.parse(value);
    } else {
      return {
        n: value,
        p: undefined
      };
    }
  };

  _.each($scope.a, function(fn, name) {
    $scope.a[name] = function(arg) {
      if (record === true) {
        logAction(encodeActionValue(name, arg));
      }
      fn(arg);
    };
  });

  var holidays;

  function addHolidays() {
    _.each(holidays, function(event_, date) {
      date = calendar[moment(date).format('MM/DD/YY')];
      if (date) {
        date.event = event_;
      }
    });
  };
  //TODO extract
  $http.get('/tfb/holidays.json').success(function(data) {
    holidays = data;
    addHolidays();
  });
  gotoStart();

  var logbook = model.getLog();
  logbook = _.pluck(logbook, 'a');
  var clearIndex = _.lastIndexOf(logbook, '!clear');
  logbook = _.rest(logbook, clearIndex + 1);

  record = false;
  _.each(logbook, function(action) {
    action = decodeActionValue(action);
    $scope.a[action.n](action.p);
  });
  record = true;
}

csmModule.directive('enter', function() {
  return function(scope, element, attrs) {
    element.bind("keydown keypress", function(event) {
      if (event.which === 13) {
        scope.$apply(function() {
          scope.$eval(attrs.enter, {
            'event': event
          });
        });

        event.preventDefault();
      }
    });
  };
});

function sum(memo, num){ return memo + num; };

function computeTFBVars(model, calendar){
  var dayCutoffs = {
    '90':moment().subtract(91, 'days'),
    '360':moment().subtract(361, 'days'),
    '12m':moment().subtract(1, 'year').subtract(1, 'day')
  }, amountTxs = {
    'Days':function(quants){
      return _.isEmpty(quants) ? 0 : 1;
    },
    'Quant':function(quants){
      return _.reduce(quants, sum, 0);
    }
  }, subsPredicates = {
    'alc':function(subs){
      return _.pick(subs, 'alcohol');
    },
    'mj':function(subs){
      return _.pick(subs, 'pot');
    },
    'tob':function(subs){
      return _.pick(subs, 'tobacco');
    },
    'oth':function(subs){
      return _.omit(subs, SUBSTANCES_AND_EVENTS);
    },
    'subs':function(subs){
      return _.omit(subs, ['event', 'tobacco', 'iceCream']);
    },
    'mjOth':function(subs){
      return _.omit(subs, ['event', 'tobacco', 'alcohol', 'iceCream']);
    }
  };

  _.each(dayCutoffs, function(dayCutoffMoment, dayCutoffName){
    _.each(amountTxs, function(amountTxFn, amountTxName){
      _.each(subsPredicates, function(subsPredicateFn, subsPredicateName){
        var key = 'tfb.' + subsPredicateName + amountTxName + dayCutoffName;
        var val = 0;
        _.each(calendar, function(subs, day){
          day = moment(day, 'MM/DD/YY');
          if(day.isAfter(dayCutoffMoment) && day.isBefore(moment())){
            val += amountTxFn(_.compact(_.values(subsPredicateFn(subs))));
          }
        });
        model.set(key, val);
      });
    });
  });
}
