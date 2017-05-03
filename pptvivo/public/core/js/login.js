function showRegisterForm(){
	
	createPopup('registerUser');
	
}

function validateLoginForm(formId){
	
	if(validateForm(formId)){
		$('#' + formId).submit();
	}
	else{
		return;
	}
	
}

function showForgotPasswordForm(){
	
	createPopup('forgotPassword');
	
}

$('#loginForm input').keydown(function(event){

	keynum = noNumbers(event);
	
	if(keynum == "13"){
		if($('#errorMessage').size() <= 0){
			validateLoginForm('loginForm');
		}
	}
	
});

function showLoginForm(){
	
	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		url: window.location.pathname + '?action=loginFormPopup',
		cache:false,
	    type:"POST",
	    data: '',
	    dataType: "json",
	    beforeSend:function(){
	    	showLoadingWheel();
	    },
	    complete:function(){
	    	showLoadingWheel();
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
	    		$('body').append(data[1]);
	    	}	
	    },
	    error:function(){
	    	launchGenericError();
	    	return false;
	    }	
	});
	
}

function sendLoginFormAjax(){
	
	if(validateForm('loginForm')){
		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			url: window.location.pathname + '?action=loginAjax',
			cache:false,
		    type:"POST",
		    data: $('#loginForm').serializeArray(),
		    dataType: "json",
		    beforeSend:function(){
		    	showLoadingWheel();
		    },
		    complete:function(){
		    	showLoadingWheel();
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
		    		$('body').append('<div id="ajaxResponseContainer">' + data[1] + '</div>');
		    		if($('#errorCodeAjax').length > 0){
		    			
		    			if($('#recentlyActivatedUser').length > 0){
		    				window.location = '/users?action=downloadInfo';
		    			}
		    			else {
		    				window.location = '/';
		    			}
		    		}
		    		else{
		    			submitActionAjax (window.location.pathname.substring(0,3),commonActionManagerActions.ERRORMESSAGE,'','','',{errorMessage:data[1]},'');
		    		}
		    		$('#ajaxResponseContainer').remove();
		    	}	
		    },
		    error:function(){
		    	launchGenericError();
		    	return false;
		    }	
		});
	}
	else{
		return;
	}
	
}

function sendRegisterForm(){
	
	if(validateForm('registerForm')){
		
		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			url: window.location.pathname + '?action=register',
			cache:false,
		    type:"POST",
		    data: $('#registerForm').serializeArray(),
		    dataType: "json",
		    beforeSend:function(){
		    	showLoadingWheel();
		    },
		    complete:function(){
		    	showLoadingWheel();
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
		    	
		    	$('body').append('<div id="ajaxResponseContainer">' + data[1] + '</div>');
		    	
		    	if($('.success-result').size() > 0){
		    		submitActionAjax (window.location.pathname.substring(0,3),commonActionManagerActions.GENERICMESSAGE,'','','',{message:$('.success-result').html()},'');
		    		$('#registerForm input[type="text"]').val('');
		    		$('#registerForm input[type="password"]').val('');
		    	}
		    	else{
		    		submitActionAjax (window.location.pathname.substring(0,3),commonActionManagerActions.ERRORMESSAGE,'','','',{errorMessage:$('.error-result').html()},'');
		    	}
		    	
		    	$('#ajaxResponseContainer').remove();
		    		
		    },
		    error:function(){
		    	launchGenericError();
		    	return false;
		    }	
		});
	}
	else{
		return;
	}
	
}