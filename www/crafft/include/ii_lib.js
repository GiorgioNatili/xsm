/////////////////////////////////////////////////////////////////////////
// $Id: ii_lib.js,v 1.13 2004/06/29 19:00:07 bryce Exp $
//
// Illumina Interactive Javascript Library
//
// This file contains functions that are not specific to this project,
// for example opening a window or printing a page.  All functions and
// variables should start with ii_ to avoid any name conflicts.
/////////////////////////////////////////////////////////////////////////

function ii_dbg (code, msg) {
  // CODE is a brief, unique error code such as "CP3".  If there's any 
  // question about which code path the browser is taking, or what happened
  // just before Javascript crashed, outputting the series of debug codes
  // will show what got executed.
  // MSG is a longer text message, one line (possibly long)
  if (enable_dbg_alert_messages)
    alert(msg + " (" + code + ")");
  // the codes can be very useful when appended to a text field.  The user
  // can cut&paste the whole text field into an email and you know which
  // code path they followed.
  var ta = env_find_dbg_textarea();
  if (ta) {
    ta.value = code + ": " + msg + "\n" + ta.value;
    if (ta.value.length > max_debug_bytes)
	  ta.value = ta.value.substr(0,max_debug_bytes/2);
  }
}

function ii_err (code, msg) {
  // CODE and MSG are defined as in ii_dbg.
  // always show alert for errors.
  alert (msg);
  return 0;
}

function ii_goto_page (window, href) {
  ii_dbg("GP","goto_page moving from old location "+document.location+" to new "+href);
  window.location = href;
}

function ii_pageName () {
  var mypage = document.location.href;
  // maybe useful to remove anything after #,slash,etc. to leave just the
  // filename?
  return mypage.substr(mypage.lastIndexOf('/')+1);
}

function ii_exit_window () {
  // method 1: doesn't work within a frameset
  // window.close ();
  // method 2: suggested by http://developer.irt.org/script/316.htm
  top.close ();
}

function ii_open_window (url,name,options) {
  // opens up a new browser window.  URL is the url that is opened in the
  // window. NAME is the window name. OPTIONS is the options string that
  // controls placement, size, etc.
  var win = window.open(url, name, options);
  // I have seen window.open fail when Netscape blocks popups for a site.
  // Netscape's popup blocking only seems to affect popups triggered by
  // a setTimeout().
  if (win) win.focus();
  return win;
}

function ii_print_frame (theframe) {
  var win = (theframe)? theframe.window : window;
  ii_dbg("IPF1","printing window "+win);
  if (win.focus) win.focus();  // makes IE print the right frame
  if (win.print) win.print();  // if print method is there, use it
  else ii_err("IPF2","Please select \"Print\" from the File menu");
}

function ii_get_date() {
  return new Date();
}


function ii_parseQueryString (str) {
  str = str ? str : location.search;
  var query = str.charAt(0) == '?' ? str.substring(1) : str;
  var args = new Object();
  if (query) {
    var fields = query.split('&');
    for (var f = 0; f < fields.length; f++) {
      var field = fields[f].split('=');
      args[unescape(field[0].replace(/\+/g, ' '))] = unescape(field[1].replace(/\+/g, ' '));
    }
  }
  return args;
}
var ii_args = ii_parseQueryString ();

//Example of how to use the parseQueryString function
//var args = ii_parseQueryString ();
//for (var arg in args) {
//  document.write(arg + ': ' + args[arg] + '<BR>');
//}
