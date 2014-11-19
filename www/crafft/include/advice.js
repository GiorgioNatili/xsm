////////////////////////////////////////////////////////////////////////
// $Id: advice.js,v 1.4 2004/08/04 16:22:53 bryce Exp $
////////////////////////////////////////////////////////////////////////
//
// advice.js contains one long Javascript function that outputs
// all the advice bullets for display and print.  First it collects
// information such as the threshold ages and the user's gender and
// stores these in local Javascript variables.  This gets the technical
// stuff out of the way so that the rest of the code can use simple variable
// names.  The rest of the function consists of calls to the advice_item
// function.  (advice_item is defined in resultsadvice.html and report_all.html
// since they display the advice in a different form).
//
// If a bullet is shown under all circumstances, it is simply written
// as a function call to advice_item().  For example, 
//
//    advice_item ("Drugs, including marijuana, can hurt your lungs...");
//
// According to the rules of Javascript, the advice text must be enclosed by
// quotes.  To put an actual quote character (") into an advice bullet, you
// must precede it with a backslash like this:
//  advice_item ("John said, \"Hello.\"");
//
// Some advice items are shown under certain conditions, such as only
// to females above the threshold age.  These advice items are wrapped
// in an IF statement, like this.
//
//  if ( age >= sex_advice_threshold) {
//	advice_item ("If you become pregnant, alcohol and drug use... ");
//  }
//
// If you want to control which items are shown on the screen versus the
// printed report, you can add if statements that test the on_screen
// and on_paper variables.  For example:
//
//  if (on_screen) {
//    advice_item ("this is displayed only on the screen");
//  }
//  if (on_paper) {
//    advice_item ("this is displayed only on the print report");
//  }
//
////////////////////////////////////////////////////////////////////////


