/*
 * DOM and Styles
 */
function coverAllDiv(){
	
	if($('.cover-all-div').size() == 0){	
		$('body').append('<div class="popup-background cover-all-div"></div>');
		myHeight = $(document).height();
		$('.cover-all-div').css('height',myHeight+'px');
	}
	else{
		$('.cover-all-div').remove();
	}
}

function showLoadingButton(elem){
	
	if($('#' + elem + ' #loading-button-msg').length > 0){	
		$('#' + elem + ' #loading-button-msg').remove();
	}
	else{
		$('#'+elem).append('<span id="loading-button-msg"><img alt="'+s_message['loading']+'" src="/core/img/popup/ajax-loader.gif" /></span>');
	}
}

function showLoadingWheel(){
	
	coverAllDiv();
	
	if($('#loading-button-msg').length > 0){	
		$('#loading-button-msg').remove();
	}
	else{
		$('body').append('<span id="loading-button-msg" style="display: none;"><img alt="'+s_message['loading']+'" src="/core/img/popup/ajax-loader-small.gif" /></span>');
		centerDomElement('#loading-button-msg');
		$('#loading-button-msg').show();
	}
	
}

function reloj(){
	var fObj=new Date();
	var horas=fObj.getHours();
	var minutos=fObj.getMinutes();
	var segundos=fObj.getSeconds();
	if(horas<=9)horas="0"+horas;
	if(minutos<=9)minutos="0"+minutos;
	if(segundos<=9)segundos="0"+segundos;
	$('#date').html('');
	$('#date').html('<strong>'+horas+':'+minutos+':'+segundos+'</strong>');
	setTimeout("reloj()",1000);
}

function centerDomElement(element){

	//Placing the popup if there's scroll
	var screenWidth = screen.width;
	var width = $(element).width();
	
	docWidth = $(document).width();
	docHeight = $(document).height();
	
	//Scroll Check
	var ScrollTop = document.body.scrollTop;
	var ScrollLeft = document.body.scrollLeft;
	
	if (ScrollTop == 0)
	{
		if (window.pageYOffset)
			ScrollTop = window.pageYOffset;
		else
			ScrollTop = (document.body.parentElement) ? document.body.parentElement.scrollTop : 0;
	}
	
	if (ScrollLeft == 0)
	{
		if (window.pageXOffset)
			ScrollLeft = window.pageXOffset;
		else
			ScrollLeft = (document.body.parentElement) ? document.body.parentElement.scrollLeft : 0;
	}
	
	leftDistance = (screenWidth/2) - (width/2)  + ScrollLeft;
	topDistance = 20 + ScrollTop;
	
	$(element).css('left',leftDistance + 'px');
	$(element).css('top',topDistance + 'px');
}

/*
 * Popups and messages
 */
function errorMessage(url,width,height,message){
	// Quito el foco del boton submit para evitar multiples envios del
	// formulario.
	$("form:last input:text:first").focus();	
	var p=PopupManager.create();
	p.configure({
		type:'error',
		modal:true,
		width:width,
		height:height,
		bg:'light',
		url:url,
		message:message
	});
	p.draw();
}

function customMessageBox(width,height,message){
	// Quito el foco del boton submit para evitar multiples envios del
	// formulario.
	$("form:last input:text:first").focus();	
	var p=PopupManager.create();
	p.configure({
		type:'noajax',
		modal:true,
		width:width,
		height:height,
		bg:'light',
		message:message
	});
	p.draw();
}

function messagebox(message){
	// Quito el foco del boton submit para evitar multiples envios del
	// formulario.
	$("form:last input:text:first").focus();	
	var p=PopupManager.create();
	p.configure({
		type:'noajax',
		modal:true,
		bg:'light',
		message:message
	});
	p.draw();
}

function openPrintPopUp(){
	clearActionsRightForm();
	$("#title_form_popup").val($("#title-section").html());
	$("#content_form_popup").val($('div[class^=center-div]').html());
	$("#head_form_popup").val($("head").html());			
	// $('#actions_print_form').attr('action','');
	form = document.getElementById('actions_print_form');	
	var myInput = document.createElement("input") ;	 
	myInput.setAttribute("name", "action");
	myInput.setAttribute("type", "hidden");
	myInput.setAttribute("value", commonActionManagerActions.PRINTPAGE);
	form.appendChild(myInput);
	$('#actions_print_form').submit();	
	clearActionsRightForm();
}

