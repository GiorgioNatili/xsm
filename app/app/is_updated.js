var http = require("http");
var VERSION = require('../constants').version;

function serveFrom(app) {
  app.get('/is_updated', function (request, response) {
    //TODO extract constant
    http.get('http://ab-csm.s3.amazonaws.com/version.txt', function (headVersion) {
      var str = '';
      headVersion.on('data', function (chunk) {
        str += chunk;
      });
      headVersion.on('end', function () {
        str = str.trim();
        if (!parseInt(VERSION)) {
          response.json(null);
        } else if (parseInt(str) != str) {
          response.json(null);
        } else {
          response.json(VERSION == str);
        }
      });
    }).on('error', function () {
      response.json(null);
    });
  });
};

module.exports = {
  serveFrom:serveFrom
};
