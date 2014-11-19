var should = require('should');
var BFT = require('./bft');
var sqlite3 = require('sqlite3').verbose();
var fs = require('fs');
var _ = require('underscore');
var assert = require('assert');

dbFile = require('../constants').TEST_BFT;

var theBFT;
//constant
var aRow = {
  machine: 12,
  ra: 'Vlad',
  participantID: 101,
  key: "status",
  value: "just_added"
};

function createDB() {
  it('should create a db', function (done) {
    if (fs.existsSync(dbFile)) {
      fs.unlinkSync(dbFile);
    }
    theBFT = new BFT(dbFile, done);
  });
}

function insertARow() {
  it('should insert a row into bft without error', function (done) {
    theBFT.insert(aRow, false, done);
  });
}

describe('BFT', function () {
  describe('init()', function () {
    createDB();
    it('should init db', function () {
      fs.existsSync(dbFile).should.be.true;
    });
  });

  describe('insert()', function () {
    createDB();
    insertARow();
    it('should have inserted a correct entry', function (done) {
      theBFT.db.all("SELECT * FROM BFT",
        function (err, results) {
          results.length.should.equal(1);
          _.matches(aRow)(results[0]).should.be.true;
          done();
        }
      );
    });
  });

  describe('deleteBFT()', function () {
    createDB();
    insertARow();
    it('should delete the bft', function (done) {
      theBFT.deleteBFT(done);
    });
    it('should be empty', function (done) {
      theBFT.db.all('SELECT * FROM BFT', function (err, results) {
        results.length.should.equal(0);
        done();
      });
    });
  });

  describe('meta()', function () {
    createDB();
    it('should get aba=undefined', function (done) {
      theBFT.getMeta('aba', function (val) {
        if (val !== undefined) {
          throw 'val is defined:' + val;
        }
        done();
      });
    });
    it('should set aba=xxx', function (done) {
      theBFT.setMeta('aba', 'xxx', done);
    });
    it('should get aba=xxx', function (done) {
      theBFT.getMeta('aba', function (val) {
        'xxx'.should.equal(val);
        done();
      });
    });
    createDB();
    it('should increment aba to 1', function (done) {
      theBFT.getMeta('aba', function (val) {
        if (val !== undefined) {
          throw 'val is defined:' + val;
        }
        theBFT.setMeta('aba', 1, function () {
          done();
        });
      });
    });
  });
  //test getValues for empty participants/keys/logs
  // test coalesce: two inserts delayed by less than constants coalesce delay with levenstein d <
  //
});