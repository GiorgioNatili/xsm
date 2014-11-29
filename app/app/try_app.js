var Server = require('./server');
var DB = require('../db');
var isUpdated = require('./is_updated');
var survey = require('../survey');
var constants = require('../constants');

var aServer = new Server();

new DB(constants.TRIAL_BFT).serveFrom(aServer.app);
isUpdated.serveFrom(aServer.app);
survey.serveFrom(aServer.app);

aServer.start(8080);