function show_first_advice (context) {

  // collect information that will be used to decide what to show
  var sex_advice_threshold = crafft_get_option ("sex_age");
  var driving_advice_threshold = crafft_get_option ("driving_age");
  var age = crafft_get_data ("age");        // age in years (integer)
  var gender = crafft_get_data ("gender");  // either 'm' or 'f'
  var form_num = crafft_get_advice_form_num ();
  var adolescent = (context == 'adolescent');
  var clinician = (context == 'clinician');

////// hardcode values for testing. don't leave these in!
//age = 14;
//gender = "f";
//form_num = 1;
//////

  ii_dbg ("RA2", "showing advice form number "+form_num);
  ii_dbg ("RA2", "with gender="+gender+", age="+age);


//disabled, testing only
// if (adolescent) {
//   advice_item ("This advice is displayed only to the adolescent.");
// }
// if (clinician) {
//   advice_item ("This advice is displayed only for the clinician.");
// }

  if (adolescent)  {
    if (form_num == 1 || form_num == 2){
	advice_item ("Congratulations! Not using drugs and alcohol is a smart decision.");
	}
	if (form_num == 3 || form_num == 4){
	advice_item ("It would be best for your health to <b>stop</b> using drugs and alcohol completely.");
	}
	advice_item ("Scientific studies show:");
    advice_item_sub ("Drugs, including marijuana, can hurt your lungs.");
    advice_item_sub ("Drugs and alcohol affect your brain and can damage it for life.");
    advice_item_sub ("Alcohol can hurt your liver.");
	advice_item_sub ("Alcohol and drugs, including marijuana, cause accidents that kill or injure people.");
    if (age >= sex_advice_threshold) {
	advice_item_sub ("Drug and alcohol use puts teens at higher risk of sexual assault, sexually transmitted infections, and unwanted pregnancy.");
    }
    if ( age >= sex_advice_threshold) {
	advice_item_sub ("If a girl becomes pregnant, drug and alcohol use can hurt the baby."); 	
    }
  }
  
  if (clinician)  {
    if (form_num == 1 || form_num == 2){
    advice_item ("I&#8217;m glad that you&#8217;re not using, that&#8217;s a smart decision.");
	}
	if (form_num == 3 || form_num == 4){
	advice_item ("As your doctor, I recommend that you don&#8217;t use drugs or alcohol at all");
	}
	advice_item ("<i>Mention health effects of substance use:</i>");
    advice_item_sub ("Drugs, including marijuana, can hurt your lungs.");
    advice_item_sub ("Drugs and alcohol affect your brain.");
    advice_item_sub ("Alcohol can hurt your liver.");
    advice_item_sub ("Alcohol and drugs, including marijuana, cause accidents.");	
    if (age >= sex_advice_threshold) {
	advice_item_sub ("Drug and alcohol use puts teens at higher risk of sexual assault, sexually transmitted infections, and unwanted pregnancy.");
    }
    if (age >= sex_advice_threshold) {
	advice_item_sub ("If a girl becomes pregnant, drug and alcohol use can hurt the baby.");
	}
	advice_item ("For your Safety:");
/*	if (age >= driving_advice_threshold) {
	advice_item_sub ("Don&#8217;t ever drive a car after using drugs or drinking, even if you don&#8217;t feel &#8220;high&#8221; or drunk.");
	advice_item_sub ("Don&#8217;t ever get in a car with someone <i>else</i> who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221; or drunk.");
    }
	if (age < driving_advice_threshold) {
	advice_item_sub ("Don&#8217;t ever get in a car with someone who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221; or drunk.");
    }
}}	*/			
    if (age >= driving_advice_threshold) {
	advice_item_sub ("Please don&#8217;t ever drive a car after using drugs or drinking, even if you don&#8217;t feel &#8220;high&#8221 or drunk.");
	advice_item_sub ("Please don&#8217;t ever get in a car with someone <i>else</i> who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221 or drunk.");
    }
 	if (age < driving_advice_threshold) {
	advice_item_sub ("Please don&#8217;t ever get in a car with someone who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221 or drunk.");
    } 
	advice_item_sub ("Make arrangements ahead of time for safe transportation.");
    advice_item_sub ("Please talk to your parents about the Contract for Life.");  
    if (form_num == 2 || form_num == 3 || form_num == 4){
	advice_item_sub ("* If the adolescent reveals that his/her riding with an intoxicated driver involved a parent, sibling or other close relative as the driver, include the following:");
    advice_item_sub2 ("Discuss a safety plan with the adolescent. Consider a follow-up visit if there is not enough time for discussion");
	advice_item_sub2 ("I will speak with your parents about the Contract for Life. I do this with parents of all my patients.");
	advice_item_sub2 ("Please let me know if this ever happens again.");
	}
	if (form_num == 1) {
	advice_item ("I hope you will come back and talk to me if you ever have questions about drugs or alcohol, feel tempted to try them, or even if you do try them. I will keep our discussion confidential, unless you or someone else is in danger. Your health is my primary concern.");
    }
	if (form_num == 3) {
	advice_item ("Would you like to come back and talk to me more about drugs and alcohol? I hope you will let me know if you have any questions about drugs and alcohol. I will keep our discussion confidential, unless you or someone else is in danger. Your health is my primary concern.");
    }
	if (form_num == 4) {
	advice_item ("I&#8217;m worried about you.  I would like you to come back next week so we can discuss this further. I will keep our discussion confidential, unless you or someone else is in danger. Your health is my primary concern.");
    }
  }
	
}
  //	
  // Second page of advice
  //
  //
