fs = require('fs');
CONSTANTS = require('../../app/server/constants.js');

version = CONSTANTS.version + 1;

fs.writeFile(CONSTANTS.ROOT + "/app/version.txt", version.toString());
