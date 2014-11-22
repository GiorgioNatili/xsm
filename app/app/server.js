var express = require("express");
var bodyParser = require('body-parser')
var http = require("http");
var path = require("path");
var exec = require('child_process').exec;
var _ = require("underscore");

var ROOT = require('../constants').ROOT;

module.exports = function () {
  var app = express();

  app.enable('strict routing');

  app.get("/", function (request, response, next) {
    response.redirect(301, '/roster/');
  });

  app.locals.basedir = ROOT + 'app';

  //accept http json posts, needed for bft insert
  app.use(bodyParser.json());

  function resolveStatic(endpoint, dir) {
    app.get('/' + endpoint + "/*", function (request, response, next) {
      target = request.params[0];
      response.sendFile(ROOT + dir + '/' + target);
    });
  }
  resolveStatic('lib', 'bower_components');

  app.set('view engine', 'jade');
  app.set('views', ROOT + 'app');
  app.get("/*.html", function (request, response, next) {
    response.render(request.params[0]);
  });
  app.get("/*.css", function (request, response, next) {
    response.sendFile(ROOT + 'tmp/' + request.params[0] + '.css');
  });
  app.get("/*.*", function (request, response, next) {
    response.sendFile(ROOT + 'app/' + request.params[0] + '.' + request.params[1]);
  });
  app.get("/*/", function (request, response, next) {
    response.render(request.params[0] + '/index');
  });

  function start(port) {
    console.log('listening on ' + port + '...');
    http.createServer(app).listen(port);
  };

  return {app:app, start:start};
};
