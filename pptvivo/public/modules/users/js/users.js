function validateUpdateForm(formId){
	
	if(validateForm(formId)){
		$('#' + formId).submit();
	}
	else{
		return;
	}
	
}