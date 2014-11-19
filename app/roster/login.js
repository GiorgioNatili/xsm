"use strict";

angular.module('csm').service('loginModel', function() {
  //login
  this.login = function(username, password) {
    if (username && hashCode(username) == password) {
      localStorage.setItem('userName', username);
      localStorage.setItem('loggedIn', true);
      return true;
    } else {
      return false;
    }
  };
  this.isLoggedIn = function() {
    return localStorage.getItem('userName') && localStorage.getItem('loggedIn');
  };
  //note that you can have a user name but not be logged in...
  this.getUserName = function() {
    return localStorage.getItem('userName');
  };
  this.logout = function() {
    localStorage.removeItem('userName');
    localStorage.removeItem('loggedIn');
  };
  this.softLogout = function() { //HACK so that survey knows RA name
    localStorage.removeItem('loggedIn');
  };
});

angular.module('csm').controller('loginCtrl', function($scope, loginModel, model) {
  $scope.tryCredentials = function(user, password){
    $scope.badPassword = !loginModel.login(user, password);
    if(!$scope.badPassword){
      model.refresh();
    }
  };
  $scope.maybeEnter = function(evt, user, password) {
    if (evt.which === 13) {
      $scope.tryCredentials(user, password);
    }
  };
});

function hashCode(str) {
  var hash = 0,
    i, l, char;
  if (str.length === 0) {
    return hash;
  }
  for (i = 0, l = str.length; i < l; i++) {
    char = str.charCodeAt(i);
    hash = ((hash << 5) - hash) + char;
    hash |= 0; // Convert to 32bit integer
  }
  return hash;
}
