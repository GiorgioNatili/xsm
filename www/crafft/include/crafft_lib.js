/////////////////////////////////////////////////////////////////////////
// $Id: crafft_lib.js,v 1.57 2004/10/28 20:43:27 bryce Exp $
//
// Interactive CRAFFT Project Javascript Library
//
// This file contains functions and data that are specific to this
// project, for example navigation between pages or checking if
// certain fields are complete.
/////////////////////////////////////////////////////////////////////////




var pagenames = new Array;
pagenames = [
  	'open.html', //'startup.html',
  	'welcome1.html', 'welcome2.html', 'welcome3.html', 
  	'crafft_q1.html', 'crafft_q2.html', 'crafft_q3.html', 
  	'crafft_q4.html', 'crafft_q5.html', 'crafft_q6.html',
  	'crafft_q7.html', 'crafft_q8.html', 'crafft_q9.html',
 	'resultschart.html', 
	'info_01.html', 'info_02.html', 'info_03.html',
	'info_04.html', 'info_05.html', 'info_06.html',
	'info_07.html', 'info_08.html', 'info_09.html',
	'info_10.html', 'info_end.html', 'open.html',
  	//'report_frameset.html', 
  	//'open.html',
  undefined
];
var MSG_bad_passwd = 'Sorry, that is not the correct CRAFFT password.  Please try again.';
var MSG_bad_sex_age = 'Please enter a valid number for sex advice age.';
var MSG_bad_driving_age = 'Please enter a valid number for driving advice age.';
var MSG_bad_n_copies = "You must enter 1 or more copies.  Only numbers are allowed in this field.";
var MSG_bad_study_id = "The Study ID was not valid.  The Study ID should begin with a capital letter, followed by a dash, followed by four numbers.  A correct example is F-1001.";
var MSG_no_dataframe = 'Could not find the Data Frame.  Please restart.';
var MSG_no_saveframe = 'Could not find the Save Frame.  Please restart.';
var MSG_store_failed = 'Could not store data in the Data Frame.  Please restart.';
var MSG_exit_confirm = 'Are you sure you want to exit?';
var MSG_missing_radio_items = 'Please complete all the questions by clicking one button per row.';
var MSG_bad_dropdown_items = 'Please select 1,2,3, or 4 for each of the select boxes.  Only one item may be ranked #1, only one may be ranked #2, etc.';
var MSG_previous_button_warning = "The previous button lets you back up and change your answers.  When you back up to a previous question, you will need to answer the questions after it again.";
var WIN_WIDTH=600;
var WIN_HEIGHT=600;
// define constants for the various printed reports
// (used in this file and in report_*.html)
var RPT_CRAFFT = 1;
var RPT_REACT  = 2;
var RPT_CHART  = 3;
var RPT_ADVICE_ADOLESCENT = 4;
var RPT_ADVICE_CLINICIAN = 5;
var RPTMAX = 5;  // number of reports

function crafft_open_main(url) {
  var width = screen.availWidth - (2*env_screen_margin);
  var height = screen.availHeight - (2*env_screen_margin);
  var options = "resizable=yes,location=no,menubar=no,status=yes,titlebar=no,toolbar=no,directories=no";
  if (env_use_full_screen) {
    options += ",fullscreen=yes";
  } else {
    options += ",width="+width+",height="+height;
	options += ",screenX="+env_screen_margin+",screenY="+env_screen_margin;
  }
  ii_open_window (url, "CraftWindow", options);
}

function crafft_open_debug () {
  var df = crafft_find_dataframe ();
  if (!df) return;
  var width = 600;
  var height = 200;
  var x = screen.width - width - 100;
  var y = screen.height - height - 100;
  var url = "debug.html";
  var options = "width="+width+",height="+height+",screenX="+x+",screenY="+y;
  options += ",resizable=yes";
  var win = ii_open_window (url, "DebugWindow", options);
  df.debug_win = win;
}


