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