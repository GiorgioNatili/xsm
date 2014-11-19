/////////////////////////////////////////////////////////////////////////
// $Id: env.js,v 1.12 2004/06/29 19:17:49 bryce Exp $
//
// Global environmental settings for CRAFFT project
/////////////////////////////////////////////////////////////////////////

var enable_dbg_alert_messages = 0;
function env_find_dbg_textarea() {
  var df = crafft_find_dataframe();
  if (df.debug_win) {
    //alert("found debug_win "+df.debug_win);
	if (df.debug_win.document.form1) {
      //alert("found debug_win form1"+df.debug_win.document.form1);
      return df.debug_win.document.form1.datatext;
    }
  }
  return;
}
var set_fake_data = 0;

// control size and behavior of popup window
var env_use_full_screen = 0;
var env_screen_margin = 100;   // only used when env_use_full_screen=0
var env_disable_right_click = 0;

// maximum number of lines in debug window
var max_debug_bytes = 8192;

// default values for driving advice and sex advice threshold.
// The value of this variable shows up on the welcome screen
// and is used as-is unless you change the value.
var default_driving_advice_age = 16;
var default_sex_advice_age = 14;
