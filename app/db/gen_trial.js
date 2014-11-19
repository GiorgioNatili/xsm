var BFT = require('./bft');
var genFakeBFT = require('./gen-fake');
var constants = require('../constants');

function doGenerate() {
  console.log('generating 1000 rows, please wait this takes a bit');
  var machines = [11, 32, 24, 43, 54, 14];
  genFakeBFT(aBFT, 1000, machines);
}

var aBFT = new BFT(constants.TRIAL_BFT, doGenerate);
