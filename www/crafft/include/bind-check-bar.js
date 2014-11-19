$(document).ready(function () {
			
			var flag = 1;
			
            // alert($("span.actions a").length);
            // Bind click event to all "Next" buttons 
            $("span.actions a").each(function () {
                // every <a>'s id
                $("#" + this.id).click(function () { 
					var questionAction = new qAction(this.id);
					questionAction.navAction(questionAction); 
					
					// id of <a> check if the user has chosen an answer. If not, stay in the same div.
					var idofa = this.id;
						
					// get the number of the <a></a> div tag
					// document.write(str.slice(1,-2));
					var idnumber = idofa.slice(1,-2);
						
					// create the current div tag id
					var currentdivid = "q" + idnumber;
						
					var q_y = $("#" + currentdivid + "_0").is(':checked');
					var q_n = $("#" + currentdivid + "_1").is(':checked');
					
					// those div tag of next button don't need to check empty input.
					if (q_y == false && q_n == false && this.id !== "w1_a" && this.id !== "w2_a" && this.id !== "w3_a"
					 && this.id !== "score1_a" && this.id !== "score2_a" && this.id !== "info1_a" && this.id !== "info2_a" && this.id !== "info3_a"
					 && this.id !== "info4_a" && this.id !== "info5_a" && this.id !== "info6_a" && this.id !== "info7_a" && this.id !== "info8_a"
					 && this.id !== "info9_a" && this.id !== "info10_a" && this.id !== "info11_a" && this.id !== "q44_a") 
					{		
						// create the next div tag number 
						var newidnumber = parseInt(idnumber,10) + 1;
						
						var newid = "q" + newidnumber;
						
						//document.write(newid);
						
						$("#" + currentdivid).show();
						$("#" + newid).hide();
						
						showMessage ();
         		   }
				   else 
				   {
				    	flag = 1;
				   }
				});
            });
				
				// only for q20, cause it has the medicine field that needs to be typed.
				$("#q20_1").click(function() { 
					var q20_y = $('#q20_1').is(':checked');
					if (q20_y == true) 
					{		
							$("#q20_answer").show();
         		    }
				});
				
				$("#q20_0").click(function() { 
					var q20_n = $('#q20_0').is(':checked');
					if (q20_n == true) 
					{		
							$("#q20_answer").hide();
         		    }
				});
				
				$("#q20_a").click(function() { 
					var q_y = $('#q20_1').is(':checked');
					if (q_y == true) 
					{		
							if  ($("#q20_drugname").val() == "")
							{	
								// stay in the same div tag when the drug name is empty.
								flag = 0;
								$("#q20").show();
								$("#q21").hide();
								
								$("#msg span").show();
                   	 			$("#msg span").html("Please type the drugs' names in question 20.");
                   		 		$("#msg").fadeIn().css("background-color", "#ff0000").animate({backgroundColor: "#ffffff"}, 1200);   
						    }
         		    }
				   else 
				   {
				   	 	flag = 1;
				   }
				});
				
				// only for q44, cause it's the last question that has the yes and no options.
				   $("#q44_a").click(function() { 
					var q_y = $('#q44_1').is(':checked');
					var q_n = $('#q44_0').is(':checked');
					if (q_y == false && q_n == false) 
					{	
						// stay in the same div tag, cause the user hasn't clicked any options.	hide the next div tag that it will automatically go to.
						$("#q44").show();
						$("#score1").hide();
		          	 	showMessage ();
         		   }
				   else 
				   {
				   	 	flag = 1;
				   }
				});
				
			function showMessage () {
				flag = 0;
		        $("#msg span").show();
                $("#msg span").html("Please answer the question.");
                $("#msg").fadeIn().css("background-color", "#ff0000").animate({backgroundColor: "#ffffff"}, 1200);   	
			}
			
			// change the css for the process bar
			$("#q1_a").click(function() { 
					if (flag == 1)
					{
						$('#bar-progress').removeClass('barZero').addClass('barTen');
					} 
				}); 
				
			$("#q9_a").click(function() { 
					if (flag == 1)
					{
						$('#bar-progress').removeClass('barTen').addClass('barTwenty'); 
					}
				}); 
				
			$("#q18_a").click(function() { 
					if (flag == 1)
					{
						$('#bar-progress').removeClass('barTwenty').addClass('barThirty'); 
					}
				}); 
				
			$("#q28_a").click(function() { 
					if (flag == 1)
					{
						$('#bar-progress').removeClass('barThirty').addClass('barForty'); 
					}
				}); 
				
			$("#q37_a").click(function() { 
					if (flag == 1)
					{
						$('#bar-progress').removeClass('barForty').addClass('barFifty'); 
					}
				});  
				
			$("#score1_a").click(function() { 
					$('#bar-progress').removeClass('barFifty').addClass('barSixty'); 
				}); 
				
			$("#info3_a").click(function() { 
					$('#bar-progress').removeClass('barSixty').addClass('barSeventy'); 
				}); 
				
			$("#info6_a").click(function() { 
					$('#bar-progress').removeClass('barSeventy').addClass('barEighty'); 
				}); 
				
			$("#info9_a").click(function() { 
					$('#bar-progress').removeClass('barEighty').addClass('barNinety'); 
				}); 
				
			$("#info11_a").click(function() { 
					$('#bar-progress').removeClass('barNinety').addClass('barFull'); 
				}); 
 
        });  //end of document ready */