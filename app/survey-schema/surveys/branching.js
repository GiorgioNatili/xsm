BRANCHES = {};

BRANCHES.demo = {
demo:function(p){
	return getDoctorPage(p,'site');
},
Asked:function(p){
	if (p['demo.dob']){
		if(p['demo.Asked'] == "No") {
			return 'NotAsked';
		} else {
			return 'Response';
		}
	}
},
Response:function(p){
	var pResp = p['demo.Response'];
	if (pResp == "Refused"){
		return 'Refused';
	}
	else if(pResp == 'Agreed'){
		var agePt = age(p);
		if (agePt >= 12 && agePt < 18) {
			return 'Assent12-17';
		}
		else if(agePt >= 18) {
			return 'Consent18';
		}
	}
	else if (pResp == 'Inelligible') {
		return 'Inelligible'
	}
	else if (pResp == 'Not now') {
		return 'setStatus';
	}
},
contact:function(p){
	if (p['demo.isDemoDoctor'] == 'No') {
		return getDoctorPage(p,'visit');
	}
	return 'schoolGrade';
},
page0:function(p){
	var risk = p['screen.risk'];
	if (risk == 'LOW') {
		return 'low';
	}
	else if (risk == 'MEDIUM') {
		return 'medium';
	}
	else return 'high';
}
};

BRANCHES.useHistory = {
AlcYrDays:function(p) {
	var AlcDays = p['useHistory.AlcYrDays'];
	if(!AlcDays || AlcDays < 6){
		return 'CigEverYN';
	}
}
};