function popup(url){
	var p=PopupManager.create();
		p.configure({
		type:'users',
		modal:true,
		width:572,
		height:400,
		bg:'light',
		url:url
	});
	p.draw();
}

/**
 * Dummy popup. All the logic is in the action manager
 *  * @param action
 */
function createPopup(action){
	
	submitActionAjax(
			window.location.pathname,
			action,
			'',
			'',
			'',
			'',
			''
		);
	
}

/*
 * Forms and validations
 */

function sendContactForm(url,action){
	
	if(!validateContactsForm()){
		return false;
	}
	else{
		ajaxSubmitActionForm (url,action,'','','contact_form','','','contact-button-cell');
	}
	
}

function validateContactsForm(url) {
	
	$('#errorMessage').remove();
	$('#successMessage').remove();
	$('#Msg').remove();
	$('#contact-result-message').remove();
	
	var name=document.contact_form.name.value;
	var surname=document.contact_form.surname.value;
	var mail=document.contact_form.mail.value;
	var phone=document.contact_form.phone.value;
	var address=document.contact_form.address.value;
	var postal_code=document.contact_form.postal_code.value;
	var city=document.contact_form.city.value;
	var country=document.contact_form['country'];
	var empty=s_message['field_should_not_be_empty'];
	var error_non_numeric=s_message['error_non_numeric'];
	var error_numeric=s_message['error_numeric'];
	var wrong_format=s_message['wrong_format'];
	var select_an_option=s_message['must_select_an_option'];
	var error_max_length=s_message['error_field_max_length'];
	var name_label=s_message['name'];
	var surname_label=s_message['surname'];
	var phone_label=s_message['phone'];
	var postal_label=s_message['postal_code'];
	var mail_label = s_message['email'];
	var country_label = s_message['country'];
	var city_label = s_message['city'];
	var message_errors = '';
	
	$('#contact-form-name-input').css("border","1px solid #72A7D1");
	$('#contact-form-surname-input').css("border","1px solid #72A7D1");
	$('#contact-form-country-input').css("border","1px solid #72A7D1");
	$('#contact-form-mail-input').css("border","1px solid #72A7D1");
	
	if (mail=='') {
		$('#contact-form-mail-input').css("border","1px solid #ff0000");
		message_errors += mail_label + ': ' + empty + '<br />';		
	}
	if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)){
		$('#contact-form-mail-input').css("border","1px solid #ff0000");
		message_errors += mail_label + ': ' + wrong_format + '<br />';		
	}
	if (name=='') {
		$('#contact-form-name-input').css("border","1px solid #ff0000");
		message_errors += name_label + ': ' + empty + '<br />';
	}
	if (validaCaracteresAlfabeticos(name)) {
		$('#contact-form-name-input').css("border","1px solid #ff0000");
		message_errors += name_label + ': ' + error_non_numeric + '<br />';
	}
	if (surname=='') {
		$('#contact-form-surname-input').css("border","1px solid #ff0000");
		message_errors += surname_label + ': ' + empty + '<br />';
	}
	if (validaCaracteresAlfabeticos(surname)) {
		$('#contact-form-surname-input').css("border","1px solid #ff0000");
		message_errors += surname_label + ': ' + error_non_numeric + '<br />';
	}
	if (country.selectedIndex==-1)  {	
		$('#contact-form-country-input').css("border","1px solid #ff0000");
		message_errors += country_label + ': ' + empty + '<br />';
	}	
	if (phone != ''){
		if(phone.length>30){
			$('#contact-form-phone-input').css("border","1px solid #ff0000");
			message_errors += phone_label + ': ' + error_numeric + '<br />';
		}
		else{
			$('#contact-form-phone-input').css("border","1px solid #72A7D1");
		}
	}
	if (postal_code != ''){
		if(isNaN(postal_code)){
			$('#contact-form-postal-input').css("border","1px solid #ff0000");
			message_errors += postal_label + ': ' + error_max_length + '<br />';
		}
		else{
			$('#contact-form-postal-input').css("border","1px solid #72A7D1");
		}
	}
	if(message_errors != ''){
		
		submitActionAjax ('/en',commonActionManagerActions.ERRORMESSAGE,'','','',{errorMessage:message_errors},'contact-button-cell');
	
		return false;
	
	}
	else{
		
		return true;
	}
}

