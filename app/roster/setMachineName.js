"use strict";
angular.module('csm').controller('setMachineCtrl', function($scope, setMachineModel) {
  var model = setMachineModel;
  $scope.setMachineId = function(machineId) {
    $scope.machineInvalid = !(parseInt(machineId) && machineId.length === 2);
    if (!$scope.machineInvalid) {
      model.set(machineId);
    }
  };
});

angular.module('csm').service('setMachineModel', function(db) {
  var machineId = 'unloaded';
  db.getMeta('machine', function(value){
    if(value === ''){
      value = undefined;
    }
    machineId = value;
  });

  this.isLoading = function(){
    return machineId === 'unloaded';
  };
  this.get = function(){
    return machineId;
  };
  this.set = function(value){
    db.setMeta('machine', value, function(){
      machineId = value;
    });
  };
});