function show_second_advice (context) {

  // collect information that will be used to decide what to show
  var sex_advice_threshold = crafft_get_option ("sex_age");
  var driving_advice_threshold = crafft_get_option ("driving_age");
  var age = crafft_get_data ("age");        // age in years (integer)
  var gender = crafft_get_data ("gender");  // either 'm' or 'f'
  var form_num = crafft_get_advice_form_num ();
  var adolescent = (context == 'adolescent');
  var clinician = (context == 'clinician');

////// hardcode values for testing. don't leave these in!
//age = 14;
//gender = "f";
//form_num = 1;
//////

  ii_dbg ("RA2", "showing advice form number "+form_num);
  ii_dbg ("RA2", "with gender="+gender+", age="+age);


//disabled, testing only
// if (adolescent) {
//   advice_item ("This advice is displayed only to the adolescent.");
// }
// if (clinician) {
//   advice_item ("This advice is displayed only for the clinician.");
// }

  if (adolescent)  {
   
 	advice_item ("Drug and alcohol related car crashes are a leading cause of death for young people. For your safety:");
    if (age >= driving_advice_threshold) {
	advice_item_sub ("Don&#8217;t ever drive a car after using drugs or drinking, even if you don&#8217;t feel &#8220;high&#8221; or drunk.");
	advice_item_sub ("Don&#8217;t ever get in a car with someone <i>else</i> who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221; or drunk.");
    }
	if (age < driving_advice_threshold) {
	advice_item_sub ("Don&#8217;t ever get in a car with someone who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221; or drunk.");
    }
	advice_item ("Make arrangements ahead of time for safe transportation.");
    advice_item ("Please talk to your parents about the Contract for Life.");   	
	if (form_num == 1 || form_num == 2 || form_num == 3){
	advice_item ("Your doctor will always be available to talk to you about drugs and alcohol.  Any discussions will be confidential.  Your health is your doctor&#8217;s primary concern.");
    }
    if (form_num == 4) { 
	advice_item ("Your doctor will speak with you more about drugs and alcohol. Any discussions will be confidential. Your health is your doctor&#8217;s primary concern."); 
    }
  
  }
  
  if (clinician)  {
    if (form_num == 1 || form_num == 2){
    advice_item ("I&#8217;m glad that you&#8217;re not using, that&#8217;s a smart decision.");
	}
	if (form_num == 3 || form_num == 4){
	advice_item ("As your doctor, I recommend that you don&#8217;t use drugs or alcohol at all");
	}
	advice_item ("<i>Mention health effects of substance use:</i>");
    advice_item_sub ("Drugs, including marijuana, can hurt your lungs.");
    advice_item_sub ("Drugs and alcohol affect your brain.");
    advice_item_sub ("Alcohol can hurt your liver.");
    advice_item_sub ("Alcohol and drugs, including marijuana, cause accidents.");	
    if (age >= sex_advice_threshold) {
	advice_item_sub ("Drug and alcohol use puts teens at higher risk of sexual assault, sexually transmitted infections, and unwanted pregnancy.");
    }
    if ( age >= sex_advice_threshold) {
	advice_item_sub ("If a girl becomes pregnant, drug and alcohol use can hurt the baby.");
	}
	advice_item ("For your Safety:");
/*	if (age >= driving_advice_threshold) {
	advice_item_sub ("Don&#8217;t ever drive a car after using drugs or drinking, even if you don&#8217;t feel &#8220;high&#8221; or drunk.");
	advice_item_sub ("Don&#8217;t ever get in a car with someone <i>else</i> who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221; or drunk.");
    }
	if (age < driving_advice_threshold) {
	advice_item_sub ("Don&#8217;t ever get in a car with someone who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221; or drunk.");
    }
}}	*/			
    if (age >= driving_advice_threshold) {
	advice_item_sub ("Please don&#8217;t ever drive a car after using drugs or drinking, even if you don&#8217;t feel &#8220;high&#8221 or drunk.");
	advice_item_sub ("Please don&#8217;t ever get in a car with someone <i>else</i> who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221 or drunk.");
    }
 	if (age < driving_advice_threshold) {
	advice_item_sub ("Please don&#8217;t ever get in a car with someone who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221 or drunk.");
    } 
	advice_item_sub ("Make arrangements ahead of time for safe transportation.");
    advice_item_sub ("Please talk to your parents about the Contract for Life.");  
    if (form_num == 2 || form_num == 3 || form_num == 4){
	advice_item_sub ("* If the adolescent reveals that his/her riding with an intoxicated driver involved a parent, sibling or other close relative as the driver, include the following:");
    advice_item_sub2 ("Discuss a safety plan with the adolescent. Consider a follow-up visit if there is not enough time for discussion");
	advice_item_sub2 ("I will speak with your parents about the Contract for Life. I do this with parents of all my patients.");
	advice_item_sub2 ("Please let me know if this ever happens again.");
	}
	if (form_num == 1) {
	advice_item ("I hope you will come back and talk to me if you ever have questions about drugs or alcohol, feel tempted to try them, or even if you do try them. I will keep our discussion confidential, unless you or someone else is in danger. Your health is my primary concern.");
    }
	if (form_num == 3) {
	advice_item ("Would you like to come back and talk to me more about drugs and alcohol? I hope you will let me know if you have any questions about drugs and alcohol. I will keep our discussion confidential, unless you or someone else is in danger. Your health is my primary concern.");
    }
	if (form_num == 4) {
	advice_item ("I&#8217;m worried about you.  I would like you to come back next week so we can discuss this further. I will keep our discussion confidential, unless you or someone else is in danger. Your health is my primary concern.");
    }
  }
	
}