function clearMe(formfield){
	if (formfield.defaultValue==formfield.value){
		formfield.value = ""
	}
}

function resetForm(formId){
	
	$('#'+formId+' input[type="text"]').val('');
	$('#'+formId+' input[type="hidden"]').val('');
	$('#'+formId+' input[type="checkbox"]').attr('checked',false);
	$('#'+formId+' select').val('');
	$('#'+formId+' textarea').val('');
	
	if($('#filter_processId').length > 0){
		$('#filter_processId').trigger('change');
	}
	
}

function clearActionsRightForm(){
	$("#title_form_popup").val("");
	$("#content_form_popup").val("");
	$("#head_form_popup").val("");
}

function validaCaracteresEspeciales(x){
	var vale = 0;
	var aceptadas = [65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,48,49,50,51,52,53,54,55,56,57,95,45];
	
	for(i=0;i < x.length;i++){
		
		var car = x.charCodeAt(i);
		
		for(j=0;j < aceptadas.length;j++){
			
			if(car == aceptadas[j]){
				vale++;
				break
			}
		}
	}

	if(vale != x.length)
		return true;
	else 
		return false;
	}

function validaCaracteresNumericos(x){
	
	var vale = 0;
	var aceptadas = [32,48,49,50,51,52,53,54,55,56,57];
	
	for(i=0;i < x.length;i++){
		
		var car = x.charCodeAt(i);
		
		for(j=0;j < aceptadas.length;j++){
			
			if(car == aceptadas[j]){
				vale++;
				break;
			}
		}
	}

	if(vale != x.length)
		return true;
	else 
		return false;
	}

function validaCaracteresAlfabeticos(x){
	
	var vale = 0;
	var aceptadas = [32,39,45,46,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,192,193,194,200,201,202,204,205,206,209,210,211,212,217,218,219,241,224,225,226,232,233,234,236,237,238,242,243,244,249,250,251,231,199];
	
	for(i=0;i < x.length;i++){
		
		var car = x.charCodeAt(i);
		
		for(j=0;j < aceptadas.length;j++){
			
			if(car == aceptadas[j]){
				vale++;
				break;
			}
		}
	}

	if(vale != x.length)
		return true;
	else
		return false;

}

function validateDependencies(fieldsToCheck){
	
	if(typeof fieldsToCheck != 'undefined' && fieldsToCheck != ''){
	
		fieldsToCheckList = fieldsToCheck.split(';');
		
		var errorsCount = 0;
		
		for(i=0; i < fieldsToCheckList.length; i++){
			
			fieldValue = $('#'+fieldsToCheckList[i]).val();
			
			if(typeof fieldValue == 'undefined' || fieldValue == null || fieldValue == ''){
				
				if($('#label_'+fieldsToCheckList[i]).length > 0){				
					$('#label_'+fieldsToCheckList[i]).css('border','1px solid red');
				}
				else{
					$('#'+fieldsToCheckList[i]).css('border','1px solid red');
				}
				
				errorsCount ++;
				
			}
			else{
				
				if($('#label_'+fieldsToCheckList[i]).length > 0){				
					$('#label_'+fieldsToCheckList[i]).css('border','1px solid #a9bdc6');
				}
				else{
					$('#'+fieldsToCheckList[i]).css('border','1px solid #a9bdc6');
				}
				
			}
			
		}
		
		if(errorsCount > 0){
		
			errors = s_message['complete_mandatory_fields'];
		
			submitActionAjax (window.location.pathname.substring(0,3),commonActionManagerActions.ERRORMESSAGE,'','','',{errorMessage:errors},'');
		
			return false;
		
		}
		else {
			
			return true;
			
		}
	}
	else{
		return true;
	}
	
}

