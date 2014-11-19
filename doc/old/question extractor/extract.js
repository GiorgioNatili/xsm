var _ = require('underscore');
var cheerio = require('cheerio');
var fs = require('fs');
var path = require('path');

/*
_.each(_.range(1,44), function(n){
	var file = fs.readFileSync(path.resolve(
		__dirname + 
		'/../questions/' + 
		String('0'+n).slice(-2) +
		'-question-page.htm')).toString();
	console.log(cheerio.load(file)('#form1 p').first().text().trim());
});

*/
var names = [
	'brain-dev',
	'nicotine',
	'smoking',
	'alcohol-liver',
	'pregnant',
	'substance-sex',
	'marijuana',
	'alcohol-accidents',
	'marijuana-accidents',
	'prescriptions',
	'thankyou'
];
_.each(_.range(1,12), function(n){
	var file = fs.readFileSync(path.resolve(
		__dirname + 
		'/../questions/info-' + 
		String('0'+n).slice(-2) + '-' +
		names[n-1] + '.htm')).toString();
	var $ = cheerio.load(file);
	fs.writeFileSync(
		n+'.htm',
		$('#info-graphics') + '\n' + $('#info-box')
	);
});