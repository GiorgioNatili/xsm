surveyFunctions = {};
surveyFunctions.getDoctorReportBtnClass = function(model) {
  if (model.getValue('screen.complete') == 'done') {
    return 'showBtn';  
  } else {
    return 'hideBtn';
  }
};
surveyFunctions.setStatusAfterVisit = function(model, callback) {
  var refused = model.get('demo.response');
  if (refused == "Refused") {
  	model.set('status', '03Refused', false, callback);
  }else{
  	//TODO: Set other statuses for refused
  	callback();
  }
};
surveyFunctions.setStatusAfterContact = function(model, callback) {
  model.set('status', '06No Screen', false);
  callback();
};
surveyFunctions.setVersionScreen = function(model, callback) {
  var gradeYr = grade(model.getParticipant());
  var ageYr = age(model.getParticipant());
  var gradeGr = gradeGroup(gradeYr);
  var bingeNumber = getBingeNumber(model.getParticipant());
  var setCount = 4;
  function done(){
    setCount--;
      if(setCount === 0){
        randomizeQuestions(model, callback);
      }
  } 
  model.set('screen.gradeGroup', gradeGr, false, done);
  model.set('screen.age', ageYr, false, done);
  model.set('screen.grade', gradeYr, false, done);
  model.set('screen.bingeNumber', bingeNumber, false, done);
};
function gradeGroup(gradeYr){
  if(gradeYr < 6){
    return 'elementary';
  }else if(gradeYr < 9){
    return 'middle';
  }else if(gradeYr <= 12){
    return 'high';
  }else{
    return 'post';
  }
}
surveyFunctions.setStatusAfterUseHistory = function(model, callback) {
  model.set('status', '08No TLFB', false, callback);
};
surveyFunctions.setRideWords = function(model, callback) {
  var p = model.getParticipant();
  var rideAlc = p['assess.RideDrink'];
  var rideDrug = p['assess.RideDrug'];
  var driverWords = 'drinking alcohol or using other drugs ever';
  if(rideAlc == 'Once' && rideDrug == 'Not at all') {
    rideWords = 'drinking alcohol';
  }
  else if(rideAlc == 'Not at all' && rideDrug == 'Once'){
    driverWords = 'using marijuana or other drugs';
  }
  else if ((rideAlc == 'Twice' || rideAlc == 'Three or more times') && rideDrug == 'Not at all') {
    driverWords = 'drinking alcohol ever';
  }
  else if ((rideDrug == 'Twice' || rideDrug == 'Three or more times') && rideAlc == 'Not at all') {
    driverWords = 'using marijuana or other drugs ever';
  }
  model.set('assess.driverWords', driverWords, false, callback);
};
surveyFunctions.riskLevel = function(model,callback) {
  callback();
};
surveyFunctions.setDoctorDemographics = function(model,callback) {
  var doctor =  getDoctor(model.getParticipant(), 'demo');
  model.set('demo.doctor', doctor, false, function(){
  model.set('doctor', doctor, false, callback);
  });
};
surveyFunctions.setVisitDoctor = function(model,callback) {
  var doctor =  getDoctor(model.getParticipant(), 'visit');
  model.set('demo.visitDoctor', doctor, false, function(){
    model.set('doctor', doctor, false, callback);
  });
};
surveyFunctions.setDoctorPost = function(model,callback) {
  var doctor =  getDoctor(model.getParticipant(), 'post');
  model.set('post.doctor', doctor, false, function(){
    model.set('doctor', doctor, false, callback);
  });
};
surveyFunctions.assignCondition = function(model, callback) {
  var p = model.getParticipant();  
  var CRAFFTScore = getCRAFFT(p);
  var RAFFTScore = getRAFFT(p);
  var risk;
  if (!hasAnyUse(p)){
    risk = 'LOW';
  }
  else if (gradeGroup(p) != 'elementary' &&
           getRAFFT(p) == 0 &&
           daysUsed(p, 'Tob') < 6 &&
           daysUsed(p, 'Alc') < 2 &&
           daysUsed(p, 'Mj') < 2 &&
           daysUsed(p, 'Drug') == 0 &&
           daysBinged(p) == 0){
    risk = 'MEDIUM';
  } else {
    risk = 'HIGH';
  }
  var setCount = 2;
  function done(){
    setCount--;
    if(setCount === 0){
      randomizeCondition(model,callback);
    }
  }
  model.set('screen.risk', risk, false, done);
  model.set('screen.CRAFFTScore', CRAFFTScore, false, done);
};
surveyFunctions.setComplete = function(model,callback){
  model.set('screen.complete', 'done', false, callback);
};
//sum up the values of an object
function sum(object) {
  accum = 0;
  _.each(object, function(val) {
    accum += val;
  });
  return accum;
}

//compute all keys whose value is the minimum among the object's values
function min(object) {
  var minValue = _.min(object);
  var ret = [];
  _.each(object, function(value, key) {
    if (value === minValue) {
      ret.push(key);
    }
  });
  return ret;
}