function validateForm(formId){
	
	var errorsCount = 0;
	
	//Mandatory fields validation
	$('#' + formId + ' .mandatory-input').each(function(){
		
		var mustValidate = $(this).attr('validate');
		
		if(typeof mustValidate == 'undefined' || mustValidate == 1){
			
			if($(this).attr('multiple')=='multiple'){
				inputVal = $(this).val();
			}
			else{
				inputVal = trimString($(this).val());
			}
			
			if(typeof inputVal == 'undefined' || inputVal == '' || inputVal == null){
				
				if($(this).attr('type') == 'hidden'){
					inputId = $(this).attr('id');
					visibleInputId = 'label_' + inputId;
					$('#' + visibleInputId).css('border','1px solid red');
				}
				else{
					$(this).css('border','1px solid red');
				}
				
				errorsCount ++;
				
			}
			else{
				
				if($(this).attr('type') == 'hidden'){
					inputId = $(this).attr('id');
					visibleInputId = 'label_' + inputId;
					$('#' + visibleInputId).css('border','1px solid #a9bdc6');
				}
				else{
					$(this).css('border','1px solid #a9bdc6');
				}
				
			}
			
		}
		
	});
	
	if(errorsCount > 0){
		
		errors = s_message['complete_mandatory_fields'];
	
		submitActionAjax (window.location.pathname.substring(0,3),commonActionManagerActions.ERRORMESSAGE,'','','',{errorMessage:errors},'');
		
		return false;
	
	}
	
	//Input text validation
	$('#' + formId + ' .input-text-validate').each(function(){
		
		inputValue = trimString($(this).val());
		
		if(inputValue != ''){
		
			inputTextLength = $(this).attr('maxlength');
			inputValueLength = inputValue.length;
			
			if(inputValueLength > inputTextLength){
				$(this).css('border','1px solid red');
				errorsCount ++;
			}
			else{
				$(this).css('border','1px solid #a9bdc6');
			}
		}
		
	});
	
	if(errorsCount > 0){
		
		errors = s_message['error_field_max_length'];
	
		submitActionAjax (window.location.pathname.substring(0,3),commonActionManagerActions.ERRORMESSAGE,'','','',{errorMessage:errors},'');
		
		return false;
	
	}
	
	//Input number validation
	$('#' + formId + ' .input-number-validate').each(function(){
		
		inputValue = trimString($(this).val());
		
		if(inputValue != ''){
		
			inputTextLength = $(this).attr('maxlength');
			inputValueLength = inputValue.length;
			
			if(inputValueLength > inputTextLength){
				$(this).css('border','1px solid red');
				errorsCount ++;
			}
			else if(!$.isNumeric(inputValue)){
				$(this).css('border','1px solid red');
				errorsCount ++;
			}
			else{
				$(this).css('border','1px solid #a9bdc6');
			}
		
		}
		
	});
	
	if(errorsCount > 0){
		
		errors = s_message['error_numeric_length'];
	
		submitActionAjax (window.location.pathname.substring(0,3),commonActionManagerActions.ERRORMESSAGE,'','','',{errorMessage:errors},'');
		
		return false;
	
	}
	
	//Input mail validation
	$('#' + formId + ' .input-mail-validate').each(function(){
		
		inputValue = trimString($(this).val());
		
		if(inputValue != ''){
			
			if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(inputValue)){
				$(this).css('border','1px solid red');
				errorsCount ++;
			}
			else{
				$(this).css('border','1px solid #a9bdc6');
			}
		}
		
	});
	
	if(errorsCount > 0){
		
		errors = s_message['error_mail_format'];
	
		submitActionAjax (window.location.pathname.substring(0,3),commonActionManagerActions.ERRORMESSAGE,'','','',{errorMessage:errors},'');
		
		return false;
	
	}
	
	//Input phone validation
	$('#' + formId + ' .input-phone-validate').each(function(){
		
		inputValue = trimString($(this).val());
		
		if(inputValue != ''){
			
			if(checkPhone(inputValue) == false){
				$(this).css('border','1px solid red');
				errorsCount ++;
			}
			else{
				$(this).css('border','1px solid #a9bdc6');
			}
		}
		
	});
	
	if(errorsCount > 0){
		
		errors = s_message['phone_wrong_format'];
	
		submitActionAjax (window.location.pathname.substring(0,3),commonActionManagerActions.ERRORMESSAGE,'','','',{errorMessage:errors},'');
		
		return false;
	
	}
	
	//Input password validation
	if($('#' + formId + ' .input-password-validate').length > 0){
	
		var firstPassword = trimString($('#' + formId + ' .input-password-validate:first').val());
		var repeatPassword = trimString($('#' + formId + ' .input-password-validate:last').val());
		
		if(firstPassword != repeatPassword){
			$('#' + formId + ' .input-password-validate').css('border','1px solid red');
			errorsCount ++;
		}
		else{
			$('#' + formId + ' .input-password-validate').css('border','1px solid #a9bdc6');
		}
		
		if(errorsCount > 0){
			
			errors = s_message['passwords_match_error'];
		
			submitActionAjax (window.location.pathname.substring(0,3),commonActionManagerActions.ERRORMESSAGE,'','','',{errorMessage:errors},'');
			
			return false;
		
		}
		
	}
	
	return true;
	
}

