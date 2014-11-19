var bft = require('./bft');
var Faker = require('Faker');
var _ = require('underscore');

function generateFakeBFT(aBFT, count, machines, callback) {

  var inserts = 0;

  function checkDone() {
    inserts--;
    if (inserts === 0) {
      if (callback) {
        callback();
      }
    }
  }

  function fakeIt() {
    var sites = ['HCH', 'ARB', 'AUB', 'MGH'];
    var statuses = ['Aba', 'Zaba', 'Waba', 'Fraba', 'Naba'];
    var RAs = ['Peter', 'Andrew', 'James', 'John',
      'Philip', 'Bartholomew', 'Matthew', 'Thomas'];

    for (var i = 0; i < count; i++) {
      // TODO: add datum.events
      datum = {
        'demographics.age': 12 + Faker.random.number(10),
        'demographics.gender': Faker.random.array_element(['Male', 'Female']),
        'demographics.clinicSite': Faker.random.array_element(sites),
        'demographics.first': Faker.Name.firstName(),
        'demographics.last': Faker.Name.lastName(),
        'id': 100000 + Faker.random.number(999999 - 100000),
        'ra.mrn': 10000 + Faker.random.number(99999 - 10000),
        'demographics.email': Faker.Internet.email(),
        'status': Faker.random.array_element(statuses),
        'demographics.phone': Faker.PhoneNumber.phoneNumber(),
        'demographics.address1': Faker.Address.streetAddress(),
        'demographics.city': Faker.Address.city(),
        'demographics.zip': Faker.Address.zipCode(),
        'demographics.optout': Faker.random.array_element(['Yes', 'No']),
        'demographics.confidential': Faker.random.array_element(['Yes', 'No']),
        'demographics.dateOfBirth': '07/05/1984'
      };
      machine = Faker.random.array_element(machines);
      ra = Faker.random.array_element(RAs);
      _.forEach(datum, function (answer, question) {
        inserts++;
        aBFT.insert({
          machine: machine,
          ra: ra,
          participantID: datum.id,
          key: question,
          value: answer
        }, false, checkDone);
      });
    }
  }

  //delete current bft and then fake new one
  aBFT.deleteBFT(fakeIt);
}

module.exports = generateFakeBFT;