function crafft_action (action, arg2) {
  var page = ii_pageName ();
  ii_dbg("ACT", "you chose "+action+" from page "+page);
  if (action == "next")
    crafft_action_next (page);
  else if (action == "previous")
    crafft_action_prev (page);
  else if (action == "exit")
    crafft_action_exit ();
  else if (action == "start_over")
    ii_goto_page (top.MainFrame, "open.html");
  else if (action == "begin_new")
    ii_goto_page (top.MainFrame, "startup.html");
  else if (action == "print_forms")
    crafft_action_print_forms (arg2);
  else if (action == "menu")
    ii_goto_page (top.MainFrame, "report_frameset.html");
  else 
    ii_err("BADACT","unrecognized crafft action '"+action+"'");
  // All action buttons are in this format:
  //   <a href="javascript:;" onClick="return crafft_action('action')">
  //   </a>
  // Given this format, the crafft_action() function controls the return
  // value of the onClick, which can cause the browser to cancel the click
  // on the link or not.
  //
  // Must return a defined value.  Otherwise, if document.location changes
  // the browser may not refresh the page.
  return false;
  // Testing: with return false, both Netscape 7.0 and IE5.5 work when I click
  // the Next button.
  //return;
  // Testing: With a return with no value, IE5.5 does not refresh the page
  // when an onClick triggers document.location to change.  The lack of return
  // value causes IE5.5 to cancel the click.  In Netscape 7.0 the page is
  // refreshed, but with a small but consistent delay.
}


function crafft_action_exit () {
  ii_dbg("EXIT1", "exit selected");
  if (confirm (MSG_exit_confirm)) {
    ii_dbg("EXIT2", "exit confirmed");
    ii_exit_window ();
  }
}

function should_print_report (reportnum) {
  if (reportnum == RPT_CRAFFT) 
    return 1; // always print it
  if (reportnum == RPT_CHART)
    return crafft_get_option ("print_feed")? 1 : 0;
  if (reportnum == RPT_ADVICE_ADOLESCENT)
    return crafft_get_option ("print_feed")? 1 : 0;
  //if (reportnum == RPT_ADVICE_CLINICIAN)
  //  return crafft_get_option ("print_clinician")? 1 : 0;
  ii_err ("SPR", "reportnum "+reportnum+" is not 1-5");
  return 0;
}

function crafft_action_print_forms (mainframe) {
  if (should_print_report (1))
    ii_print_frame (mainframe.ReportFrame1);
  /*
  disable all frames except ReportFrame1
  alert("printed report 1");
  if (should_print_report (2))
    ii_print_frame (mainframe.ReportFrame2);
  alert("printed report 2");
  if (should_print_report (3))
    ii_print_frame (mainframe.ReportFrame3);
  alert("printed report 3");
  if (should_print_report (4))
    ii_print_frame (mainframe.ReportFrame4);
  */
}

// This function should be called from the body tag, as in
//   <body onContextMenu="return crafft_context_menu()">
// Then we can enable or disable the right mouse menu in this function.
// If the onContextMenu code returns false, the context menu is disabled.
function crafft_context_menu () {
  if (env_disable_right_click)
    return false;
  else
    return true;
}

// returns 1,2,3,4 according to the answers to the crafft questions.
// The logic for this function comes from the "Screening Algorithm"
// diagram from Lon.  The numbers 1,2,3,4 correspond with the numbers
// in the row RISK/ADVC.GRP. and the row ADVICE.
function crafft_get_risk_level () {
  var past_year  =  0;
  var q1a = crafft_get_data("crafft_fup_response_1");
  var q2a = crafft_get_data("crafft_fup_response_2");	
  var q3a = crafft_get_data("crafft_fup_response_3");		    
  ii_dbg ("CGRL1"," q1a="+q1a+", q2a="+q2a+", q3a="+q3a);
  if (q1a != 0 || q2a != 0 || q3a != 0) past_year = 1;
  var car = (crafft_get_data("crafft_response_4") == 0) ? 0 : 1;
  var rafft = crafft_get_rafft_score ();
  ii_dbg ("CGRL2", "past year="+past_year+", car="+car+", rafft="+rafft);
  if (rafft > 0) {
    return 'high';
  } else if (past_year || car) {
    return 'medium';
  } else {
    return 'low';
  }
}

