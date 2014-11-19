$(document).ready(function(){
	
	// menu
	
	$("#sidebar ul li a.sub").click(function(){
		$(this).next('ul').toggle();
		return false;
	});

	// new patient agreement
	$("#agreement input").click(function(){
		if($(this).val() == 'No')
		{
			$("#refusal").show();
		}
		else
		{
			$("#refusal").hide();
		}
	});
	
	// show/hide boxes
	$("#summaryLeft .body .bttn, #summaryRight .body .bttn, #summaryRight2 .body .bttn").click(function(){
		var box = $(this).attr('rel');
		if(box)
		{
			$("#"+box).slideToggle();
			if($(this).hasClass('bttnOpen'))
			{
				$(this).removeClass('bttnOpen');
			}
			else
			{
				$(this).addClass('bttnOpen');
			}
		}
		$('.sendConfirm').hide();
		return false;
	});
	
	// send cloud
	$("#summaryRight .body .cloudBttn, #summaryRight2 .body .cloudBttn").click(function(){
		$('.sendConfirm').hide();
		var box = $(this).attr('rel');
		if(box)
		{
			$("#"+box).toggle();
		}
		return false;
	});
	$(".sendConfirm .cont .no").click(function(){
		$(this).parent().parent('.sendConfirm').hide();
		return false;
	});
	$("#summaryRight .body, #summaryRight2 .body").scroll(function(){
		$('.sendConfirm').hide();
	});
	
	
	// step4 questions
	Array.prototype.inArray = function(v){
		for(var i in this){if(this[i] == v){return true;}}return false;
	}
	
	arr1 = new Array(1, 4, 7, 10, 13, 16, 19, 22, 25, 28, 31, 34, 37);
	arr2 = new Array(2, 5, 8, 11, 14, 17, 20, 23, 26, 29, 32, 35, 38);
	arr3 = new Array(3, 6, 9, 12, 15, 18, 21, 24, 27, 30, 33, 36, 39);
	
	$("#preTlfb input").click(function(){
		
		var id=$(this).attr('id');
		id = id.split('_');
		
		if(id[2] == 'a' && arr1.inArray(id[1]))
		{
			$(this).parent().parent().next('.preTlfbBox').removeClass('preTlfbBoxHide');
		}
		else if(id[2] == 'b' && arr1.inArray(id[1]))
		{
			$(this).parent().parent().next('.preTlfbBox').addClass('preTlfbBoxHide');
			$(this).parent().parent().next('.preTlfbBox').next('.preTlfbBox').addClass('preTlfbBoxHide');
			$(this).parent().parent().next('.preTlfbBox').next('.preTlfbBox').next('.preTlfbBox').removeClass('preTlfbBoxHide');
			
			$(this).parent().parent().next('.preTlfbBox').children('.answers').children('input').attr('checked', false);
			$(this).parent().parent().next('.preTlfbBox').next('.preTlfbBox').children('.answers').children('input').attr('checked', false);
		}
		else if(id[2] == 'a' && arr2.inArray(id[1]))
		{
			$(this).parent().parent().next('.preTlfbBox').removeClass('preTlfbBoxHide');
		}
		else if(id[2] == 'b' && arr2.inArray(id[1]))
		{
			$(this).parent().parent().next('.preTlfbBox').addClass('preTlfbBoxHide');
			$(this).parent().parent().next('.preTlfbBox').next('.preTlfbBox').removeClass('preTlfbBoxHide');
			
			$(this).parent().parent().next('.preTlfbBox').children('.answers').children('input').attr('checked', false);
		}
		else if(id[2] == 'a' || id[2] == 'b' && (arr3.inArray(id[1])))
		{
			$(this).parent().parent().next('.preTlfbBox').removeClass('preTlfbBoxHide');
		}
		
		/************/
		
		if(id[2]=='b' && (id[1]==37 || id[1]==38 || id[1]==39))
		{
			$('.newPatientFormSubmit').show();
		}
		else if(id[2]=='a' && (id[1]==37 || id[1]==38))
		{
			$('.newPatientFormSubmit').hide();
		}
		else if(id[2]=='a' && id[1]==39)
		{
			$('.newPatientFormSubmit').show();
		}
	});
	
	
	// step5 calendar
	$("#tlfbCalendar .months li").click(function(){
		if(!$(this).hasClass('active'))
		{
			var showDivID = $(this).attr('id') + 'Box';
			
			$('#tlfbCalendar .months li').removeClass('active');
			$(this).addClass('active');
			
			$('#tlfbCalendar .monthBox').hide();
			$('#'+showDivID).show();
		}
	});
	
	$(".monthBox table td").mouseenter(function(){
		if($(this).children('span').size()>0)
		{
			$(this).tooltip({ 
			    bodyHandler: function() { 
			        return $(this).children('span').html();
			    }, 
			    delay: 0,
			    extraClass: 'tlfbCalendarTooltip',
			    track: true,
			    showURL: false 
			});
		}
	});
	
	$(".step5Calendar .monthBox table td").not('.empty, .emptyOdd').click(function(){
		$("#addDate").val($(this).children('input').val());
		if($(this).children('span').size()>0)
		{
			var text = $(this).children('span').html();
			text = text.replace(/<strong>(.+)<\/strong>/, '');
			$("#addForm textarea").val(text);
		}
		else
		{
			$("#addForm textarea").val();
		}
		$("#addForm").modal({
			overlayClose:true,
			overlayId:'tlfbCalendarOverlay',
			closeClass:'cancel'
		});
	});
	
	
	// step6 calendar
	$(".step6Calendar .monthBox table td").not('.empty, .emptyOdd').click(function(){
		
		$("#addForm .stimulants input.stimulant").val('')
		
		if($(this).children('.options').size()>0)
		{
			$(this).children('.options').children('span').each(function(i){
				var className = $(this).attr('class');
				className = className.split('_');
				$("#stimulant_" + className[1]).val($(this).html());
			});
		}
		
		$("#addDate").val($(this).children('input').val());
		$("#addForm .currentDate").html($(this).children('input').attr('title'));
		$("#addForm").modal({
			overlayClose:true,
			overlayId:'tlfbCalendarOverlay',
			position: [100,],
			closeClass:'cancel'
		});
		
	});
	
});

function redirect(href)
{
	document.location=href;
}



/*
function strip_tags(html){
	 
	//PROCESS STRING
	if(arguments.length < 3) {
		html=html.replace(/<\/?(?!\!)[^>]*>/gi, '');
	} else {
		var allowed = arguments[1];
		var specified = eval("["+arguments[2]+"]");
		if(allowed){
			var regex='</?(?!(' + specified.join('|') + '))\b[^>]*>';
			html=html.replace(new RegExp(regex, 'gi'), '');
		} else{
			var regex='</?(' + specified.join('|') + ')\b[^>]*>';
			html=html.replace(new RegExp(regex, 'gi'), '');
		}
	}

	//CHANGE NAME TO CLEAN JUST BECAUSE 
	var clean_string = html;

	//RETURN THE CLEAN STRING
	return clean_string;
}
*/