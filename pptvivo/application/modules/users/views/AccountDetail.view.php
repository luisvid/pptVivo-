<?php

class AccountDetail extends Render{
	
	public function render($fields){
		
		$userData = $_SESSION['loggedUser'];
		
		if(is_object($userData)){
	        
            $userId = $userData->getId();
            $userName = $userData->getUsername();
            $userSurname = $userData->getUsersurname();
            $userEmail = $userData->getUseremail();
            $userLogin = $userData->getUserlogin();
            $userTypeId = $userData->getUsertypeid();
	        
	    }
		
		ob_start();
		?>
		<div class="account-form">
		
			<?php
			if(isset($_REQUEST['errorMessage']) && $_REQUEST['errorMessage'] != null){
				$_REQUEST['errorMessage'] = base64_decode($_REQUEST['errorMessage']);
				?>
				<div class="alert alert-error">
				<?=$_REQUEST['errorMessage']?>
				</div>
				<?php
			}
			elseif (isset($_REQUEST['successMessage']) && $_REQUEST['successMessage'] != null) {
				$_REQUEST['successMessage'] = base64_decode($_REQUEST['successMessage']);
				?>
				<div class="alert alert-success">
				<?=$_REQUEST['successMessage']?>
				</div>
				<?php
			} 
			?>	
                       
			<div class="form two-col-form ">
			
				<form method="post" action="/<?=$_SESSION['s_languageIsoUrl']?>/users?action=updateAccountDetail" id="updateAccountForm">
				
					<input type="hidden" name="userId" value="<?=$userId?>" />
					<input type="hidden" name="control_userTypeId" id="control_userTypeId" value="<?=$userTypeId?>" />
				
					<?php
	            	$fields ['name']->setSelectedValue($userName);
	            	echo $fields ['name']->drawHtml("pull-left");
	            	
	            	$fields ['surname']->setSelectedValue($userSurname);
	            	echo $fields ['surname']->drawHtml("pull-left");
	            	
	            	$fields ['login']->setSelectedValue($userLogin);
	            	echo $fields ['login']->drawHtml("pull-left");
	            	
	            	$fields ['email']->setSelectedValue($userEmail);
	            	echo $fields ['email']->drawHtml("pull-left");
	            	
//	            	$fields ['usertype']->setSelectedValue($userTypeId);
//	            	echo $fields ['usertype']->drawHtml();
	            	
	            	echo $fields ['password']->drawHtml();
	            	?>

					<div class="form-row right">
						<input type="button" class="submit" name="updateAccountButton" value="SAVE CHANGES" onclick="validateUpdateForm('updateAccountForm');" />
					</div>
				
				</form>
			
			</div>
                       
		</div>            
		<?php
		
		$_REQUEST['jsToLoad'][] = "/modules/users/js/users.js";
		
		return ob_get_clean();
	}

}