var csv = require('csv');
var _ = require('underscore');
var fs = require('fs');

var ROOT = require('../constants').ROOT;
var SURVEY_ROOT = ROOT + 'app/survey-schema/';

//exports

var surveys;
var roster;
var statuses;
var initialStatus;

exports.schema = function() {
  return {
    surveys: surveys,
    roster: roster,
    statuses: statuses,
    initialStatus: initialStatus
  }
};

//high level csv parsing

function blastoff(){
  readCSV('roster', readRoster, ['section', 'key', 'title']);
  readCSV('statuses', readStatuses);
  readCSV('surveys', readSurveys, ['name', 'class', 'type', 'title', 'next']);
}

function readRoster(rosterCSV) {
  roster = rosterCSV;
}

function readStatuses(statusesCSV) {
  statuses = {};
  _.each(statusesCSV, function(row) {
    var survey = row.survey;
    delete row.survey;
    _.each(row, function(cell, header) {
      if (!statuses[header]) {
        statuses[header] = {};
      }
      statuses[header][survey] = cell === 'Y';
    });
  });
  initialStatus = _.keys(statusesCSV[0]).sort()[0];
}

function readSurveys(surveysCSV) {
  surveys = surveysCSV;
  checkNoIndexCollisions(surveys, 'name', 'surveys');

  _.each(surveys, function(survey) {
    if (survey.type !== 'tfb') {
      readCSV('surveys/' + survey.name, _.partial(readQuestions, survey),
        ['page', 'name', 'type', 'typeDetails', 'required', 'text', 'header', 'audio', 'branchOnValue', 'branchToPage']);
    }
  });
}

function readQuestions(surveyData, surveyCSV, CSVName) {
  checkNoIndexCollisions(surveyCSV, 'name', CSVName);
  surveyData.pages = [];
  var currentPage = null, currentPageName = null;
  var seenPageNames = [];
  _.each(surveyCSV, function(surveyRow) {
    if(currentPageName != surveyRow.page){
      currentPage = {
        name:surveyRow.page
      };
      surveyData.pages.push(currentPage);
      currentPageName = surveyRow.page;
      if(_.contains(seenPageNames, currentPageName)){
        throw 'duplicate page name:' + currentPageName + ' in ' + CSVName;
      }
      seenPageNames.push(currentPageName);
    }

    if (surveyRow.audio) {
      var audio = 'audio/' + surveyRow.audio + '.mp3';
      var file = __dirname + '/' + audio;
      if (!fs.existsSync(file)) {
        throw 'audio file not found: ' + file;
      }
      currentPage.audio = audio;
    }

    if (surveyRow.branchOnValue) {
      var branching;
      if (surveyRow.branchOnValue !== 'Complex') {
        if (!surveyRow.branchToPage) {
          throw 'expected branch to page in: ' + JSON.stringify(surveyRow);
        }
        branching = {
          value: surveyRow.branchOnValue,
          target: surveyRow.branchToPage,
          type: 'simple'
        };
      }else{
        branching = {
          fn: currentPageName,
          type: 'complex'
        };
      }
      currentPage.branching = branching;
      currentPageName = undefined; // start a new page
    }
    if(surveyRow.type == 'function' || surveyRow.type == 'page'){
      if(currentPage.type == 'questions'){
        throw 'cant put function/page in questions' + JSON.stringify(surveyRow) + CSVName;
      }
      currentPage.type = surveyRow.type;
      if(surveyRow.type == 'function'){
        currentPage.fn = surveyRow.text;
      }else{
        var file = SURVEY_ROOT + 'pages/' + surveyRow.text;
        currentPage.body = fs.readFileSync(file).toString();
      }
      currentPageName = undefined; // start a new page
    }else{
      currentPage.type = 'questions';
      currentPage.questions = currentPage.questions || [];

      question = {}
      checkIn(surveyRow.required, [
        'required',
        'optional',
        'warning',
      ], CSVName);
      question.name = surveyRow.name;
      question.required = surveyRow.required;
      question.text = surveyRow.text;
      question.cssClass = surveyRow.typeDetails || 'width33 horizontal';
      question.header = surveyRow.header;

      processDelimiter(surveyRow, '|', 'radio');
      processDelimiter(surveyRow, ';', 'check');
      question.type = surveyRow.type;
      question.options = surveyRow.options;
      question.hasOther = surveyRow.other;

      currentPage.questions.push(question);
    }
  });
}

function processDelimiter(question, delimit, type) {
  options = question.type.split(delimit);
  options = _.map(options, function(option) {
    return option.trim();
  });
  if (options.length != 1) {
    question.options = options;
    question.type = type;
    question.other = _.contains(options, 'Other');
  }
}

//utilities
function readCSV(name, done, expectedHeader) {
  var stream = csv().from.path(SURVEY_ROOT + name + '.csv');
  stream.to.array(function(rows) {
    header = rows[0];
    if (expectedHeader && !_.isEqual(header, expectedHeader)) {
      throw 'unexpected headers for ' + name + ':' + header;
    }
    var ret = _.chain(rows)
      .rest(1)
      .map(function(row) {
        //trim row
        row2 = [];
        _.each(row, function(cell){
          row2.push(cell.trim());
        });
        return _.object(header, row2);
      })
      .value();

    done(ret, name);
  });
}

function checkIn(value, options, tableName) {
  if (_.isArray(options)) {
    options = _.object(options, options);
  }
  if (options[value] === undefined) {
    throw 'unknown option ' + value + ' in ' + tableName;
  }
}

function checkNoIndexCollisions(table, columnName, tableName) {
  var columnData = _.pluck(table, columnName);
  var seen = [];
  _.each(columnData, function(cell){
    if(_.contains(seen, cell)){
      throw tableName + ' contains duplicate cell ' + cell;
    }
    seen.push(cell);
  });
}

//now that all functions are init'd run this sucker
blastoff();