BRANCHES.assess = {
Welcome:function(p){
	if (p['useHistory.AlcYrDays'] > 0 ) {return 'ImpCutAlc';}
	else if (p['useHistory.CigYrDays'] > 0 || p['useHistory.ChewYrDays'] > 0) {return 'ImpCutTob';}
	else if (p['useHistory.MjYrDays'] > 0 ) {return 'ImpCutMj';}
	else if (p['useHistory.RxYrDays'] > 0 ) {return 'ImpCutRx';}
	else if (p['useHistory.DrugYrDays'] > 0 ) {return 'ImpCutDrug';}
	else return 'FrAlc';
},
ReadyCutAlc:function(p){
	if (p['useHistory.CigYrDays'] > 0 ||
	p['useHistory.ChewYrDays'] > 0) {return 'ImpCutTob';}
	else if (p['useHistory.MjYrDays'] > 0 ) {return 'ImpCutMj';}
	else if (p['useHistory.RxYrDays'] > 0 ) {return 'ImpCutRx';}
	else if (p['useHistory.DrugYrDays'] > 0 ) {return 'ImpCutDrug';}
	else return 'DAlcSchool1';
},
ReadyCutTob:function(p){
	if (p['useHistory.MjYrDays'] > 0 ) {return 'ImpCutMj';}
	else if (p['useHistory.RxYrDays'] > 0 ) {return 'ImpCutRx';}
	else if (p['useHistory.DrugYrDays'] > 0 ) {return 'ImpCutDrug';}
	else if (p['useHistory.AlcYrDays'] > 0) {return 'DAlcSchool1';}
	else return 'HonTriedQuit';
},
ReadyCutMj:function(p){
	if (p['useHistory.RxYrDays'] > 0 ) {return 'ImpCutRx';}
	else if (p['useHistory.DrugYrDays'] > 0 ) {return 'ImpCutDrug';}
	else if (p['useHistory.AlcYrDays'] > 0) {return 'DAlcSchool1';}
	else return 'DaMedReason';
},
ReadyCutRx:function(p){
	if (p['useHistory.DrugYrDays'] > 0 ) {return 'ImpCutDrug';}
	else if (p['useHistory.AlcYrDays'] > 0) {return 'DAlcSchool1';}
	else return 'DaMedReason';
},
ReadyCutDrug:function(p){
	if (p['useHistory.AlcYrDays'] > 0) {return 'DAlcSchool1';}
	else return 'DaMedReason';
},
DAlcSchool3:function(p){
	if (p['assess.DAlcSchool3'] == 'No') {
		return 'DAlcTrouble1';
	}	
	else if ((p['assess.DAlcSchool1'] != 'No' && p['assess.DAlcSchool3'] != 'No')) {
		return 'DAlcArgue1';
	}
},
DAlcSchool4:function(p){
	if ((p['assess.DAlcSchool1'] != 'No' && p['assess.DAlcSchool3'] != 'No') || (p['assess.DAlcSchool4'] != 'No')) {
		return 'DAlcArgue1';
	}
},
DAlcTrouble1:function(p){
	if (
		 p['assess.DalcTrouble1'] == 'No' ||
		(p['assess.DAlcTrouble1'] != 'No' && p['assess.DAlcSchool3'] != 'No') ||
		(p['assess.DAlcTrouble1'] != 'No' && p['assess.DAlcSchool1'] != 'No')
		){
		return 'DAlcArgue1';
	}
},
DAlcPolice1:function(p){
	if (p['assess.DAlcPolice1'] == 'No') {
		if (p['useHistory.AlcYrSixDays'] == 'No') {
			return getNextfAndg(p);
		}
		else {
			return 'DAlcOften';
		}
	}
},
DAlcPolice2:function(p){
	if (p['useHistory.AlcYrSixDays'] == 'No') {
		return getNextfAndg(p);
	}
	else {
		return 'DAlcOften';
	}
},
AuConcern:function(p){
	if ((p['useHistory.CigYrDays'] == 0 || p['useHistory.CigYrDays'] ==  undefined) &&
			(p['useHistory.ChewYrDays'] == 0 || p['useHistory.ChewYrDays'] ==  undefined)) {
		if (p['useHistory.MjYrDays'] > 0 ||
			p['useHistory.RxYrDays'] > 0 ||
			p['useHistory.DrugYrDays'] > 0)  {return 'DaMedReason';}
		else {return '90UseHurt';}
	}
},
HonRestless:function(p){
	if (p['useHistory.MjYrDays'] > 0 ||
		p['useHistory.RxYrDays'] > 0 ||
		p['useHistory.DrugYrDays'] > 0)  {return 'DaMedReason';}
	else {
		if (p['useHistory.AlcYrDays'] > 0) {return '90UseHurt';}
		else return 'FrAlc';
	}
},
RideDrug:function(p){
	if(p['assess.RideDrink'] != 'Not at all' || p['assess.RideDrug'] != 'Not at all'){
		return 'setRideWords';
	}
	else { 
		if (p['screen.grade'] >= 9 && p['tfb.alcDays90'] > 0) {		
			return 'DriveAlc';
		} 
		else if(p['screen.grade'] >= 9 && p['tfb.mjOthDays90'] > 0) {
			return 'DriveDrugs';
		} else {
			return 'PHCigOcc';
		}
	}
},
RideAdult:function(p){
	if(p['assess.RideAdult'] != 'No' &&
		(p['assess.RideDrink'] == 'Once' && p['assess.RideDrug'] == 'Not at all') || 
		(p['assess.RideDrink'] == 'Not at all' && p['assess.RideDrug'] == 'Once')) {
		return 'RideFamily';
	}
},
RideFamily:function(p){
	if (p['screen.grade'] >= 9 && p['tfb.alcDays90'] > 0) {		
		return 'DriveAlc';
	} 
	else if(p['screen.grade'] >= 9 && p['tfb.mjOthDays90'] > 0) {
		return 'DriveDrugs';
	} else {
		return 'PHCigOcc';
	}
},
DriveAlc:function(p){
	if(p['screen.grade'] < 9 || p['tfb.mjOthDays90'] == 0) {
		return 'PHCigOcc';
	}
},
DPsyPanic2:function(p){
	if ((p['assess.DPsyPanic2'] != 'No') || (p['assess.DPsyPanic1'] != 'No')) {
		return 'DPsyAnx1';
	}
},
DPsyOCD5:function(p){
	if ((p['assess.DPsyOCD1'] != 'No') || (p['assess.DPsyOCD2'] != 'No') || (p['assess.DPsyOCD3'] != 'No') ||
		(p['assess.DPsyOCD4'] != 'No') || (p['assess.DPsyOCD5'] != 'No')) {
		return 'DPsyDep1';
	}
},
DPsyParentWorry1:function(p){
	if ((p['assess.DPsyParentWorry1'] == 'Hardly ever') || (p['assess.DPsyParentWorry1'] == 'Not at all')) {
		return 'DPsyParentUpset1';
	}
},
DPsyParentUpset1:function(p){
	if ((p['assess.DPsyParentUpset1'] == 'Hardly ever') || (p['assess.DPsyParentUpset1'] == 'Not at all')) {
		return 'DPsyFamily1';
	}
},
DPsyFamily1:function(p){
	if ((p['assess.DPsyFamily1'] == 'Hardly ever') || (p['assess.DPsyFamily1'] == 'Not at all')) {
		return 'DPsyPeer1';
	}
},
DPsyPeer1:function(p){
	if ((p['assess.DPsyPeer1'] == 'Hardly ever') || (p['assess.DPsyPeer1'] == 'Not at all')) {
		return 'DPsySchool1';
	}
},
DPsySchool1:function(p){
	if ((p['assess.DPsySchool1'] == 'Hardly ever') || (p['assess.DPsySchool1'] == 'Not at all')){
		return 'DPsyTeacherUpset1';
	}
},
DPsyTeacherUpset1:function(p){
	if ((p['assess.DPsyTeacherUpset1'] == 'Hardly ever') || (p['assess.DPsyTeacherUpset1'] == 'Not at all')){
		return 'DPsyYouUpset1';
	}
},
DPsyYouUpset1:function(p){
	if ((p['assess.DPsyYouUpset1'] == 'Hardly ever') || (p['assess.DPsyYouUpset1'] == 'Not at all')){
		return 'DPsyYouUpset1';
	}
}
};