function crafft_get_advice_form_num () {
  // set past_year=1 if question 1a is either YES (1) or NO RESPONSE (-1).
  // This is correct as long as question 1a was actually asked.  But if
  // question 1 was NO then 1a was never asked and past_year must be zero, 
  // not one.
  var past_year  = (crafft_get_data("crafft_response_1a") == 0) ? 0 : 1;
  if (crafft_get_data("crafft_response_1") == 0)
    past_year = 0;
  // set car=1 if question 2 is either YES or NO RESPONSE.
  var car        = (crafft_get_data("crafft_response_2") == 0) ? 0 : 1;
  var rafft      = crafft_get_rafft_score ();
  if (past_year) {
    // they used drugs in past year.
    if (rafft > 0) return 4;
	else return 3;
  } else {
    // did not use drugs in past year.
	if (car) return 2;
	else return 1;
  }
}

// This data is a scrambled up, screwed up version of the password.  To check
// the password, we turn each letter that the user types into a number using
// the char2int[] array, do a bunch of math with the numbers, and eventually
// get one resulting number per letter of the password.  If these numbers match
// the values in correct_password_hash, it's very likely that they typed it
// correctly.  Because the char2int[] values for corresponding lowercase and
// uppercase letters are identical, the password is case insensitive.
//
// To change the password, you pretty much have to uncomment the debug lines so
// that you get to see the results as it encodes the new password.  Then change
// correct_password_hash values accordingly.

var correct_password_hash = new Array;
correct_password_hash = [
  9304, 1314, 9770, 8634,
  1864, 5746, 8850, 2468,
  9960, 5764, 1122, 1352,
  9240, 4977, 5774, 161 
];

var char2int = new Array;
char2int['a'] = 108;          char2int['A'] = 108;          
char2int['b'] = 201;          char2int['B'] = 201;          
char2int['c'] = 859;          char2int['C'] = 859;          
char2int['d'] = 863;          char2int['D'] = 863;          
char2int['e'] = 927;          char2int['E'] = 927;          
char2int['f'] = 1907;         char2int['F'] = 1907;         
char2int['g'] = 2680;         char2int['G'] = 2680;         
char2int['h'] = 3523;         char2int['H'] = 3523;         
char2int['i'] = 3771;         char2int['I'] = 3771;         
char2int['j'] = 3805;         char2int['J'] = 3805;         
char2int['k'] = 4016;         char2int['K'] = 4016;         
char2int['l'] = 4526;         char2int['L'] = 4526;         
char2int['m'] = 4832;         char2int['M'] = 4832;         
char2int['n'] = 4913;         char2int['N'] = 4913;         
char2int['o'] = 5869;         char2int['O'] = 5869;         
char2int['p'] = 6549;         char2int['P'] = 6549;         
char2int['q'] = 6878;         char2int['Q'] = 6878;         
char2int['r'] = 7065;         char2int['R'] = 7065;         
char2int['s'] = 7097;         char2int['S'] = 7097;         
char2int['t'] = 7210;         char2int['T'] = 7210;         
char2int['u'] = 7894;         char2int['U'] = 7894;         
char2int['v'] = 8143;         char2int['V'] = 8143;         
char2int['w'] = 8596;         char2int['W'] = 8596;         
char2int['x'] = 9197;         char2int['X'] = 9197;         
char2int['y'] = 9411;         char2int['Y'] = 9411;         
char2int['z'] = 9954;         char2int['Z'] = 9954;         
char2int[''] = 517;

function crafft_check_password (word) {
  ii_dbg("CKPW", "you typed '"+word+"' as the password.");
  var n = 74;
  var mismatch = 0;
  for (var i=0; i<16; i++) {
    var c = word.substr(i, 1);
	var j = char2int[c];
	if (!j) j = char2int[''];
	for (var k=0; k<j; k++) {
	  n = (173 * n + k) % 9997;
	}
	//ii_dbg ("CCP2", "checking character '"+c+"'. after iteration, n="+n);
	if (n != correct_password_hash[i]) {
	  mismatch = 1;
	}
  }
  return (mismatch == 0);
  //return true;
}

function crafft_valid_study_id (id) {
  var valid = 1;
  var c = id.substr(0,1);
  for (var i=0; i<6; i++) {
    var c = id.substr(i,1);
    switch (i) {
	case 0:
	  // assume string has already been capitalized before this func is called
	  if (! (c>='A' && c<='Z')) 
	    return ii_dbg("VSID2", "1st char not letter");
	  break;
	case 1:
      if (c != '-') {
	    // not a dash here? insert one!
	    id = id.substr(0,1) + '-' + id.substr(1);
	  }
	  break;
	case 2:
	case 3:
	case 4:
	case 5:
	  if (! (c>='0' && c<='9'))
	    return ii_dbg("VSID4", "char "+i+" not number");
	  break;
	}
  }
  if (id.length != 6) return ii_dbg("VSID1", "len!=6");
  return id;
}

