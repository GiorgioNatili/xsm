var should = require('should');
var BFT = require('./bft');
var sqlite3 = require('sqlite3').verbose();
var fs = require('fs');
var _ = require('underscore');
var assert = require('assert');
var Remote = require('./backend');
var genFakeBFT = require('./gen-fake');
var Sync = require('./sync');

describe('sync', function () {
  describe('create and destory backend', function (done) {
    var r = new Remote('abazaba');
    it('should create the table', function (done) {
      r.create(function () {
        done();
      });
    });

    it('should destroy the table', function (done) {
      r.destroy(function () {
        done();
      });
    });
  });

  describe('try to create the same table twice', function (done) {
    var r = new Remote('abazaba');
    it('should create the table', function (done) {
      r.create(function () {
        done();
      });
    });
    it('should create the table again and fail', function (done) {
      function fail(e) {
        done(e);
      }

      function success() {
        done();
      }

      r.create(fail, success);
    });
    it('should destroy the table', function (done) {
      r.destroy(function () {
        done();
      });
    });
  });
  describe('try to sync 1 bfts', function (done) {
    var r = new Remote('sync1');
    it('should create the table', function (done) {
      r.create(function () {
        done();
      });
    });

    it('should sync some rows', function (done) {
      r.sync([
        {
          machine: 11,
          timestamp: 0,
          createSeq: 1,
          copied: 1,
          ra: 'jim',
          participantID: 0,
          key: 'aba',
          value: 'zaba'
        }
      ], -1, 11, function () {
        done();
      });
    });

    it('should destroy the table', function (done) {
      r.destroy(function () {
        done();
      });
    });
  });
  describe('try to sync 2 bfts', function (done) {
    var r = new Remote('sync2');
    it('should create the table', function (done) {
      r.create(function () {
        done();
      });
    });
    var bft1, bft2;
    it('should create bft1', function (done) {
      bft1 = new BFT(':memory:', done);
    });
    it('should create bft2', function (done) {
      bft2 = new BFT(':memory:', done);
    });
    it('should populate bft1', function (done) {
      genFakeBFT(bft1, 3, [11], done);
    });
    it('should set bft1.machine', function (done) {
      bft1.setMeta('machine', 11, done);
    });
    it('should populate bft2', function (done) {
      genFakeBFT(bft2, 2, [12], done);
    });
    it('should set bft2.machine', function (done) {
      bft2.setMeta('machine', 12, done);
    });
    it('should sync bft1 w/ server', function (done) {
      var s = new Sync(bft1, r);
      s.sync(done);
    });
    it('should sync bft2 w/ bft1 & server', function (done) {
      var s = new Sync(bft2, r);
      s.sync(done);
    });
    it('should sync bft1 w/ bft2', function (done) {
      var s = new Sync(bft1, r);
      s.sync(done);
    });

    function extractRows(bft, output, done) {
      bft.db.all('SELECT * FROM BFT ORDER BY machine, timestamp, createSeq', function (e, rows) {
        output.push.apply(output, rows);
        done();
      });
    }

    var rows1 = [], rows2 = [];
    it('should populate rows1', function (done) {
      extractRows(bft1, rows1, done);
    });
    it('should populate rows2', function (done) {
      extractRows(bft2, rows2, done);
    });

    it('should verify both bfts are the same', function (done) {
      assert(_.isEqual(rows1, rows2))
      done();
    });
    it('should destroy the table', function (done) {
      r.destroy(function () {
        done();
      });
    });
  });
});