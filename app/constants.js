var path = require("path");
var fs = require("fs");

exports.ROOT = path.resolve(__dirname + "/..") + "/";

exports.TMP = exports.ROOT + "tmp/";

if (!fs.existsSync(exports.TMP)) {
  fs.mkdirSync(exports.TMP);
}

exports.TRIAL_BFT = exports.TMP + "trial-bft.sqlite";
exports.QUICK_TRIAL_BFT = exports.TMP + "quick-trial-bft.sqlite";
exports.TEST_BFT = exports.TMP + "test-bft.sqlite";
exports.TEST_BFT2 = exports.TMP + "test2-bft.sqlite";

//furthest apart records can be in bft and still be coalesced
exports.COALESCE_DELAY = 1000;

exports.version = parseInt(
  fs.readFileSync(exports.ROOT + 'app/version.txt'),
  {encoding: 'utf-8'});