function crafft_process_screening_question (page) {
  var firstq = page.indexOf ("q");
  var qnum = page.substr(1+firstq,1);
  if (qnum<1 || qnum>9) 
	return ii_err("PSQ3a","crafft question number not found in page name");
  var qname = qnum;
  var asp_qs="studyid=" + top.studyid + "&PageName=" + page + "&";
  var y = document.form1.response_yes.checked;
  var n = document.form1.response_no.checked;
  // initialize follow up question variable for pages that do not have follow up questions
  var yf = true;
  var nf = true;
  // get value of follow up questions for pages that have them
  if (qnum>=1 && qnum<=3) {
  	var yf = document.form1.fup_response_yes.checked;
	var nf = document.form1.fup_response_no.checked;
  }
  if ((!y && !n)||(y && !yf && !nf))  {
	var trynum = crafft_get_data("crafft_try_"+qname) || 0;
	trynum++;
	switch (trynum) {
	  case 1:
	  case 2:
		// first time: ask them to select yes/no one time, but if they submit
		// again allow them to continue.
		crafft_store_data("crafft_try_"+qname, trynum);
		ii_err("PSQ3b","Please select either Yes or No.");
		return 0;  // don't allow them to continue.
	  case 3:
		// give up.  store a -1 response for follow up questions always
		  crafft_store_data("crafft_fup_response_"+qname, -1);
		  asp_qs += "Answer2=-1&"; 
		  ii_dbg("PSQ3c", "stored -1 for the incomplete follow up response");
		  // store a -1 response for first question if not answered
		  if (!y && !n) {
		  crafft_store_data("crafft_response_"+qname, -1);
		  asp_qs += "Answer1=-1&";
		  ii_dbg("PSQ3c", "stored -1 for the incomplete response");
		}  
		crafft_asp_save(asp_qs);
		return 1;  // yes, they are allowed to continue.
	  default:
		ii_err("PSQ3d","invalid try number for "+page);
		return 0;
	}
  } else if (y && n) {
	return ii_err("PSQ3e","You checked BOTH Yes and No");  //not possible!
  }
  // yay! they selected either yes or no
  var response = y ? 1 : 0;
  var fup_response = yf ? 1 : 0;
  ii_dbg("PSQ3f", "response was "+response);
  crafft_store_data ("crafft_response_"+qname, response);
  crafft_store_data ("crafft_fup_response_"+qname, fup_response);
  asp_qs += "Answer1="+response+ "&Answer2="+fup_response +"&";
  crafft_asp_save(asp_qs); 
  ii_dbg("PSQ3g","SQL was: " + asp_qs);
  return 1;
}
function crafft_asp_save(params)
{
    sf = crafft_find_saveframe();
    if (sf != "no_saveframe")
    {
        ctime = GetCurrentTime();
        elapsedTime = ctime - stime;
        sf.document.location.href="Crafft_save.asp?" + params + "PageTime=" + elapsedTime;  

    }
}
function crafft_items_on_reaction_page (pgnum) {
  if (pgnum==1 || pgnum==2) return 4;
  if (pgnum==3) return 6;
  return ii_err("CIORP","invalid page number");
}

function crafft_get_radio_value (radio_group_name) {
  // I bet there's a better way
  var i = 0;
  while (1) {
    var object = eval(radio_group_name + "[" + i + "]");
	if (!object) break;
    //ii_dbg("GRV","when i="+i+", checked = "+object.checked+", value = "+object.value);
    if (object.checked) return object.value;
    i++;
  }
  return -1;
}