function sendFormAjax(formId, returnId, ajaxLoadingId){
	
	if(typeof returnId == 'undefined' || returnId == '' || returnId == null){
		returnId = '';
	}
	
	if(typeof ajaxLoadingId == 'undefined' || ajaxLoadingId == '' || ajaxLoadingId == null){
		ajaxLoadingId = '';
	}
	
	if(validateForm(formId)){
		
		action = $('#' + formId).attr('action');
		
		submitActionAjaxForm (
				window.location.pathname,
				action,
				'',
				'',
				formId,
				returnId,
				'',
				ajaxLoadingId
			);
		
	}
	
}

function sendForm(formId){
	
	if(validateForm(formId)){
		showLoadingWheel();
		$('#' + formId).submit();
	}
	
}

function updateInputFromTree(nameValue, idValue, nameInputId, hiddenInputId, hideTree, treeId){
	
	$('#'+nameInputId).val(nameValue);
	$('#'+hiddenInputId).val(idValue);
	
	if(hideTree){	
		showTree(treeId, false, '');
	}
	
	$('#'+hiddenInputId).trigger('change');
	
}

function clearSelectionInput(inputName, inputId){
	
	$('#' + inputName).val('');
	$('#' + inputName).trigger('change');
	$('#' + inputId).val('');
	$('#' + inputId).trigger('change');
	
}

function selectLeftElements(leftElement, rightElement){

	$('#' + leftElement + ' option:selected').each(function(){
		
		$('#' + rightElement).append($(this));
		
	});
	
}

function unselectLeftElements(leftElement, rightElement){
	
	$('#' + rightElement + ' option:selected').each(function(){
		
		$('#' + leftElement).append($(this));
		
	});
	
}

/*
 * Filters
 */

function showFilters(buttonObj){
	
	if($('.popup-filters:last').css('display') == 'none'){
		$('.popup-filters:last').show();
		$(buttonObj).css('background-image',"url('/core/css/images/icono_filtro.jpg')");
	}
	else{
		$('.popup-filters:last').hide();
		$(buttonObj).css('background-image',"url('/core/css/images/icono_filtro_plus.jpg')");
	}
	
}