function countResponses(object, desiredValue, keys) {
	var count = 0;
	_.each(object, function(value, key){
		if(_.contains(keys, key) && value === desiredValue){
			count++;
		}
	});
	return count;
}
function getNextfAndg(p){
	var yesSquare = countResponses(p,'Yes',
		['assess.DAlcSchool2',
		'assess.DAlcSchool4',
		'assess.DAlcTrouble2',
		'assess.DAlcImportant2',
		'assess.DAlcArgue2',
		'assess.DAlcFriend2',
		'assess.DAlcFight3',
		'assess.DAlcHurt2',
		'assess.DAlcPolice1']);
	var countAngle = countResponses(p,'Yes',
		['assess.DAlcOften',
		'assess.DAlcTime',
		'assess.DAlcYrTryQuit1',
		'assess.DAlcYrQuit',
		'assess.DAlcYrToler1',
		'assess.DAlcYrToler2',
		'assess.DAlcYrHangov',
		'assess.DAlcYrTime',
		'assess.DAlcYrPlan',
		'assess.DAlcYrActivity',
		'assess.DAlcYrHealth2',
		'assess.DAlcYrSad2',
		'assess.DAlcYrSickUse']);
	var countCross = countResponses(p, 'Yes',
		 ['assess.DAlcYrWorry',
		 'assess.DAlcYrRestless',
		 'assess.DAlcYrHeart',
		 'assess.DAlcYrVomit',
		 'assess.DAlcYrSleep',
		 'assess.DAlcYrSweat',
		 'assess.DAlcYrSeizure',
		 'assess.DAlcYrShake',
		 'assess.DAlcYrHear']);
	if (countCross >= 2){
		++countAngle;
	}
	countAngle += countResponses(p, 'No', ['assess.DAlcYrTryQuit2'])
	var yesStar = countResponses(p, 'Yes',
		['assess.DAlcSchool1',
		'assess.DAlcSchool3',
		'assess.DAlcTrouble1',
		'assess.DAlcImportant1',
		'assess.DAlcHurt1']);
	if (yesSquare = 0 || countAngle < 2 || yesStar < 2) {
		return 'AuOften';
	}
	return 'DAlcCaretaker1';
}

