var schema = require('./schema');

module.exports.serveFrom = function (app) {
  app.get('/survey/schema', function (request, response, next) {
    response.json(schema.schema());
  });
};