function crafft_process_reaction_radio (pgnum) {
  var nq = crafft_items_on_reaction_page (pgnum);
  if (!nq) return ii_err("CPRR1","could not find n_questions on this page");
  ii_dbg ("CPRR1a", "there are "+nq+" questions");
  var n_answered = 0;
  for (var i=1; i<=nq; i++) {
    var value = crafft_get_radio_value ("document.form1.question"+i);
	if (!value) return ii_err("CPRR2", "failed to get radiobtn value for i="+i);
	ii_dbg("CPRR3","for subquestion "+i+", choice was "+value);
	crafft_store_data("crafft_reaction_"+pgnum+"_"+i, value);
	if (value != -1) n_answered++;
  }
  if (n_answered != nq) {
    ii_dbg ("CPRR4","only "+n_answered+" were answered out of "+nq);
    // incomplete data.  on first N tries, just warn them.  On (N+1)th try,
	// accept the incomplete data and continue.
	var trynum = crafft_get_data("reaction_try_"+pgnum) || 0;
	trynum++;
	if (trynum <= 2) {
	  crafft_store_data ("reaction_try_"+pgnum, trynum);
	  return ii_err("CPRR5", MSG_missing_radio_items);
	} else {
	  // give up and allow them to proceed
	  ii_dbg ("CPRR6", "leaving page "+pgnum+" with incomplete answers");
	}
  }
  return 1;
}

function crafft_get_dropdown_value (dropdown_name) {
  var object = eval(dropdown_name);
  return object.value;
}

function crafft_process_reaction_dropdown (pgnum) {
  var nq = document.form1.n_questions.value;
  if (!nq) return ii_err("CPRD1","could not find n_questions on this page");
  ii_dbg("CPRD1a", "there are "+nq+" questions");
  var n_answered = 0, dup = 0;
  var usedlist = new Array;  // used to check for duplicate values
  for (var i=1; i<=nq; i++) {
    var value = crafft_get_dropdown_value ("document.form1.question"+i);
	if (!value) return ii_err("CPRD2", "failed to get dropdown value for i="+i);
	ii_dbg("CPRD3","for subquestion "+i+", choice was "+value);
	crafft_store_data("crafft_reaction_"+pgnum+"_"+i, value);
	if (value != -1) n_answered++;
	if (usedlist[value]) dup++;
	usedlist[value] = 1;
  }
  if (dup || n_answered != nq) {
    ii_dbg ("CPRD4",n_answered+" were answered out of "+nq);
    ii_dbg ("CPRD4","there were "+dup+" duplicates");
	// incomplete or incorrect data.  on first N tries, just warn them.  On
	// (N+1)th try, accept the incomplete data and continue.
	var trynum = crafft_get_data("reaction_try_"+pgnum) || 0;
	trynum++;
	if (trynum <= 2) {
	  crafft_store_data ("reaction_try_"+pgnum, trynum);
	  return ii_err("CPRD5", MSG_bad_dropdown_items);
	} else {
	  // give up and allow them to proceed.  clear answers to -1.
	  ii_dbg ("CPRD6", "clearing answers on page "+pgnum);
	  for (var i=1; i<=nq; i++)
	    crafft_store_data("crafft_reaction_"+pgnum+"_"+i, -1);
	}
  }
  return 1;
}

function page_after_crafft_questions () {
  // returns the name of the page that is shown just after the CRAFFT
  // questions.  This needs to be calculated several times in 
  // crafft_action_next.
  if (crafft_get_option("display_info") == 0) {
      // show advice.
      return "resultschart.html";
  } else {
      // skip advice.
      return "advice_end.html";
  }
}