BRANCHES.post = {
DrSee:function(p){
	if (p['post.DrSee'] == "No" || p['post.DrSee'] == "I don't know") {
		return getDoctorPage(p,'site');
	}
	return 'DrPrior';
},
DrPrior:function(p){
	if (daysUsed(p,'Alc') != 0) {
		return 'StopAlc';
		}
	else {
		return 'AvoidAlc';
	}
},
AvoidAlc:function(p){
	if (daysUsed(p,'Tob') != 0) {
		return 'StopTob';
	}
	else {
		return 'AvoidTob';
	}
},
StopAlc:function(p){
	if (daysUsed(p,'Mj') != 0) {
		return 'StopTob';
	}
	else {
		return 'AvoidTob';
	}
},
AvoidTob:function(p){
	if (daysUsed(p,'Mj') != 0) {
		return 'StopMJ';
	}
	else {
		return 'AvoidMJ';
	}
},
StopTob:function(p){
	if (daysUsed(p,'Mj') != 0) {
		return 'StopMJ';
	}
	else {
		return 'AvoidMJ';
	}
},
AvoidMJ:function(p){
	if (daysUsed(p,'Drug') != 0) {
		return 'StopDrug';
	}
	else {
		return 'AvoidDrug';
	}
},
StopMJ:function(p){
	if (daysUsed(p,'Drug') != 0) {
		return 'StopDrug';
	}
	else {
		return 'AvoidDrug';
	}
},
AdviceRide:function(p){
	if (p['screen.grade'] < 9){
		return 'InfoAlc';
	}
},
InfoDrugs:function(p){
	if (daysUsed(p,'Tob') == 0) {
		return 'RateAdvice';
	}
},
AskFollowUp:function(p){
	if (p['condition'] != 'vyou')
		return 'Done!';
}
};
 
BRANCHES.screen = {
  Welcome:function(p){
	if (p['screen.grade'] >= 9 && p['screen.version'] == 'A') {
		return 'AlcDaysYr14';
	}
	else {
		return 'YrUseFriends';
	}
  },
	YrUseFriends:function(p){		
		var gradeYr = p['screen.grade'];
		var version = p['screen.version'];
	if (version == 'A') {
		if(gradeYr < 6){
			return 'AlcUseEver';
		}
		else if (gradeYr < 9){
			return 'AlcDaysYr';
		}
		else if (p['screen.AlcYrUseFriends'] == 'No'){
		 return 'Ride';
		}
		else {
			return 'AlcDrinksFriendsA';
		}
	}
	else {
		if (gradeYr < 6) {
			return 'AlcDaysEver';
		}
		else if (gradeYr < 9){
			return 'AlcDaysYr';
		} else if (p['screen.AlcYrUseFriends'] == 'No') {
			if (p['screen.TobYrUseFriends'] != 'No') {
				return 'TobFreqFriends';
			}
			else if (p['screen.MjYrUseFriends'] != 'No') {
				return 'MjFreqFriends';
			}
			else if (p['screen.DrugYrUseFriends'] != 'No') {
				return 'DrugFreqFriends';
			}
		return 'AlcDaysYr14';
		}
		}
  },
  AlcDrinksFriendsB:function(p){
	if (p['screen.TobYrUseFriends'] == 'No') {
		if (p['screen.MjYrUseFriends'] != 'No') {
			return 'MjFreqFriends';
		}
		else if (p['screen.DrugYrUseFriends'] != 'No') {
			return 'DrugFreqFriends';
		}
		else {
			return 'AlcDaysYr14';
		}
	}
  },
  TobFreqFriends:function(p){
	if (p['screen.MjYrUseFriends'] == 'No') {
		if (p['screen.DrugYrUseFriends'] != 'No') {
			return 'DrugFreqFriends';
		}
		else {
				return 'AlcDaysYr14';
		}
	}
  },
  MjFreqFriends:function(p){
	if (p['screen.DrugYrUseFriends'] == 'No') {
			return 'AlcDaysYr14';
		}
  },
  AlcDaysYr14:function(p){
	if (p['screen.version'] == 'A' || p['screen.AlcDaysYr14'] == 0) {
		return 'TobDaysYr14';
	} 
  },
  MjDaysYr14:function(p){
	if (p['screen.version'] == 'A' || p['screen.MjDaysYr14'] < 10) {
		return 'DrugDaysYr14';
	} 
  },
  DrugDaysYr14:function(p){
	if (p['screen.version'] == 'A') {
		return 'YrUseFriends';
	}
  },
  Ride:function(p){
		if (!hasAnyUse(p,'Tob')) {
			return 'riskCalc';
		} else if (p['screen.grade'] < 9) {
		  return 'Relax';
		} else {
			return undefined;
		}
	},
	riskCalc:function(p){
		if (p['condition'] == 'csba' || p['condition'] == 'vyou') {
			return 'page0-' + p['screen.risk'];
		}
		return 'end';
	}
}; 

