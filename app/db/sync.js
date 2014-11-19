var _ = require('underscore');

function Sync(BFT, backend) {
  this.BFT = BFT;
  this.backend = backend;
  this.running = true;
}

var method = Sync.prototype;

method.sync = function (doneCallback) {
  var start = new Date().getTime();
  var BFT = this.BFT;
  var backend = this.backend;
  var machineName;
  var maxPostedRow;
  var rows;
  var that = this;
  var incomingRows;

  function sync2(_rows) {
    rows = _rows;
    BFT.getMeta('machine', sync3, err);
  }

  function sync3(_machineName) {
    if (!_machineName) {
      sync8();
    } else {
      machineName = _machineName;
      BFT.getMeta('maxPostedRow', sync4, err);
    }
  }

  function sync4(_maxPostedRow) {
    maxPostedRow = _maxPostedRow == undefined ? -1 : _maxPostedRow;
    backend.sync(rows, maxPostedRow, machineName, sync5, err);
  }

  function sync5(_incomingRows) {
    incomingRows = _incomingRows;
    BFT.markAsCopied(start, sync6, err);
  }

  function sync6() {
    if (incomingRows.length !== 0) {
      maxPostedRow = Math.max(maxPostedRow, _.max(_.pluck(incomingRows, 'id')));
      BFT.multiInsert(incomingRows, sync7, err);
    } else {
      sync71();
    }
  }

  function sync7() {
    BFT.setMeta('maxPostedRow', maxPostedRow, sync71, err);
  }
  function sync71() {
    BFT.setMeta('lastUpdated', start, sync8, err);

  }
  function err(e) {
    console.log('sync err:' + e);
    sync8();
  }

  function sync8() {
    if (doneCallback) {
      doneCallback();
    } else {
      setTimeout(_.bind(method.sync, that), 60 * 1000);
    }
  }

  BFT.getNonCopiedRows(start, sync2, err);
};

module.exports = Sync;
