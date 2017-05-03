function checkExpositionUpdates(){
	
	if(typeof $.cookie('PHPSESSID') != 'undefined' && $.cookie('PHPSESSID') != '' && $.cookie('PHPSESSID') != null){
	
		var expositionId = $('#expositionId').html();
	
		if(typeof expositionId != 'undefined' && expositionId != ''){
			
			$.ajax({
				scriptCharset: "utf-8" ,
				contentType: "application/x-www-form-urlencoded; charset=UTF-8",
				url: window.location.pathname + '?action=checkExpositionUpdates',
				cache:false,
			    type:"POST",
			    data: {
			    	expositionId: expositionId
					  },
			    dataType: "json",
			    success:function(data){
			    	if (data==null){
			    		launchGenericError();
			    		return;
			    	}
			    	
			    	if(data.length!=2){
			    		launchGenericError();
			    		return false;
			    	}
			    	else{
			    		
			    		//New slide
			    		var currentSlide = parseInt(trimString(data[1]));
			    		var imgSrc = $('#imageLeftPath').html() + (currentSlide - 1) + $('#imageRightPath').html();
			    		$('#presentationLayer img').attr('src',imgSrc);
			    		$('#presentationLayer img').attr('title',imgSrc);
			    		$('#currentSlide').html(currentSlide);
			    		
			    		//Notes layers
			    		
			    		//Hide all notes layers
			    		$('div[id^="notesLayer_"]').hide();
			    		
			    		//Create new layer if doesn't exist
			    		if($('div#notesLayer_'+currentSlide).length <= 0){
			    			var newNotesLayer = '<div id="notesLayer_'+currentSlide+'"><div class="row-fluid show-grid"><div class="span12"></div></div></div>';
			    			$('#notesContainer').append(newNotesLayer);
				    	}
			    		
			    		//Show layer
			    		$('div[id="notesLayer_' + currentSlide + '"]').show();
			    		
			    	}
			    },
			    error:function(){
			    	launchGenericError();
			    	return false;
			    }	
			});
			
		}
		
	}
	
}

$(document).ready(function(){
	
	var interval = self.setInterval(function(){checkExpositionUpdates()},3000);
	
});

function insertExpositionNote(){
	
	var expositionId = $('#expositionId').html();
	var note = $('#currentNote').val();
	var slide = $('#currentSlide').html();
	
	if(typeof expositionId != 'undefined' && expositionId != '' && typeof note != 'undefined' && note != ''  
		&& typeof slide != 'undefined' && slide != ''
	){
		
		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			url: window.location.pathname + '?action=createExpositionNote',
			cache:false,
		    type:"POST",
		    data: {
		    	expositionId: expositionId,
		    	note: note,
		    	slide: slide
				  },
		    dataType: "json",
		    beforeSend:function(){
		    	showLoadingWheel();
		    },
		    complete:function(){
		    	showLoadingWheel()
		    },
		    success:function(data){
		    	if (data==null){
		    		launchGenericError();
		    		return;
		    	}
		    	
		    	if(data.length!=2){
		    		launchGenericError();
		    		return false;
		    	}
		    	else{
		    		var result = data[1];
		    		
		    		if(result == 'true'){
		    			$('#notesLayer_'+slide+' > div > div').append('<div style="margin: 5px; border-radius: 4px;" class="alert-info" slide="' + slide + '">' + note + '</div>');
		    		}
		    		
		    		PopupManager.getActive().close();
		    		
		    	}	
		    },
		    error:function(){
		    	launchGenericError();
		    	return false;
		    }	
		});
		
	}
	
}

function addExpositionNote(){
	
	submitActionAjax(
		window.location.pathname,
		'addExpositionNote',
		'',
		'',
		'',
		'',
		''
	);
	
}

function insertExpositionQuestion(){
	
	var expositionId = $('#expositionId').html();
	var question = $('#currentQuestion').val();
	var slide = $('#currentSlide').html();
	
	if(typeof expositionId != 'undefined' && expositionId != '' && typeof question != 'undefined' && question != ''  
		&& typeof slide != 'undefined' && slide != ''
	){
		
		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			url: window.location.pathname + '?action=createExpositionQuestion',
			cache:false,
		    type:"POST",
		    data: {
		    	expositionId: expositionId,
		    	question: question,
		    	slide: slide
				  },
		    dataType: "json",
		    beforeSend:function(){
		    	showLoadingWheel();
		    },
		    complete:function(){
		    	showLoadingWheel()
		    },
		    success:function(data){
		    	if (data==null){
		    		launchGenericError();
		    		return;
		    	}
		    	
		    	if(data.length!=2){
		    		launchGenericError();
		    		return false;
		    	}
		    	else{
		    		var result = data[1];
		    		
		    		if(result == 'true'){
		    			$('#playerMessages').html('<div style="margin: 5px; border-radius: 4px;" class="alert-success">' + s_message['question_successfully_sent'] + '</div>');
		    			
		    			setTimeout(function(){
		    				$('#playerMessages .alert-success:last').hide('slow');
		    				setTimeout(function(){
			    				$('#playerMessages .alert-success:last').remove();
			    			},2000);
		    			},4000);
		    		}
		    		
		    		PopupManager.getActive().close();
		    		
		    	}	
		    },
		    error:function(){
		    	launchGenericError();
		    	return false;
		    }	
		});
		
	}
	
}

function addExpositionQuestion(){
	
	submitActionAjax(
		window.location.pathname,
		'addExpositionQuestion',
		'',
		'',
		'',
		'',
		''
	);
	
}

function displayMenu(){
	
	if($('#playerMenu').css('display') == 'none'){
		$('#playerMenu').show();
		$('#displayNotesArrow i').removeClass('icon-plus');
		$('#displayNotesArrow i').addClass('icon-minus');
		$('#displayNotesArrow').css('left', '0px');
		$('#displayNotesArrow').css('right', 'auto');
	}
	else{
		$('#playerMenu').hide();
		$('#displayNotesArrow i').removeClass('icon-minus');
		$('#displayNotesArrow i').addClass('icon-plus');
		$('#displayNotesArrow').css('right', '20px');
		$('#displayNotesArrow').css('left', 'auto');
	}
	
}
