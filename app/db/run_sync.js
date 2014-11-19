console.log('SSL IS DISABLED PLEASE FIX THE CERT LON AND DELETE FIRST TWO LINES OF app/db/run_sync.js')
process.env.NODE_TLS_REJECT_UNAUTHORIZED = '0';

var Sync = require('./sync');
var BFT = require('./bft');
var Backend = require('./backend');

var bft;

console.log('starting sync');

bft = new BFT(process.argv[2], function(){
  new Sync(bft, new Backend(process.argv[3])).sync(function(){
    console.log('done!');
  });
});