function getImbalanceScore(countByCondition, desiredRatios) {
  var numConditions = _.keys(countByCondition).length;
  var totalParticipants = sum(countByCondition);
  var marginals = _.map(countByCondition, function(count, condition) {
    return Math.abs((count / totalParticipants) - desiredRatios[condition]);
  });
  return sum(marginals) / (numConditions - 1);
}

function randomizeQuestions(model, done) {
  if (model.get('site') == 'TST' && model.get('demo.emergency1Phone') === '911') {   // for forcing to a known screen version when testing, set demo.emergency1Phone = '911'
    var testV = model.get('demo.emergency1Rela');                               // and demo.emergency1Rela to the desired randomization version of screen. 
    if(testV == 'A' || testV == 'B'){
      model.set('screen.version', testV, false, done);
    }
    else {
      alert("Test screen version: "+ testV + " is invalid in Demographics.emergency1Rela. \
        Set to A or B. Continuing with normal screen version randomization...");
    }
  }  
  computeRandomizationGroup(model, done, [
    'screen.grade',
    'demo.gender',
    'site'
  ], {
    'A': 1 / 2,
    'B': 1 / 2,
  }, 'screen.version');
}

function randomizeCondition(model, done) {
  if (!model.get('condition')){
    if (model.get('demo.emergency2Phone') === '911') {   // for forcing to a known condition when testing, set demo.emergency2Phone = '911'
      var testC = model.get('demo.emergency2Rela');                               // and demo.emergency2Rela to the desired randomization condition. 
      if(testC == 'control' || testC == 'control minimal' || testC == 'csba' || testC == 'vyou'){
        model.set('condition', testC, false, almostDone);
      }
      else {
        alert("Test condition: "+ testC + " is invalid in Demographics.emergency2Rela. \
          Set to control, control minimal, csba or vyou. Continuing with normal randomization...");
      }
    }
    function almostDone(){
      model.set('conditionDatetime', moment().format('YYYY-MM-DD, hh:mm:ss'), false, done);
    }
    var gradeYr = model.get('screen.grade');
    var risk = model.get('screen.substanceRisk');
    var allocations;
    if (risk == 'HIGH' && gradeYr >= 6) {
      allocations = {
        'vyou': 25 / 100,
        'csba': 25 / 100,
        'control': 35 / 100,
        'control minimal': 15 / 100
      };
    } else {
      allocations = {
        'vyou': 0 / 100,
        'csba': 50 / 100,
        'control': 35 / 100,
        'control minimal': 15 / 100
      };
    }
    computeRandomizationGroup(model, almostDone, [
      'screen.grade',
      'demo.gender',
      'site',
      'screen.risk'
    ], allocations, 'condition');
  }
  else {
    done();     // if already randomized, can't re-randomize!
  }
}
//set model.participant[target] = an index from allecationRatios such that
//each index is chosen allocationRatio[index] times for the set of all participants
//with identical values for in model for all keys
function computeRandomizationGroup(model, done, keys, allocationRatios, target) {
  if (model.get(target) !== undefined) {
    setTimeout(done);
    return;
  }
  var CONDITIONS = _.keys(allocationRatios);
  var BIAS_HIGH = 0.70;
  var keysAndTarget = _.clone(keys);
  keysAndTarget.push(target);
  model.getAllKeysForAllParticipants(keysAndTarget, function(participants) {
    var participantToBeAssigned = _.pick(model.getParticipant(), keys);
    var countByCondition = _.chain(participants)
      .where(participantToBeAssigned)
      .countBy(target)
      .value();
    delete countByCondition[undefined];
    _.each(CONDITIONS, function(condition) {
      if (!countByCondition[condition]) {
        countByCondition[condition] = 0;
      }
    }); 
    //try assigning to each condition and find all that minimize imbalance score
    var imbalanceScores = {};
    _.each(CONDITIONS, function(condition) {
      var newCounts = _.clone(countByCondition);
      newCounts[condition] += 1;
      imbalanceScores[condition] =
        getImbalanceScore(newCounts, allocationRatios);
    });
    var minimalConditions = min(imbalanceScores);
    var conditionToAssignTo = _.sample(minimalConditions);

    //assign to conditionToAssignTo BIAS_HIGH % of the time
    //the rest of the time assign to the other conditions
    //based on their percentage of the remaining weight
    var totalForNonAssignment = sum(_.omit(allocationRatios, conditionToAssignTo));
    biasedAllocationRatios = {};
    _.each(allocationRatios, function(allocation, condition) {
      biasedAllocationRatios[condition] =
        (allocation / totalForNonAssignment) * (1 - BIAS_HIGH);
    });
    biasedAllocationRatios[conditionToAssignTo] = BIAS_HIGH;

    //biased random assigment
    var randomFloat = Math.random();
    var accumulator = 0;

    for(var i = 0; i < CONDITIONS.length; i++){
      var condition = CONDITIONS[i];
      accumulator += biasedAllocationRatios[condition];
      if(randomFloat < accumulator){
        model.set(target, condition, false, done);
        return;
      }
    }
    model.set(target, CONDITIONS[CONDITIONS.length - 1], done);
  });
}

if(typeof module !== 'undefined' && module.exports){
  module.exports = computeRandomizationGroup;
  _ = require('underscore');
}