function validateFilter(formId){
	
	errors = '';
	
	var errorsCount = 0;
	
	//Mandatory fields validation
	$('#' + formId + ' .mandatory-input').each(function(){
		
		inputValue = $(this).val();
		
		if(typeof inputVal == 'undefined' || inputVal == '' || inputVal == null){
			
			if($(this).attr('type') == 'hidden'){
				inputId = $(this).attr('id');
				visibleInputId = 'label_' + inputId;
				$('#' + visibleInputId).css('border','1px solid red');
			}
			else{
				$(this).css('border','1px solid red');
			}
			
			errorsCount ++;
			
		}
		else{
			
			if($(this).attr('type') == 'hidden'){
				inputId = $(this).attr('id');
				visibleInputId = 'label_' + inputId;
				$('#' + visibleInputId).css('border','1px solid #a9bdc6');
			}
			else{
				$(this).css('border','1px solid #a9bdc6');
			}
			
		}
		
	});
	
	if(errorsCount > 0){
		
		errors = s_message['complete_mandatory_fields'];
		submitActionAjax (window.location.pathname.substring(0,3),commonActionManagerActions.ERRORMESSAGE,'','','',{errorMessage:errors},'');
		return false;
	
	}
	
	//Input Text
	$('#' + formId + ' .input-text-validate').each(function(){
		
		inputValue = trimString($(this).val());
		
		if(inputValue != ''){
		
			inputTextLength = $(this).attr('maxlength');
			inputValueLength = inputValue.length;
			inputName = $(this).attr('name');
			clearInputName = inputName.replace('filter_','');
			
			if(inputValueLength > inputTextLength){
				errors += s_message[clearInputName] + ': ' + s_message['error_field_max_length'] + '<br />';
			}
		}
		
	});
	
	//Input number
	$('#' + formId + ' .input-number-validate').each(function(){
		
		inputValue = trimString($(this).val());
		
		if(inputValue != ''){
		
			inputTextLength = $(this).attr('maxlength');
			inputValueLength = inputValue.length;
			inputName = $(this).attr('name');
			clearInputName = inputName.replace('filter_','');
			
			if(inputValueLength > inputTextLength){
				errors += s_message[clearInputName] + ': ' + s_message['error_field_max_length'] + '<br />';
			}
			
			if(!$.isNumeric(inputValue)){
				errors += s_message[clearInputName] + ': ' + s_message['error_numeric'] + '<br />';
			}
		
		}
		
	});
	
	processErrors = 0;
	
	//Input natural number
	$('#' + formId + ' .input-naturalNumber-validate').each(function(){
		
		inputValue = trimString($(this).val());
		
		if(inputValue != ''){
		
			inputTextLength = $(this).attr('maxlength');
			inputValueLength = inputValue.length;
			inputName = $(this).attr('name');
			clearInputName = inputName.replace('filter_','');
			
			if(inputValueLength > inputTextLength){
				errors += s_message[clearInputName] + ': ' + s_message['error_field_max_length'] + '<br />';
			}
			
			if(isNaN(inputValue)){
				errors += s_message[clearInputName] + ': ' + s_message['error_numeric'] + '<br />';
			}
			else if( (inputValue % 1) > 0 ){
				errors += s_message[clearInputName] + ': ' + s_message['error_naturalnumber'] + '<br />';
			}
		
		}
		
	});
	
	if(errors != ''){
		
		submitActionAjax (window.location.pathname.substring(0,3),commonActionManagerActions.ERRORMESSAGE,'','','',{errorMessage:errors},'reloading_container_'+formId);
		return false;
		
	}
	else{
		return true;
	}
	
}

function sendFilters(formId){
	
	if(!validateFilter(formId)){
		
		return false;
		
	}
	else{
		
		$('#' + formId + ' input[id="page"]').val('');
		
		$('#' + formId).submit();
		
	}
}

/*
 * Pagers
 */
function paginar(pagina,archivo,div){
	$.ajax({
		url:archivo+"?page="+pagina
		,cache:false
		,type:"GET"
		,beforeSend:function(){
			$('#'+div).html('');
			$('#'+div).append('<img id="loading-msg" alt="Loading..." src="/pfw_files/tpl/popup/ajax-loader-wheel.gif"/>');
		}
		,complete:function(){
			$('#loading-msg').remove();
		}
		,success:function(data){
			$('#'+div).html(data);
		}
		,error:function(){
			alert(s_message['connection_error']);
		}
	});
}

function paginarGal(pagina,seccion,archivo,div){
	$.ajax({
		url:archivo+"?pageGal="+pagina+"&seccion="+seccion
		,cache:false
		,type:"GET"
		,beforeSend:function(){
			$('#'+div).html('');
			$('#'+div).append('<img id="loading-msg" alt="Loading..." src="/pfw_files/tpl/popup/ajax-loader-wheel.gif"/>');
		}
		,complete:function(){
			$('#loading-msg').remove();
		}
		,success:function(data){
			$('#'+div).html(data);
		}
		,error:function(){
			alert(s_message['connection_error']);
		}
	});
}

function navigatePage(numeroPagina){
	
	var formAction = document.getElementById('form_pager').action;
	var windowSearch = window.location.search;
	
	if(typeof(windowSearch) != 'undefined' && windowSearch != '' && (windowSearch.search('page=') == -1 || windowSearch.search('action=') != -1)){
		document.getElementById('form_pager').action = formAction + '&page='+numeroPagina;
	}
	else{
		document.getElementById('form_pager').action = formAction + '?page='+numeroPagina;
	}
	
	document.getElementById('txtPage').value = numeroPagina;
	document.getElementById('form_pager').submit();
}

//Google analytics
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-40474015-1']);
_gaq.push(['_setDomainName', 'pptvivo.com']);
_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();