function crafft_action_next (page) {
  // implement NEXT button action for all pages.
  //
  // In many cases, the correct behavior is to simply go forward to
  // the next page according to the pagenames array above.  This
  // default behavior is implemented at the bottom of the function.
  // If the page will only allow the user to continue under certain
  // conditions, those conditions must be checked here.  Returning
  // early from this function causes the browser to NOT continue.
  // If execution falls through into the default behavior, the browser
  // will go ahead to the next page (with ii_goto_page).
  ii_dbg("NEXT", "next action from page "+page);
  
  if (page == 'open.html') {
    var passwd = document.form1.crafft_code.value;
    if (!crafft_check_password (passwd))
      ;//return ii_err("NEXT1a", MSG_bad_passwd) comment out since this is a demo version
    var n;
    n = document.form1.enable_autoprint.checked ? 1 : 0;
    crafft_store_option ('autoprint', n);
    n = document.form1.enable_debug.checked ? 1 : 0;
    crafft_store_option ('debug', n);
    if (n)
      crafft_open_debug ();
	// store 0 or 1 for display_info checkbox
    n = document.form1.display_info.checked ? 1 : 0;
    crafft_store_option ('display_info', n);
    // store 0 or 1 for print_feed checkbox
    n = document.form1.print_feed.checked ? 1 : 0;
    crafft_store_option ('print_feed', n);
    // store sex_age variable, if between 1 and 150.
    n = document.form1.sex_age.value;
    if (n >= 1 && n <= 150) {
      crafft_store_option ('sex_age', n);
    } else {
      return ii_err("NEXT1b", MSG_bad_sex_age);  // do not proceed
    }
    // store driving_age variable, if between 1 and 150.
    n = document.form1.driving_age.value;
    if (n >= 1 && n <= 150) {
      crafft_store_option ('driving_age', n);
    } else {
      return ii_err("NEXT1b", MSG_bad_driving_age);  // do not proceed
    }
  }
  else if (page == 'info_end.html') {
    var passwd = document.form1.crafft_code.value;
    if (!crafft_check_password (passwd))
      ; // return ii_err("NEXT2a", MSG_bad_passwd);  comment out since demo version
    // want autoprint behavior?
    if (crafft_get_option('autoprint') == 1) {
      // autoprint behavior enabled.  start with step 1.
      crafft_autoprint_step1 ();
      return;
    }
  } else if (page == 'startup.html') {
    // clear all data from any previous user. clear autoprint status.
	crafft_clear_data ();
    crafft_store_option ("autoprint_active", 0);
	// check the study id and then store it
    var id = document.form1.study_id.value;
	id = id.toUpperCase ();
	var valid_id = crafft_valid_study_id (id);
	if (valid_id == undefined)
	  return ii_err("NEXT3a", MSG_bad_study_id);  // do not proceed
	if (!crafft_store_data ('study_id', valid_id))
	  return ii_err("NEXT3b", MSG_store_failed+" for study_id");
        if (!crafft_store_data ('date', ii_get_date ()))
	  return ii_err("NEXT3c", MSG_store_failed+" for date");
  } else if (page == 'askgender.html') {
	var gender_m = document.form1.gender_male.checked ? 1 : 0;
	var gender_f = document.form1.gender_female.checked ? 1 : 0;
	var age = document.form1.age.value;
	ii_dbg ("NEXT8a", "m="+gender_m+", f="+gender_f+", age="+age);
	// check gender and age
	if (gender_m == 0 && gender_f == 0) {
	  return ii_err("NEXT8b", "Please check either male or female.");
	}
	if (! (age >=1 && age <= 150)) {
	  return ii_err("NEXT8c", "Please enter a valid age.");
	}
	var asp_qs="studyid=" + top.studyid + "&PageName=" + page + "&age=" + age + "&";
  
	// store gender and age
	if (gender_m == 1) {
	    crafft_store_data ('gender', 'm');
	    asp_qs += "gender=m&";
	}
	if (gender_f == 1) {
	    crafft_store_data ('gender', 'f');
	    asp_qs += "gender=m&";
	}
	crafft_store_data ('age', age);
	crafft_asp_save(asp_qs);
  } else if (page.indexOf('crafft_q') != -1) {
    if (!crafft_process_screening_question (page))
      return;
    var nextpage = page_after_crafft_questions ();
	if (page == 'crafft_q4.html') {
      // special exception. If questions 1 and 1a were both answered
      // with either YES or blank, continue and ask the rest of
      // the questions.  Otherwise, skip ahead.
      var q1 = crafft_get_data("crafft_response_1");
      var q1a = crafft_get_data("crafft_fup_response_1");
      var q2 = crafft_get_data("crafft_response_2");
      var q2a = crafft_get_data("crafft_fup_response_2");	
      var q3 = crafft_get_data("crafft_response_3");
      var q3a = crafft_get_data("crafft_fup_response_3");		    
      ii_dbg ("NEXT4e","decision point after q4.  q1="+q1+", q1a="+q1a+", q2="+q2+", q3="+q3+", q3a="+q3a);
      if ((q1a == 1 || q1a == -1) || (q2a == 1 || q2a == -1) || (q3a == 1 || q3a == -1)) {
	// continue to next question
	ii_dbg ("NEXT4f", "At least one of q1a, q2a or q3a was YES or Blank, continue");
      } else {
	ii_dbg ("NEXT4h", "q1a, q2a and q3a were all no, skip q3 through q7 and go to "+nextpage);
	crafft_store_data ("crafft_response_5", 0);
	crafft_store_data ("crafft_response_6", 0);
	crafft_store_data ("crafft_response_7", 0);
	crafft_store_data ("crafft_response_8", 0);
	crafft_store_data ("crafft_response_9", 0);
	// var asp_qs="studyid=" + top.studyid + "&PageName=" + page + "&"; // + "&zeroout=1&"; 2008-01-18 LRS added "&" - removed zeroout earlier b/c or scoring problem
	//2008-01-28 LRS removed this and above line because this call was overwriting "" data for response to CAR question crafft_response_4: crafft_asp_save(asp_qs);
	return ii_goto_page(top.MainFrame, nextpage);
      }
	}
  }
  var nextpage = "FAILED";
  var i;  
  for (i = 0; i < pagenames.length; i++) {
	if (page == pagenames[i]) {
	  // found this page in the list
	  nextpage = pagenames[i+1];
	  var asp_qs="studyid=" + top.studyid + "&PageName=" + page + "&";
	  if (page.indexOf('welcome') != -1 || page.indexOf('info_') != -1)
	  crafft_asp_save(asp_qs);
	  break;   // stop looking after finding one
	}
  }
  if (nextpage == "FAILED") 
    ii_err("NEXT98","next page not found in pagenames list");
  ii_dbg("NEXT99", "moving from "+page+" to next page "+nextpage);
  ii_goto_page (top.MainFrame, nextpage);
} 


