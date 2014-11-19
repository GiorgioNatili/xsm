String.prototype.trim = function() {
        return this.replace(/^\s+|\s+$/g,"");
}


// C1 rules handlers
// -------------------------------------------------
function c1z0(s0,s1,s2,c1)
{
        var status = false;
        var logic = normalizeLogic(c1_z0_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function c1z1(s0,s1,s2,c1)
{
        var status = false;
        var logic = normalizeLogic(c1_z1_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function c1c1a(s0,s1,s2,c1)
{
        var status = false;
        var logic = normalizeLogic(c1_c1a_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}

// C6 rules handlers
// -------------------------------------------------
function c6z2(s0,s1,s2,c1,c1a,c2,c3,c4,c5,c6)
{
        var status = false;
        var logic = normalizeLogic(c6_z2_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function c6z3(s0,s1,s2,c1,c1a,c2,c3,c4,c5,c6)
{
        var status = false;
        var logic = normalizeLogic(c6_z3_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function c6z4(s0,s1,s2,c1,c1a,c2,c3,c4,c5,c6)
{
        var status = false;
        var logic = normalizeLogic(c6_z4_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function c6r0(s0,s1,s2,c1,c1a,c2,c3,c4,c5,c6)
{
        var status = false;
        var logic = normalizeLogic(c6_r0_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function c6r1(s0,s1,s2,c1,c1a,c2,c3,c4,c5,c6)
{
        var status = false;
        var logic = normalizeLogic(c6_r1_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function c6r5(s0,s1,s2,c1,c1a,c2,c3,c4,c5,c6)
{
        var status = false;
        var logic = normalizeLogic(c6_r5_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}

// R0 rules handlers
// -------------------------------------------------
function r0z5(c1a,c1b,r0,s0,s1,s2,age,rafft)
{
        var status = false;
        var logic = normalizeLogic(r0_z5_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r0z7(c1a,c1b,r0,s0,s1,s2,age,rafft)
{
        var status = false;
        var logic = normalizeLogic(r0_z7_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r0z8(c1a,c1b,r0,s0,s1,s2,age,rafft)
{
        var status = false;
        var logic = normalizeLogic(r0_z8_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r0z9(c1a,c1b,r0,s0,s1,s2,age,rafft)
{
        var status = false;
        var logic = normalizeLogic(r0_z9_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r0z10(c1a,c1b,r0,s0,s1,s2,age,rafft)
{
        var status = false;
        var logic = normalizeLogic(r0_z10_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r0z11(c1a,c1b,r0,s0,s1,s2,age,rafft)
{
        var status = false;
        var logic = normalizeLogic(r0_z11_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r0r1(c1a,c1b,r0,s0,s1,s2,age)
{
        var status = false;
        var logic = normalizeLogic(r0_r1_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r0r5(c1a,c1b,r0,s0,s1,s2,age)
{
        var status = false;
        var logic = normalizeLogic(r0_r5_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}

// R2 rules handlers
// -------------------------------------------------
function r2r3a(d1)
{
        var status = false;
        var logic = normalizeLogic(r2_r3a_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r2r3b(d1)
{
        var status = false;
        var logic = normalizeLogic(r2_r3b_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}

// R3 rules handlers
// -------------------------------------------------
function r3r4a(d1)
{
        var status = false;
        var logic = normalizeLogic(r3_r4a_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r3r4b(d1)
{
        var status = false;
        var logic = normalizeLogic(r3_r4b_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}

// R4 rules handlers
// -------------------------------------------------
function r4r5(s0,s1,s2,r0,r1,r2,r3a,r3b,r4,rafft,age,c1a,c1b)
{
        var status = false;
        var logic = normalizeLogic(r4_r5_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r4z2(s0,s1,s2,r0,r1,r2,r3a,r3b,r4,rafft,age,c1a,c1b)
{
        var status = false;
        var logic = normalizeLogic(r4_z2_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r4z4(s0,s1,s2,r0,r1,r2,r3a,r3b,r4,rafft,age,c1a,c1b)
{
        var status = false;
        var logic = normalizeLogic(r4_z4_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r4z7(s0,s1,s2,r0,r1,r2,r3a,r3b,r4,rafft,age,c1a,c1b)
{
        var status = false;
        var logic = normalizeLogic(r4_z7_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r4z8(s0,s1,s2,r0,r1,r2,r3a,r3b,r4,rafft,age,c1a,c1b)
{
        var status = false;
        var logic = normalizeLogic(r4_z8_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r4z9(s0,s1,s2,r0,r1,r2,r3a,r3b,r4,rafft,age,c1a,c1b)
{
        var status = false;
        var logic = normalizeLogic(r4_z9_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r4z10(s0,s1,s2,r0,r1,r2,r3a,r3b,r4,rafft,age,c1a,c1b)
{
        var status = false;
        var logic = normalizeLogic(r4_z10_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}


// R14 rules handlers
// -------------------------------------------------
function r14z5(age,s0,s1,s2,d1,r0,r1,r2,r3a,r3b,r4,r5,r6,r7,r8,r9,r10,r11,r12,r13,r14,rafft,c1a,c1b)
{
        var status = false;
        var logic = normalizeLogic(r14_z5_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r14z7(age,s0,s1,s2,d1,r0,r1,r2,r3a,r3b,r4,r5,r6,r7,r8,r9,r10,r11,r12,r13,r14,rafft,c1a,c1b)
{
        var status = false;
        var logic = normalizeLogic(r14_z7_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r14z8(age,s0,s1,s2,d1,r0,r1,r2,r3a,r3b,r4,r5,r6,r7,r8,r9,r10,r11,r12,r13,r14,rafft,c1a,c1b)
{
        var status = false;
        var logic = normalizeLogic(r14_z8_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r14z9(age,s0,s1,s2,d1,r0,r1,r2,r3a,r3b,r4,r5,r6,r7,r8,r9,r10,r11,r12,r13,r14,rafft,c1a,c1b)
{
        var status = false;
        var logic = normalizeLogic(r14_z9_rule);
        eval("if(" + logic + ") { status = true; };");
        return status;
}
function r14z10(age,s0,s1,s2,d1,r0,r1,r2,r3a,r3b,r4,r5,r6,r7,r8,r9,r10,r11,r12,r13,r14,rafft,c1a,c1b)
{
        var status = false;
        var logic = normalizeLogic(r14_z10_rule);
        //alert(logic);
        eval("if(" + logic + ") { status = true; }");
        return status;
}


function normalizeLogic(str)
{
        return str.replace(/AND/g, "&&").replace(/OR/g, "||").replace(/=/g, "==").replace(/>==/g,">=").replace(/<==/g,"<=");
}

if (document.images)
{
        preload_image_object = new Image();
        image_url = new Array();
        image_url[0] = "images/btn-grey-next.gif";
        image_url[1] = "images/btn-grey-next-hover.gif";
        image_url[2] = "images/btn-next.gif";
        image_url[3] = "images/btn-next-hover.gif";
        image_url[4] = "images/radio-1.gif";
        image_url[5] = "images/bg.jpg";
        image_url[6] = "images/btn-next-hover.gif";
        var i = 0;
        for(i=0; i<=6; i++)
                preload_image_object.src = image_url[i];
}


function setCookie(c_name,value,expiredays)
{
        var exdate=new Date();
        exdate.setDate(exdate.getDate()+expiredays);
        document.cookie=c_name+ "=" +escape(value)+
        ((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}

function getCookie(c_name)
{
        if (document.cookie.length>0)
        {
                c_start=document.cookie.indexOf(c_name + "=");
                if (c_start!=-1)
        {
        c_start=c_start + c_name.length+1;
        c_end=document.cookie.indexOf(";",c_start);
        if (c_end==-1) c_end=document.cookie.length;
                return unescape(document.cookie.substring(c_start,c_end));
        }
        }
        return "";
}

function submitSurvey()
{		
		var username2 = $("#username").attr("value").trim();
        window.opener.location.href = "index.asp?status=complete&username="+username2 ;
        document.survey.submit();
}

function setVariables()
{
        var s0 = $(".tob_ev_q:checked").attr("value");
        if(typeof tob_ev == "undefined") { tob_ev = ""; }
        var s1 = $(".tob_3m_q:checked").attr("value");
        if(typeof tob_3m == "undefined") { tob_3m = ""; }
        var s2 = $(".tob_1y_q:checked").attr("value");
        if(typeof tob_1y == "undefined") { tob_1y = ""; }
        var c1 = $(".c1_q:checked").attr("value");
        if(typeof c1 == "undefined") { c1 = ""; }
        var c1a = $(".c1a_q:checked").attr("value");
        if(typeof c1a == "undefined") { c1a = ""; }
        var c1b = $(".c1b_q:checked").attr("value");
        if(typeof c1b == "undefined") { c1b = ""; }
        var c2 = $(".c2_q:checked").attr("value");
        if(typeof c2 == "undefined") { c2 = ""; }
        var c3 = $(".c3_q:checked").attr("value");
        if(typeof c3 == "undefined") { c3 = ""; }
        var c4 = $(".c4_q:checked").attr("value");
        if(typeof c4 == "undefined") { c4 = ""; }
        var c5 = $(".c5_q:checked").attr("value");
        if(typeof c5 == "undefined") { c5 = ""; }
        var c6 = $(".c6_q:checked").attr("value");
        if(typeof c6 == "undefined") { c6 = ""; }

        var r0 = $(".r0_q:checked").attr("value");
        if(typeof r0 == "undefined") { r0 = ""; }
        var r1 = $(".r1_q:checked").attr("value");
        if(typeof r1 == "undefined") { r1 = ""; }
        var r2 = $(".r2_q:checked").attr("value");
        if(typeof r2 == "undefined") { r2 = ""; }
        var r3a = $(".r3a_q:checked").attr("value");
        if(typeof r3a == "undefined") { r3a = ""; }
        var r3b = $(".r3b_q:checked").attr("value");
        if(typeof r3b == "undefined") { r3b = ""; }
        var r4 = $(".r4_q:checked").attr("value");
        if(typeof r4 == "undefined") { r4 = ""; }
        var r5 = $(".r5_q:checked").attr("value");
        if(typeof r5 == "undefined") { r5 = ""; }
        var r6 = $(".r6_q:checked").attr("value");
        if(typeof r6 == "undefined") { r6 = ""; }
        var r7 = $(".r7_q:checked").attr("value");
        if(typeof r7 == "undefined") { r7 = ""; }
        var r8 = $(".r8_q:checked").attr("value");
        if(typeof r8 == "undefined") { r8 = ""; }
        var r9 = $(".r9_q:checked").attr("value");
        if(typeof r9 == "undefined") { r9 = ""; }
        var r10 = $(".r10_q:checked").attr("value");
        if(typeof r10 == "undefined") { r10 = ""; }
        var r11 = $(".r11_q:checked").attr("value");
        if(typeof r11 == "undefined") { r11 = ""; }
        var r12 = $(".r12_q:checked").attr("value");
        if(typeof r12 == "undefined") { r12 = ""; }
        var r13 = $(".r13_q:checked").attr("value");
        if(typeof r13 == "undefined") { r13 = ""; }
        var r14 = $(".r14_q:checked").attr("value");
        if(typeof r14 == "undefined") { r14 = ""; }
        var age = $('#age').attr("value");

        var logic = "";
        
  // set alc    
  logic = normalizeLogic(alc_logic);
  eval("if(" + logic + ") { alc = 1; }");
  // set mj     
  logic = normalizeLogic(mj_logic);
  eval("if(" + logic + ") { mj = 1; }");
  // set drugs  
        logic = normalizeLogic(drugs_logic);
        eval("if(" + logic + ") { drugs = 1; }");
  // set use    
  logic = normalizeLogic(use_logic);
  eval("if(" + logic + ") { use = 1; }");
        // set crafft score
        crafft_score = 0;
        rafft = 0;
        if(c1 == "c1_1" || c1a == "c1a_1" || c1b == "c1b_1") { crafft_score = 1; }
        if(c2 == "c2_1") { crafft_score = crafft_score + 1; rafft = 1; }
        if(c3 == "c3_1") { crafft_score = crafft_score + 1; rafft = rafft + 1; }
        if(c4 == "c4_1") { crafft_score = crafft_score + 1; rafft = rafft + 1; }
        if(c5 == "c5_1") { crafft_score = crafft_score + 1; rafft = rafft + 1; }
        if(c6 == "c6_1") { crafft_score = crafft_score + 1; rafft = rafft + 1; }
        // set ride
        logic = normalizeLogic(ride_logic);
        eval("if(" + logic + ") { ride = 1; }");
        // set drive
        logic = normalizeLogic(drive_logic);
        eval("if(" + logic + ") { drive = 1; }");
        // set depend
        logic = normalizeLogic(depend_logic);
        eval("if(" + logic + ") { depend = 1; }");
        // set acute
        logic = normalizeLogic(acute_logic);
        eval("if(" + logic + ") { acute = 1; }");
        // set red
  logic = normalizeLogic(red_logic);
  eval("if(" + logic + ") { red = 1; }");
                
  // set form values for when report is triggered       
  $("#alc").attr("value", alc);
  $("#mj").attr("value", mj);
  $("#drugs").attr("value", drugs);
  $("#use").attr("value", use);
  $("#ride").attr("value", ride);
  $("#drive").attr("value", drive);
  $("#depend").attr("value", depend);
  $("#acute").attr("value", acute);
  $("#red").attr("value", red);
  $("#crafft_score").attr("value", crafft_score);
  $("#rafft").attr("value", rafft);

}

function setQuestionTime(el,currq)
{
        // ensure any messages are hidden for next question
        $("#msg").hide();

        var tend = new Date();
        var tendval = tend.valueOf();
        var crafft_score = parseInt($("#crafft_score").attr("value"));
        
        var timediff = parseInt(tendval-tstartval)/1000;
        timediff = Math.round(timediff*10)/10;
        $("#"+el+"_t").attr("value",timediff);
        
        if (el != "w1")
        {
                var total_time = parseFloat($("#total_time").attr("value"));
                total_time = Math.round((total_time + timediff)*10)/10;
                $("#total_time").attr("value",total_time);
        }
        
        tstart = new Date();
        tstartval = tstart.valueOf();
        
        if(debug) updateDebugOut();
        
        // tracks the current question in case the person refreshes page
        if (currq != "")
                setCookie("currq",currq,1);
}


function updateDebugOut()
{
        var strhtml = "<table>";
        strhtml = strhtml + "<tr><td>Room:</td><td>" + $("#roomno").attr("value") + "</td><tr>";
        strhtml = strhtml + "<tr><td>Age:</td><td>" + $("#age").attr("value") + "</td><tr>";
        strhtml = strhtml + "<tr><td>Initials:</td><td>" + $("#initials").attr("value") + "</td><tr>";
        strhtml = strhtml + "<tr><td>Doctor:</td><td>" + $("#doctor").attr("value") + "</td><tr>";

        strhtml = strhtml + "<tr><td>Total Time:</td><td>" + $("#total_time").attr("value") + "</td><tr>";

        strhtml = strhtml + "<tr><td>ALC:</td><td>" + $("#alc").attr("value") + "</td><tr>";
        strhtml = strhtml + "<tr><td>MJ:</td><td>" + $("#mj").attr("value") + "</td><tr>";
        strhtml = strhtml + "<tr><td>DRUGS:</td><td>" + $("#drugs").attr("value") + "</td><tr>";
        strhtml = strhtml + "<tr><td>USE:</td><td>" + $("#use").attr("value") + "</td><tr>";
        strhtml = strhtml + "<tr><td>RIDE:</td><td>" + $("#ride").attr("value") + "</td><tr>";
        strhtml = strhtml + "<tr><td>DRIVE:</td><td>" + $("#drive").attr("value") + "</td><tr>";
        strhtml = strhtml + "<tr><td>DEPEND:</td><td>" + $("#depend").attr("value") + "</td><tr>";
        strhtml = strhtml + "<tr><td>ACUTE:</td><td>" + $("#acute").attr("value") + "</td><tr>";
        strhtml = strhtml + "<tr><td>RED:</td><td>" + $("#red").attr("value") + "</td><tr>";
        strhtml = strhtml + "<tr><td>CRAFFT_SCORE:</td><td>" + $("#crafft_score").attr("value") + "</td><tr>";
        strhtml = strhtml + "<tr><td>RAFFT:</td><td>" + $("#rafft").attr("value") + "</td><tr>";

        var quest = "d0_q,d1_q,s0_q,s1_q,s2_q,c1_q,c1a_q,c1b_q,c2_q,c3_q,c4_q,c5_q,c6_q";
        var quest = quest + ",r0_q,r1_q,r2_q,r3a_q,r3b_q,r4_q,r5_q,r6_q,r7_q,r8_q,r9_q,r10_q,r11_q,r12_q,r13_q,r14_q";
        var arrquest = quest.split(',');
        
        for (var i=0; i < arrquest.length; i++)
        {
                eval("var val = $(\"." + arrquest[i] + ":checked\").attr(\"value\");");
                eval("strhtml = strhtml + \"<tr><td>\" + arrquest[i].replace('_q','') + \"</td><td>\" + val +  \"</td></tr>\";");
        }
        strhtml = strhtml + "</table>";
        $("#debugger span").html(strhtml);
}

function validatePosInt()
{
var s = document.frmInput3.txtInputPosInt.value;
switch(isPositiveInteger(s))
{
 case true:
    alert(s + " is a positive integer");
    break;
 case false:
    alert(s + " is not a positive integer");
}
}

function openFullScreen ( aURL, aWinName )
{
   var wOpen;
   var sOptions;

   sOptions = 'fullscreen=no,status=no,menubar=yes,titlebar=no,toolbar=yes,resizable=yes,location=no,menubar=no,scrollbars=no,directories=no';
   /* for production:  sOptions = 'fullscreen=yes,status=no,menubar=no,titlebar=no,toolbar=no,resizable=yes,location=no,menubar=no,scrollbars=no,directories=no'; */
   sOptions = sOptions + ',width=' + (screen.availWidth-10).toString();
   sOptions = sOptions + ',height=' + (screen.availHeight-122).toString();
   sOptions = sOptions + ',screenX=0,screenY=0,left=0,top=0';
   wOpen = window.open( '', aWinName, sOptions );
   wOpen.location = aURL;
   wOpen.focus();
   wOpen.moveTo( 0, 0 );
   wOpen.resizeTo( screen.availWidth, screen.availHeight );
   return wOpen;
}


function left(str, n)
{
   if (n <= 0)
         return "";
   else if (n > String(str).length)
         return str;
   else
         return String(str).substring(0,n);
}

function parseQueryString (str) {
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

function checkEnterKey(e)
{
  var key=e.keyCode? e.keyCode : e.charCode;
  if (key == 13)
  {
    if(!autoadvance)
                {
      if($("#r14").css("display") == "block") r14_Action();
      if($("#r13").css("display") == "block") r13_Action();
      if($("#r12").css("display") == "block") r12_Action();
      if($("#r11").css("display") == "block") r11_Action();
      if($("#r10").css("display") == "block") r10_Action();
      if($("#r9").css("display") == "block") r9_Action();
      if($("#r8").css("display") == "block") r8_Action();
      if($("#r7").css("display") == "block") r7_Action();
      if($("#r6").css("display") == "block") r6_Action();
      if($("#r5").css("display") == "block") r5_Action();
      if($("#r4").css("display") == "block") r4_Action();
      if($("#r3b").css("display") == "block") r3b_Action();
      if($("#r3a").css("display") == "block") r3a_Action();
      if($("#r2").css("display") == "block") r2_Action();
      if($("#r1").css("display") == "block") r1_Action();
      if($("#r0").css("display") == "block") r0_Action();
  
      if($("#c6").css("display") == "block") c6_Action();
      if($("#c5").css("display") == "block") c5_Action();
      if($("#c4").css("display") == "block") c4_Action();
      if($("#c3").css("display") == "block") c3_Action();
      if($("#c2").css("display") == "block") c2_Action();
      if($("#c1b").css("display") == "block") c1b_Action();
      if($("#c1a").css("display") == "block") c1a_Action();
      if($("#c1").css("display") == "block") c1_Action();
  
      if($("#tob_1y").css("display") == "block") tob_1y_Action();
      if($("#tob_3m").css("display") == "block") tob_3m_Action();
      if($("#tob_ev").css("display") == "block") tob_ev_Action();
  
      if($("#d1").css("display") == "block") d1_Action();
                }
    if($("#w3").css("display") == "block") w3a_Action("w3_a");
    if($("#w2").css("display") == "block") w2a_Action("w2_a");
    if($("#w1").css("display") == "block") w1a_Action("w1_a");

                
  }
}

function checkKey(event) {
  var key=e.keyCode? e.keyCode : e.charCode;
  if (key == 13)
  {
        }
}


