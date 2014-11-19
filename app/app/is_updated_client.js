angular.module('csm').service('is_updated', function($http, $interval) {
  var needsUpdate;
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

  $interval(checkForUpdate, 60 * 1000);
  checkForUpdate();
});