function crafft_action_prev (page) {
 if (MSG_previous_button_warning && MSG_previous_button_warning.length > 0)
   alert (MSG_previous_button_warning);
 history.go( -1 );
}

function crafft_find_dataframe () {
  // do NOT call ii_dbg or ii_err from here.  Those functions call
  // this function, and it will lead to infinite recursion.
  var df = parent.DataFrame;
  if (!df)
    df = parent.parent.DataFrame;
  if (!df)
    alert (MSG_no_dataframe);
  return df;
}

function crafft_find_saveframe () {
  var sf = parent.SaveFrame;
  if (!sf)
    sf = parent.parent.SaveFrame;
  if (!sf)
    sf = "no_saveframe";
    //alert (MSG_no_saveframe);
  return sf;
}

function crafft_clear_data () {
  var df = crafft_find_dataframe();
  if (!df) return;
  if (!df.crafft_data)
    return ii_err("CCD1","could not find crafft_data in data frame");
  df.crafft_data = new Array;
  df.crafft_data['test_key'] = 'yes_I_exist';
  return 1;
}

function crafft_store_data (key, value) {
  if (key.indexOf('_time') != -1) return 1;
  var df = crafft_find_dataframe();
  if (!df) return;
  if (!df.crafft_data)
    return ii_err("CSD1","could not find crafft_data in data frame");
  if (df.crafft_data['test_key'] != 'yes_I_exist')
    return ii_err("CSD2","could not find any crafft_data values at all");
  df.crafft_data[key] = value;
  ii_dbg("CSD3","now crafft_data["+key+"] is "+df.crafft_data[key]);
  return 1;
}

function crafft_get_data (key) {
  var df = crafft_find_dataframe();
  if (!df) return;
  if (!df.crafft_data)
    return ii_err("CGD1","could not find crafft_data in data frame");
  if (df.crafft_data['test_key'] != 'yes_I_exist')
    return ii_err("CGD2","could not find any crafft_data values at all");
  var value = df.crafft_data[key];
  ii_dbg("CGD3","got crafft_data["+key+"] = "+df.crafft_data[key]);
  return value;
}

// options and data are stored in separate arrays so that we can
// clear the data when a new participant is registered, without affecting the
// options.  
function crafft_store_option (key, value) {
  // exactly like crafft_store_data except stores options instead
  var df = crafft_find_dataframe();
  if (!df) return;
  if (!df.crafft_option)
    return ii_err("CSO1","could not find crafft_option in data frame");
  if (df.crafft_option['test_key'] != 'yes_I_exist')
    return ii_err("CSO2","could not find crafft_option test data");
  df.crafft_option[key] = value;
  ii_dbg("CSO3","now crafft_option["+key+"] is "+df.crafft_option[key]);
  return 1;
}

