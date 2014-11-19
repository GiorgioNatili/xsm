var endpoints = require('./endpoints');
var bft = require('./bft');

module.exports = function(dbFile){
  var db = new bft(dbFile);
  this.serveFrom = function(aServer){
    endpoints(aServer, db);
  };
}
