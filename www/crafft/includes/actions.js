function ra5_Action() {
		submitSurvey();
}

/*function w1_Action(elm) {
        $("#" + elm).hide();
        $("#w1").hide();
        $("#w2").fadeIn();
        $("#w2_a").fadeIn();
        setQuestionTime("w1","w2");
}

//function w2_Action(elm) {
//        //$("#" + elm).hide();
//        $("#w2").hide();
//        $("#w3").fadeIn();
//        //$("#w3_a").fadeIn();
//        setQuestionTime("w2","w3");
//}

//function w3_Action(elm) { //w3_a
//        //$("#" + elm).hide(); //dont need this line
//        $("#w3").hide();
//        $("#tob_ev").fadeIn();
//        if(!autoadvance) $("#tob_ev .actions").show();
//        setQuestionTime("w3","tob_ev");
//}

//function tob_ev_Action() {
//        $("#tob_ev").hide();
//        setVariables();
//        if(tob_ev == "tob_ev_0")
//        {
//        $("#c1").fadeIn();
//        if(!autoadvance) $("#c1 .actions").show();
//        setQuestionTime("tob_ev","c1");
//        } else {
//        $("#tob_3m").fadeIn();
//        if(!autoadvance) $("#tob_3m .actions").show();
//        setQuestionTime("tob_ev","tob_3m");
//        }		
//}

//function tob_3m_Action() {
//        $("#tob_3m").hide();
//        setVariables();
//		if(tob_3m == "tob_3m_1")
//        {
//        $("#c1").fadeIn();
//        if(!autoadvance) $("#c1 .actions").show();
//        setQuestionTime("tob_3m","c1");
//        } else {
//        $("#tob_1y").fadeIn();
//        if(!autoadvance) $("#tob_1y .actions").show();
//        setQuestionTime("tob_3m","tob_1y");
//        }		
//}

function tob_1y_Action() {
        $("#tob_1y").hide();
        setVariables();
        $("#c1").fadeIn();
        if(!autoadvance) $("#s2 .actions").show();
        setQuestionTime("tob_1y","c1");
}


function c1_Action() {
        $("#c1").hide();
        setVariables();
        if(use == 0)
        {
                setQuestionTime("c1","");
				$("#completed").fadeIn();
                submitSurvey();
        } else {
          alert("c1: use = 1, what do I do?");
        }
}
function c1a_Action() {
        $("#c1a").hide();
        setVariables();
        if(use == 1)
        {
        $("#c1b").fadeIn();
        if(!autoadvance) $("#c1b .actions").show();
        setQuestionTime("c1a","c1b");
        } else {
          alert("c1a: use = 0, what do I do?");
        }
}
function c1b_Action() {
        $("#c1b").hide();
        $("#c2").fadeIn();
        if(!autoadvance) $("#c2 .actions").show();
        setQuestionTime("c1b","c2");
}
function c2_Action() {
        $("#c2").hide();
        $("#c3").fadeIn();
        if(!autoadvance) $("#c3 .actions").show();
        setQuestionTime("c2","c3");
}
function c3_Action() {
        $("#c3").hide();
        $("#c4").fadeIn();
        if(!autoadvance) $("#c4 .actions").show();
        setQuestionTime("c3","c4");
}
function c4_Action() {
        $("#c4").hide();
        $("#c5").fadeIn();
        if(!autoadvance) $("#c5 .actions").show();
        setQuestionTime("c4","c5");
}
function c5_Action() {
        $("#c5").hide();
        $("#c6").fadeIn();
        if(!autoadvance) $("#c6 .actions").show();
        setQuestionTime("c5","c6");
}
function c6_Action() {
        $("#c6").hide();

        setVariables();
        
        if (crafft_score == 0) {
                setQuestionTime("c6","");
                $("#completed").fadeIn();
                submitSurvey();
        } else if (crafft_score > 0 && mj == 1) {
                $("#r0").fadeIn();
                if(!autoadvance) $("#r0 .actions").show();
                setQuestionTime("c6","r0");
        } else if (crafft_score > 0 && mj == 0 && alc == 1) {
                $("#r1").fadeIn();
                if(!autoadvance) $("#r1 .actions").show();
                setQuestionTime("c6","r1");
        } else if (crafft_score > 0 && mj == 0 && alc == 0 && drugs == 1) {
                $("#r5").fadeIn();
                if(!autoadvance) $("#r5 .actions").show();
                setQuestionTime("c6","r5");
        }
}
function r0_Action() {
        $("#r0").hide();

        setVariables();

        if (alc == 1) {
                $("#r1").fadeIn();
                if(!autoadvance) $("#r1 .actions").show();
                setQuestionTime("r0","r1");
        } else if (alc == 0 && drugs == 1) {
                $("#r5").fadeIn();
                if(!autoadvance) $("#r5 .actions").show();
                setQuestionTime("r0","r5");
        } else if (alc == 0 && drugs == 0) {
                setQuestionTime("r0","");
				$("#completed").fadeIn();
                submitSurvey();
        } else {
                alert("r0: no conditions met");
        }
}
function r1_Action() {
        $("#r1").hide();
        $("#r2").fadeIn();
        if(!autoadvance) $("#r2 .actions").show();
        setQuestionTime("r1","r2");
}
function r2_Action() {
        $("#r2").hide();

        var d1 = $(".d1_q:checked").attr("value");

        if (d1 == "d1_0") {
        $("#r3a").fadeIn();
        if(!autoadvance) $("#r3a .actions").show();
        setQuestionTime("r2","r3a");
        }       else if (d1 == "d1_1" || d1 == "d1_2") {
        $("#r3b").fadeIn();
        if(!autoadvance) $("#r3b .actions").show();
        setQuestionTime("r2","r3b");
        } else {
                alert("r2: no conditions met");
        }
        
}
function r3a_Action() {
        $("#r3a").hide();
  $("#r4").fadeIn();
  if(!autoadvance) $("#r4 .actions").show();
  setQuestionTime("r3a","r4");
}
function r3b_Action() {
        $("#r3b").hide();
  $("#r4").fadeIn();
  if(!autoadvance) $("#r4 .actions").show();
  setQuestionTime("r3b","r4");
}
function r4_Action() {
        $("#r4").hide();

        setVariables();

        if (drugs == 1) {
                $("#r5").fadeIn();
                if(!autoadvance) $("#r5 .actions").show();
                setQuestionTime("r4","r5");
        } else if (drugs == 0) {
                setQuestionTime("r4","");
				$("#completed").fadeIn();
                submitSurvey();
        } else {
                alert("r4: no conditions met");
        }
}
function r5_Action() {
        $("#r5").hide();
        $("#r6").fadeIn();
        if(!autoadvance) $("#r6 .actions").show();
        setQuestionTime("r5","r6");
}
function r6_Action() {
        $("#r6").hide();
        $("#r7").fadeIn();
        if(!autoadvance) $("#r7 .actions").show();
        setQuestionTime("r6","r7");
}
function r7_Action() {
        $("#r7").hide();
        $("#r8").fadeIn();
        if(!autoadvance) $("#r8 .actions").show();
        setQuestionTime("r7","r8");
}
function r8_Action() {
        $("#r8").hide();
        $("#r9").fadeIn();
        if(!autoadvance) $("#r9 .actions").show();
        setQuestionTime("r8","r9");
}
function r9_Action() {
        $("#r9").hide();
        $("#r10").fadeIn();
        if(!autoadvance) $("#r10 .actions").show();
        setQuestionTime("r9","r10");
}
function r10_Action() {
        $("#r10").hide();
        $("#r11").fadeIn();
        if(!autoadvance) $("#r11 .actions").show();
        setQuestionTime("r10","r11");
}
function r11_Action() {
        $("#r11").hide();
        $("#r12").fadeIn();
        if(!autoadvance) $("#r12 .actions").show();
        setQuestionTime("r11","r12");
}
function r12_Action() {
        $("#r12").hide();
        $("#r13").fadeIn();
        if(!autoadvance) $("#r13 .actions").show();
        setQuestionTime("r12","r13");
}
function r13_Action() {
        $("#r13").hide();
        $("#r14").fadeIn();
        if(!autoadvance) $("#r14 .actions").show();
        setQuestionTime("r13","r14");
}
function r14_Action() {
        $("#r14").hide();
        setVariables();
        setQuestionTime("r14","");
		$("#completed").fadeIn();
  		submitSurvey();
}*/