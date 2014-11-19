angular.module('csm').controller('doctorReportWrapCtrl', function($scope, participantModel){
	$scope.showDoctorReport = function(){
		$scope.doctorLoggedIn = false;
		$scope.doctorReportShowing = true;
		$(window).scrollTop(0);
	};
	$scope.getDoctorReportBtnClass = function(){
		return surveyFunctions.getDoctorReportBtnClass(participantModel);
	};
	$scope.hideDoctorReport = function(){
		$scope.doctorLoggedIn = false;
		$scope.doctorReportShowing = false;
		window.close();
	};
	$scope.tryCredentials = function(password){
		$scope.badPassword = (password || '').toLowerCase().substring(0,4) !== 'craf';
		if(!$scope.badPassword){
			$scope.doctorLoggedIn = true;
		}
	};
	$scope.maybeEnter = function(evt, password) {
		if (evt.which === 13) {
			$scope.tryCredentials(password);
		}
	};
});
angular.module('csm').controller('doctorReportCtrl', function($scope, participantModel){
	$scope.m = function(){
		return participantModel.getParticipant();
	};
	$scope.isGirl = function(){
		return $scope.m()['demographics.gender'] == 'Female';
	};
	$scope.daysOf = function(key){
		return daysUsed($scope.m(),key);
	};
	$scope.isScreenYes = function(key){
		return $scope.m()['screen.' + key] == 'Yes';
	};
	$scope.useOf = function(key){
		return daysUsed($scope.m(),key) != 0;
	};
	$scope.noUse = function(){
		return !hasAnyUse($scope.m());
	};
	$scope.friendUseOf = function(key){
		return hasFriendUse($scope.m(),key) != 0;
	};
	$scope.friendFreqOf = function(key){
		return hasFriendFreq($scope.m(),key);
	};
	$scope.friendDrinks = function(){
		return hasFriendDrinks($scope.m());
	};
	$scope.friendAnyUse = function(){
		return hasAnyFriendUse($scope.m());
	};
	$scope.hasCar = function(){
		return hasCar($scope.m());
	};
	$scope.getRisk = function(){
		return $scope.m()['screen.risk'];
	};
	$scope.getCRAFFT = function(){
		return getCRAFFT($scope.m());
	};
	$scope.getRAFFT = function(){
		return getRAFFT($scope.m());
	};
	$scope.grade = function(){
		return grade($scope.m()) || -1;
	};
	$scope.patientName = function(){
		var ptName = $scope.m()['demo.fname'] + ' ' + $scope.m()['demo.lname'];
		if (ptName.length > 18) {
			ptName = ptName.substring(0,16) + '...';
		}
		return ptName;
	};
});
