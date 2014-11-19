var knox = require('knox');
CONSTANTS = require('../../app/server/constants.js');

versionString = CONSTANTS.version.toString();

var client = knox.createClient({
	key: 'AKIAJJM42R7J3TP25F3Q',
	secret: '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',
	bucket: 'ab-csm'
});

var req = client.put('/version.txt',
	{'content-length':versionString.length});
req.end(versionString);
