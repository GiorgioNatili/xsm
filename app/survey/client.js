angular.module('csm').service('survey', function($http, db) {
  var schema, roster = {};

  this.schema = function() {
    return schema;
  };
  //surveys
  $http.get('/survey/schema').success(function(data) {
    schema = data;
  });

  this.findSurvey = function(name) {
    return _.findWhere(schema.surveys, {
      name: name
    });
  };
});
