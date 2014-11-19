angular.module('csm').controller('rosterViewCtrl', function($scope, setMachineModel, loginModel) {
  $scope.mode = function(){
    if(setMachineModel.get() === undefined){
      return 'setMachine';
    }else if(!loginModel.isLoggedIn()){
      return 'login';
    }else{
      return 'roster';
    }
  };
});
