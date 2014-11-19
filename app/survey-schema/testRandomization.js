var _ = require('underscore');
var computeRandomizationGroup = require('./surveys/surveyFunctions');
var Faker = require('Faker');

var TARGET = 't';
var KEYS = ['a', 'b', 'c'];
var ALLOCATION_RATIOS = {
	'n': 0/4,
	'x': 2/4,
	'y': 1/4,
	'z': 1/4
};

var participants = [];
var currentParticipant = {};

var model = {
	getAllKeysForAllParticipants: function(keys, callback){
		var ret = _.map(participants, function(participant){
			return _.pick(participant, keys);
		});
		setTimeout(function(){
			callback(ret);
		});
	},
	get: function(key){
		return currentParticipant[key];
	},
	getParticipant: function(){
		return currentParticipant;
	},
	set: function(key, value, callback){
		currentParticipant[key] = value;
		setTimeout(callback);
	}
};

function genParticipant(){
	return {
		'a':Faker.random.number(3),
		'b':Faker.random.number(2),
		'c':Faker.random.number(1),
		'd':Faker.random.number(6)
	};
}


var count = 0;
function step(){
	count++;
	console.log(currentParticipant);
	if(count === 1000){
		console.log('Done!');
		console.log(_.map(_.groupBy(participants, function(p){
			return p.a+';'+p.b+';'+p.c;
		}),function(ps){
			return _.countBy(ps, 't');
		}));
		console.log(_.countBy(participants, 't'));
	}else{
		currentParticipant = genParticipant();
		participants.push(currentParticipant);
		computeRandomizationGroup(model, step, KEYS, ALLOCATION_RATIOS, TARGET);
	}
}

step();