function show_all_advice (context) {

  // collect information that will be used to decide what to show
  var sex_advice_threshold = crafft_get_option ("sex_age");
  var driving_advice_threshold = crafft_get_option ("driving_age");
  var age = crafft_get_data ("age");        // age in years (integer)
  var gender = crafft_get_data ("gender");  // either 'm' or 'f'
  var form_num = crafft_get_advice_form_num ();
  var adolescent = (context == 'adolescent');
  var clinician = (context == 'clinician');

////// hardcode values for testing. don't leave these in!
//age = 14;
//gender = "f";
//form_num = 1;
//////

  ii_dbg ("RA2", "showing advice form number "+form_num);
  ii_dbg ("RA2", "with gender="+gender+", age="+age);


//disabled, testing only
// if (adolescent) {
//   advice_item ("This advice is displayed only to the adolescent.");
// }
// if (clinician) {
//   advice_item ("This advice is displayed only for the clinician.");
// }

  if (adolescent)  {
    if (form_num == 1 || form_num == 2){
	advice_item ("Congratulations! Not using drugs and alcohol is a smart decision.");
	}
	if (form_num == 3 || form_num == 4){
	advice_item ("It would be best for your health to <b>stop</b> using drugs and alcohol completely.");
	}
	advice_item ("Scientific studies show:");
    advice_item_sub ("Drugs, including marijuana, can hurt your lungs.");
    advice_item_sub ("Drugs and alcohol affect your brain and can damage it for life.");
    advice_item_sub ("Alcohol can hurt your liver.");
	advice_item_sub ("Alcohol and drugs, including marijuana, cause accidents that kill or injure people.");
    if (age >= sex_advice_threshold) {
	advice_item_sub ("Drug and alcohol use puts teens at higher risk of sexual assault, sexually transmitted infections, and unwanted pregnancy.");
    }
    if ( age >= sex_advice_threshold) {
	advice_item_sub ("If a girl becomes pregnant, drug and alcohol use can hurt the baby.");
    }
 	advice_item ("Drug and alcohol related car crashes are a leading cause of death for young people. For your safety:");
    if (age >= driving_advice_threshold) {
	advice_item_sub ("Don&#8217;t ever drive a car after using drugs or drinking, even if you don&#8217;t feel &#8220;high&#8221; or drunk.");
	advice_item_sub ("Don&#8217;t ever get in a car with someone <i>else</i> who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221; or drunk.");
    }
	if (age < driving_advice_threshold) {
	advice_item_sub ("Don&#8217;t ever get in a car with someone who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221; or drunk.");
    }
	advice_item ("Make arrangements ahead of time for safe transportation.");
    advice_item ("Please talk to your parents about the Contract for Life.");   	
	if (form_num == 1 || form_num == 2 || form_num == 3){
	advice_item ("Your doctor will always be available to talk to you about drugs and alcohol.  Any discussions will be confidential.  Your health is your doctor&#8217;s primary concern.");
    }
    if (form_num == 4) { 
	advice_item ("Your doctor will speak with you more about drugs and alcohol. Any discussions will be confidential. Your health is your doctor&#8217;s primary concern."); 
    }
  
  }
  
  if (clinician)  {
    if (form_num == 1 || form_num == 2){
    advice_item ("I&#8217;m glad that you&#8217;re not using, that&#8217;s a smart decision.");
	}
	if (form_num == 3 || form_num == 4){
	advice_item ("As your doctor, I recommend that you don&#8217;t use drugs or alcohol at all");
	}
	advice_item ("<i>Mention health effects of substance use:</i>");
    advice_item_sub ("Drugs, including marijuana, can hurt your lungs.");
    advice_item_sub ("Drugs and alcohol affect your brain.");
    advice_item_sub ("Alcohol can hurt your liver.");
    advice_item_sub ("Alcohol and drugs, including marijuana, cause accidents.");	
    if (age >= sex_advice_threshold) {
	advice_item_sub ("Drug and alcohol use puts teens at higher risk of sexual assault, sexually transmitted infections, and unwanted pregnancy.");
    }
    if ( age >= sex_advice_threshold) {
	advice_item_sub ("If a girl becomes pregnant, drug and alcohol use can hurt the baby.");
	}
	advice_item ("For your Safety:");
/*	if (age >= driving_advice_threshold) {
	advice_item_sub ("Don&#8217;t ever drive a car after using drugs or drinking, even if you don&#8217;t feel &#8220;high&#8221; or drunk.");
	advice_item_sub ("Don&#8217;t ever get in a car with someone <i>else</i> who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221; or drunk.");
    }
	if (age < driving_advice_threshold) {
	advice_item_sub ("Don&#8217;t ever get in a car with someone who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221; or drunk.");
    }
}}	*/			
    if (age >= driving_advice_threshold) {
	advice_item_sub ("Please don&#8217;t ever drive a car after using drugs or drinking, even if you don&#8217;t feel &#8220;high&#8221 or drunk.");
	advice_item_sub ("Please don&#8217;t ever get in a car with someone <i>else</i> who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221 or drunk.");
    }
 	if (age < driving_advice_threshold) {
	advice_item_sub ("Please don&#8217;t ever get in a car with someone who has been using drugs or drinking, even if that person doesn&#8217;t seem &#8220;high&#8221 or drunk.");
    } 
	advice_item_sub ("Make arrangements ahead of time for safe transportation.");
    advice_item_sub ("Please talk to your parents about the Contract for Life.");  
    if (form_num == 2 || form_num == 3 || form_num == 4){
	advice_item_sub ("* If the adolescent reveals that his/her riding with an intoxicated driver involved a parent, sibling or other close relative as the driver, include the following:");
    advice_item_sub2 ("Discuss a safety plan with the adolescent. Consider a follow-up visit if there is not enough time for discussion");
	advice_item_sub2 ("I will speak with your parents about the Contract for Life. I do this with parents of all my patients.");
	advice_item_sub2 ("Please let me know if this ever happens again.");
	}
	if (form_num == 1) {
	advice_item ("I hope you will come back and talk to me if you ever have questions about drugs or alcohol, feel tempted to try them, or even if you do try them. I will keep our discussion confidential, unless you or someone else is in danger. Your health is my primary concern.");
    }
	if (form_num == 3) {
	advice_item ("Would you like to come back and talk to me more about drugs and alcohol? I hope you will let me know if you have any questions about drugs and alcohol. I will keep our discussion confidential, unless you or someone else is in danger. Your health is my primary concern.");
    }
	if (form_num == 4) {
	advice_item ("I&#8217;m worried about you.  I would like you to come back next week so we can discuss this further. I will keep our discussion confidential, unless you or someone else is in danger. Your health is my primary concern.");
    }
  }
	
}