function daysUsed(p,substance){
	var gradeYr = p['screen.grade'];
	var version = p['screen.version'];
	if (gradeYr < 6) {
		if (version == 'A'){

			if(p['screen.' + substance + 'UseEver'] == 'No'){
				return '0';
			}else{
				return '-1'; //daysUsed is unknown
			}
		}else{
			return p['screen.' + substance + 'DaysEver'];
		}
	}else if (gradeYr < 9) {
		return p['screen.' + substance + 'DaysYr'];
	}else {
		return p['screen.' + substance + 'DaysYr14'];
	}
}
function daysBinged(p){
	if (daysUsed(p, 'Alc') == 0){
		return 0;
	}
	else return p['screen.AlcBingeDays'];
}
function hasAnyUse(p, aSubstanceToOmit){
	var subs = _.without(['Alc', 'Tob', 'Mj', 'Drug'], aSubstanceToOmit);
	var use = _.map(subs, function(sub){
		return daysUsed(p,sub) != 0;
	});
	return _.any(use);
}
function hasFriendUse(p,substance){
	return p['screen.' + substance + 'YrUseFriends'] != 'No';
}
function hasAnyFriendUse(p){
	return hasFriendUse(p,'Alc') || hasFriendUse(p,'Tob') || hasFriendUse(p,'Mj') || hasFriendUse(p,'Drug');
}
function hasFriendFreq(p, substance){
	if (p['screen.' + substance + 'FreqFriends']) {
		return p['screen.' + substance + 'FreqFriends'];
	}
	return '';
}
function hasFriendDrinks(p){
	if (p['screen.AlcDrinksFriendsA'] || p['screen.AlcDrinksFriendsB']) {
		if (p['screen.version'] == 'A') {
			return p['screen.AlcDrinksFriendsA'];
		}
		else if (p['screen.version'] == 'B') {
			return p['screen.AlcDrinksFriendsB'];			
		}
	}
	return '';
}
function age(p){
	var dob = p['demo.dob'];
	return moment().diff(moment(dob,'YYYY-MM-DD'), 'years');
}
function grade(p) {
	var gradeChars =  p['demo.schoolGrade'];
	if (gradeChars) {
		gradeChars = gradeChars.substring(0,2);
		var gradeYr = parseInt(gradeChars,10);
		if (isNaN(gradeYr)) {
			if ( gradeChars == "Co") {
				return 13;
			}
		} else {
			return gradeYr;
		}
	}
	return age(p) - 5;
}
function getBingeNumber(p){
	var gender = p['demo.gender'];
	var ageYr = age(p);
	if (gender == 'Male') {
		if (ageYr >= 16) {
			return 5; 					// males > = 16
		}
		else if (ageYr >= 14) {
			return 4; 					// males 14 <= age < 16
		}
		else return 3;				// for males age < 14 or undefined set to lowest
	}
	else if (ageYr >= 18) {
		return 4; 						// females age >= 18
	}
	else return 3; 					// for females age < 18 or undefined age or gender set to lowest
}
function hasCar(p) {
	return p['screen.Ride'] != 'No' || p['screen.Drive'] == 'Yes';
} 
function getRAFFT(p) {
	var RAFFT = 0;
	if (p['screen.Relax'] == 'Yes') {RAFFT++;}
	if (p['screen.Alone'] == 'Yes') {RAFFT++;}
	if (p['screen.Forget'] == 'Yes') {RAFFT++;}
	if (p['screen.Family'] == 'Yes') {RAFFT++;}
	if (p['screen.Trouble'] == 'Yes') {RAFFT++;}
	return RAFFT;
}
function getCRAFFT(p) {
	var CRAFFT = getRAFFT(p);
	if (p['screen.Ride'] != "No" || p['screen.Drive'] == "Yes") {
		CRAFFT++;
	}
	return CRAFFT;
}
function getDoctorPage(p,prefix){
	if(p) {
		return prefix + p['site'] + 'Doctor';
	}
	return false;
}
function getDoctor(p,stage){
	if (stage == 'demo' || stage == 'post') {
		var doctorPage = getDoctorPage(p,'site');
		return p[stage + '.' + doctorPage];
	}
	else if (stage == 'contact') {
		var doctorPage = getDoctorPage(p, 'visit');
		return p['demo.' + doctorPage];
	}
	alert('doctor page for survey stage: ' + stage + ' not found. Contact Lon but OK to continue now.');
}