function crafft_get_option (key) {
  // exactly like crafft_get_data except gets options instead
  var df = crafft_find_dataframe();
  if (!df) return;
  if (!df.crafft_option)
    return ii_err("CGO1","could not find crafft_option in data frame");
  if (df.crafft_option['test_key'] != 'yes_I_exist')
    return ii_err("CGO2","could not find crafft_option test data");
  var value = df.crafft_option[key];
  ii_dbg("CGO3","got crafft_option["+key+"] = "+df.crafft_option[key]);
  return value;
}

// This function just computes the CRAFFT score and returns it.  It is
// nearly a copy of the score computation code in the crafft_write_report,
// (I hate having two very similar copies of the same code, but the other one
// is quite specific to filling in the report fields, so it seemed better
// to copy it this time. BBD)
function crafft_get_crafft_score (rafft_only) {
  var score = 0;
  var incomplete = 0;
  // NOTE: the new question 1a does not contribute to the scored directly,
  // but we have to check it because it controls which questions you see.
  var question1 = crafft_get_data("crafft_response_1");
  var question1a = crafft_get_data("crafft_fup_response_1");
 
  var question2 = crafft_get_data("crafft_response_2");
  var question2a = crafft_get_data("crafft_fup_response_2");
 
  var question3 = crafft_get_data("crafft_response_3");
  var question3a = crafft_get_data("crafft_fup_response_3");
  // step through the crafft questions and compute the score.
  for (var i=4; i<=9; i++) {
    var value = crafft_get_data("crafft_response_"+i);
    if (value == undefined) incomplete++;
    ii_dbg("CGCS2","crafft question "+i+" = "+value);
    // compute CRAFFT score
    if (i>=4) {
      // only score questions 4-9.
      if (i>=5 && (question1==0 || question1a==0)&&(question2==0 || question2a==0)&&(question3==0 || question3a==0)) {
	// if question 1-3 were answered NO, questions 5-9 were never
	// asked so they should not contribute to the score.
	ii_dbg ("CGCS3", "since question1 was no, skip question "+i);
      } else if (rafft_only==1 && i==4) {
	// to compute RAFFT score, just ignore the score from question 4.
      } else {
	if (value == -1 || value == 1) {
	  score++;  // increase score for YESes or blanks.
	}
      }
    }
    ii_dbg("CGCS4","now score is "+score);
  }
  if (incomplete>0)
    return ii_err("CWR4","the crafft score is incomplete because some data is missing");
  return score;
}

function crafft_get_rafft_score () {
  var score = crafft_get_crafft_score (1);
  ii_dbg ("CGRS1", "rafft score is "+score);
  return score;
}
 
/*
 _____________________________________
/¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯\
| Modified from page timer found at   |
| website at http://jdstiles.com      |
| Created: 1998 Updated: 2006         |
\_____________________________________/
 ¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯
*/
stime=GetCurrentTime();

function display(){
rtime=etime-ctime;
if (rtime>60)
m=parseInt(rtime/60);
else{
m=0;
}
s=parseInt(rtime-m*60);
if(s<10)
s="0"+s
window.status="Time Remaining :  "+m+":"+s+"   page:"
window.setTimeout("checktime()",1000)
}

function starttimer(){
//alert("You have " + seconds + " seconds left !")
cpage = ii_pageName ();

stime=GetCurrentTime();

seconds = crafft_get_data(cpage+"_timeout");
etime=stime+seconds;  //Number of seconds
checktime(cpage);
}

function GetCurrentTime(){
    var time= new Date();
    hours= time.getHours();
    mins= time.getMinutes();
    secs= time.getSeconds();
    return hours*3600+mins*60+secs;
}

function checktime(){

ctime = GetCurrentTime();
crafft_store_data(cpage+"_time", ctime - stime);

if(ctime>=etime && seconds > 0){
expired();
}
else
display();
}

function expired(){
//alert("Time expired");
return crafft_action('next');  //Move to the next page
}

