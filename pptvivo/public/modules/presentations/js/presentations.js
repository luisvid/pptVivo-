function deletePresentation(presentationId){
	
	if(confirm(s_message['confirm_delete_presentation'])){
		
		if(typeof presentationId != 'undefined' && presentationId != ''){
			
			submitActionAjax(
				window.location.pathname,
				'delete',
				'',
				'',
				'',
				{
					presentationId: presentationId
				},
				''
			);
			
		}
	}
	
}

function viewAttendanceComments(expositionId, presentationId){
	
	submitActionAjax(
		window.location.pathname,
		'viewAttendanceComments',
		'',
		'',
		'',
		{
			expositionId: expositionId,
			presentationId: presentationId
		},
		''
	);
	
}

function deleteAttendedPresentation(presentationId){
	
	if(confirm(s_message['confirm_delete_attendance'])){
		
		if(typeof presentationId != 'undefined' && presentationId != ''){
			
			submitActionAjax(
				window.location.pathname,
				'deleteAttendedPresentation',
				'',
				'',
				'',
				{
					presentationId: presentationId
				},
				''
			);
			
		}
	}
	
}

function createPresentationExposition(presentationId){
	
	if(typeof presentationId != 'undefined' && presentationId != ''){
		
		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			url: window.location.pathname + '?action=createExposition',
			cache:false,
		    type:"POST",
		    data: {
					presentationId: presentationId
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
		    		location.reload();
		    		/*var link = $('#base_presentation_url_' + presentationId).html() + '/' + trimString(data[1]);
		    		var linkObject = '<a target="_blank" href="'+link+'">'+link+'</a>';
		    		$('#presentation_url_' + presentationId + ' div:last').append(linkObject);
		    		$('#presentation_url_' + presentationId + ' div.presentations_links_info').show();
		    		$('#link_presentation_' + presentationId).hide();*/
		    	}	
		    },
		    error:function(){
		    	launchGenericError();
		    	return false;
		    }	
		});
		
	}
	
}

function cancelExposition(expositionId){
	
	if(confirm(s_message['confirm_cancel_exposition'])){
		
		if(typeof expositionId != 'undefined' && expositionId != ''){
			
			submitActionAjax(
				window.location.pathname,
				'cancelExposition',
				'',
				'',
				'',
				{
					expositionId: expositionId
				},
				''
			);
			
		}
	}
	
}

function showBigImage(imagePath){
	
	submitActionAjax(
		window.location.pathname,
		'showBigImage',
		'',
		'',
		'',
		{
			imagePath: imagePath
		},
		''
	);
	
}

function checkExistingFile(){
	
	//Gets the filename without the fake path
	var fileName = $('#control_file').val().split('\\');
	fileName = fileName[2];
	
	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		dataType: "json",
		type: "POST",
		url: window.location.pathname + '?action=checkExistingFile',
		async: true,
		data: {
			fileName: fileName
		}, 
		beforeSend: function(){
			showLoadingWheel();
		},
		complete: function(data){
			showLoadingWheel();
		},
		success: function(data){
			
			$('body').append(data[1]);
			
			var result = trimString($('#basicAjaxResultContainer #ajaxMessageResult').html());
			var message = trimString($('#basicAjaxResultContainer #ajaxMessageResponse').html());
			
			if(result != 1){
				$("#notice").html(message);
				$("#send_file").prop('disabled', true);
			} else {
				$("#notice").html('');
				$("#send_file").prop('disabled', false);
			}
			
			$('#basicAjaxResultContainer').remove();
			
		},
		error: function(){
			$("#notice").html(message);
		}
	});

}

function sendUploadForm(formId){

	if(validateFileFieldForm(formId)){
		$('#' + formId).submit();
	}
	
}

function validateFileFieldForm(formId){
	
	var errors = '';
	var errorsCount = 0;
	
	//Mandatory fields validation
	$('#' + formId + ' .mandatory-input').each(function(){
		
		inputVal = $(this).val();
		
		if(typeof inputVal == 'undefined' || inputVal == '' || inputVal == null){
			$(this).css('border','1px solid red');
			errorsCount ++;
		}
		else{
			$(this).css('border','1px solid #a9bdc6');
		}
		
	});
	
	if(errorsCount > 0){
		errors = s_message['complete_mandatory_fields'];
		$("#notice").html(errors);
		return false;
	}

	//Input file exists validation
	$('#' + formId + ' .input-file-validate').each(function(){
		
		var resultValue = Array();
		
		//Gets the filename without the fake path
		var fileName = $('#control_file').val().split('\\');
		
		/**
		 * Fixme: eliminar la linea siguiente para que funcione el upload de presentaciones en firefox
		 */
		fileName = fileName[2];

		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			dataType: "json",
			type: "POST",
			url: window.location.pathname + '?action=checkExistingFile',
			async: false,
			data: {
				fileName: fileName
			}, 
			beforeSend: function(){
				showLoadingWheel();
			},
			complete: function(data){
				showLoadingWheel();
			},
			success: function(data){
				
				$('body').append(data[1]);
				
				resultValue = {
						result : trimString($('#basicAjaxResultContainer #ajaxMessageResult').html()),
						message : trimString($('#basicAjaxResultContainer #ajaxMessageResponse').html())
				}
				
				$('#basicAjaxResultContainer').remove();
				
			},
			error: function(){
				resultValue = {
						result : '',
						message : 'message_error'
				}
			}
		});
		
		if(resultValue.result != 1){
			$(this).css('border','1px solid red');
			errorsCount ++;
		} else {
			$(this).css('border','1px solid #a9bdc6');
		}
		
	});
	
	if(errorsCount > 0){
		errors = s_message['error_existing_file'];
		$("#notice").html(errors);
		return false;
	}

	if(errors != ''){
		submitActionAjax (window.location.pathname.substring(0,3),commonActionManagerActions.ERRORMESSAGE,'','','',{errorMessage:errors},'reloading_container_'+formId);
		return false;
	}
	else{
		return true;
		$("#notice").html('');
	}
		
}



