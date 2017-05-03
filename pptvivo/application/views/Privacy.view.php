<?php
class Privacy extends Render{
	
	static public function render () {
		
		ob_start();
		?>
			<!DOCTYPE html>
			<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
			<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
			<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
			<head>
			
				<title><?=$_SESSION['s_parameters']['site_title']?> | Features</title>	
				<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
				<link rel="stylesheet" type="text/css" href="/core/css/bootstrap.min.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/bootstrap-responsive.min.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/normalize.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/main.css" />
				<link rel="stylesheet" type="text/css" href="/core/css/popup.css" />
<!--				<link rel="stylesheet" type="text/css" href="/core/css/generalextra.css" />-->
				<link  type="image/x-icon" rel="shortcut icon" href="/core/img/favicon.ico"/>
				
				<script type="text/javascript" src="/core/js/jquery-1.7.min.js"></script>
<!--				<script type="text/javascript" src="/core/js/modernizr-2.6.2.min.js"></script>-->
				<script type="text/javascript" src="/core/js/resources-<?= $_SESSION['s_languageIso'] ?>.js"></script>
			</head>
			<body>
			<!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        	<![endif]-->

			    <?
				echo Header::render();
			?>
				   
				    <div id="content" class="clearfix">
			           <div class="section-content clearfix">
			               <div class="wrapper">
			               		<h2>Privacy Policy</h2>

								<!-- START PRIVACY POLICY CODE -->
								<div style="font-family: arial;"><strong>What information
								do we collect?</strong> <br />
								<br />
								We collect information from you when you register on our site, place an
								order, subscribe to our newsletter, respond to a survey or fill out a
								form. <br />
								<br />
								When ordering or registering on our site, as appropriate, you may be
								asked to enter your: name, e-mail address or credit card information.
								You may, however, visit our site anonymously.<br />
								<br />
								Google, as a third party vendor, uses cookies to serve ads on your site.
								Google's use of the DART cookie enables it to serve ads to your users
								based on their visit to your sites and other sites on the Internet.
								Users may opt out of the use of the DART cookie by visiting the Google
								ad and content network privacy policy..<br />
								<br />
								<strong>What do we use your information for?</strong> <br />
								<br />
								Any of the information we collect from you may be used in one of the
								following ways: <br />
								<br />
								<ul>
								<li>To personalize your experience<br />
								(your information helps us to better respond to your individual needs)<br />
								</li>
								<li>To improve our website<br />
								(we continually strive to improve our website offerings based on the
								information and feedback we receive from you)
								</li>
								<li>To improve customer service<br />
								(your information helps us to more effectively respond to your customer
								service requests and support needs)
								</li>								
								<li>To process transactions
								<br />
								<blockquote>Your information, whether public or private,
								will not be sold, exchanged, transferred, or given to any other company
								for any reason whatsoever, without your consent, other than for the
								express purpose of delivering the purchased product or service
								requested.</blockquote>
								</li>
								<li>To send periodic emails</li>
								</ul>
								<br />
								The email address you provide may be used to send you information,
								respond to inquiries, and/or other requests or questions.<br />
								<br />
								<strong>How do we protect your information?</strong> <br />
								<br />
								We implement a variety of security measures to maintain the safety of
								your personal information when you place an order or enter, submit, or
								access your personal information. <br />
								<br />
								We offer the use of a secure server. All supplied sensitive/credit
								information is transmitted via Secure Socket Layer (SSL) technology and
								then encrypted into our Payment gateway providers database only to be
								accessible by those authorized with special access rights to such
								systems, and are required to?keep the information confidential.<br />
								<br />
								After a transaction, your private information (credit cards, social
								security numbers, financials, etc.) will not be stored on our servers.<br />
								<br />
								<strong>Do we use cookies?</strong> <br />
								<br />
								Yes (Cookies are small files that a site or its service provider
								transfers to your computers hard drive through your Web browser (if you
								allow) that enables the sites or service providers systems to recognize
								your browser and capture and remember certain information<br />
								<br />
								We use cookies to help us remember and process the items in your
								shopping cart, understand and save your preferences for future visits
								and compile aggregate data about site traffic and site interaction so
								that we can offer better site experiences and tools in the future. We
								may contract with third-party service providers to assist us in better
								understanding our site visitors. These service providers are not
								permitted to use the information collected on our behalf except to help
								us conduct and improve our business.<br />
								<br />
								If you prefer, you can choose to have your computer warn you each time a
								cookie is being sent, or you can choose to turn off all cookies via your
								browser settings. Like most websites, if you turn your cookies off, some
								of our services may not function properly. However, you can still place
								orders by contacting customer service.<br />
								<br />
								<strong>Do we disclose any information to outside parties?</strong> <br />
								<br />
								We do not sell, trade, or otherwise transfer to outside parties your
								personally identifiable information. This does not include trusted third
								parties who assist us in operating our website, conducting our business,
								or servicing you, so long as those parties agree to keep this
								information confidential. We may also release your information when we
								believe release is appropriate to comply with the law, enforce our site
								policies, or protect ours or others rights, property, or safety.
								However, non-personally identifiable visitor information may be provided
								to other parties for marketing, advertising, or other uses.<br />
								<br />
								<strong>Third party links</strong> <br />
								<br />
								Occasionally, at our discretion, we may include or offer third party
								products or services on our website. These third party sites have
								separate and independent privacy policies. We therefore have no
								responsibility or liability for the content and activities of these
								linked sites. Nonetheless, we seek to protect the integrity of our site
								and welcome any feedback about these sites.<br />
								<br />
								<strong>California Online Privacy Protection Act Compliance</strong><br />
								<br />
								Because we value your privacy we have taken the necessary precautions to
								be in compliance with the California Online Privacy Protection Act. We
								therefore will not distribute your personal information to outside
								parties without your consent.<br />
								<br />
								As part of the California Online Privacy Protection Act, all users of
								our site may make any changes to their information at anytime by logging
								into their control panel and going to the 'User Profile' page.<br />
								<br />
								<strong>Childrens Online Privacy Protection Act Compliance</strong> <br />
								<br />
								We are in compliance with the requirements of COPPA (Childrens Online
								Privacy Protection Act), we do not collect any information from anyone
								under 13 years of age. Our website, products and services are all
								directed to people who are at least 13 years old or older.<br />
								<br />
								<strong>Online Privacy Policy Only</strong> <br />
								<br />
								This online privacy policy applies only to information collected through
								our website and not to information collected offline.<br />
								<br />
								<strong>Terms and Conditions</strong> <br />
								<br />
								Please also visit our Terms and Conditions section establishing the use,
								disclaimers, and limitations of liability governing the use of our
								website at <a href="http://www.pptvivo.com/tos">http://www.pptvivo.com/tos</a><br />
								<br />
								<strong>Your Consent</strong> <br />
								<br />
								By using our site, you consent to our <a
									style="text-decoration: none; color: #3c3c3c;"
									href="http://www.freeprivacypolicy.com/" target="_blank">privacy
								policy</a>.<br />
								<br />
								<strong>Changes to our Privacy Policy</strong> <br />
								<br />
								If we decide to change our privacy policy, we will post those changes on
								this page. <br />
								<br />
								This policy was last modified on March 1st, 2013<br />
								<br />
								<strong>Contacting Us</strong> <br />
								<br />
								If there are any questions regarding this privacy policy you may contact
								us using the information below. <br />
								<br />
								http://www.pptvivo.com<br />
								Av. Colón 412 piso 8 Depto B<br />
								Mendoza, Mendoza 5500<br />
								Argentina<br />
								info@pptvivo.com<br />
								542614201434<br />
								<br />
								This policy is powered by Trust Guard <a
									style="color: #000; text-decoration: none;"
									href="http://www.trust-guard.com/PCI-Compliance-s/65.htm"
									target="_blank">PCI compliance</a>.</div>
								<!-- END PRIVACY POLICY CODE -->
		                   </div>
		               </div>
		               <div class="bottom">
		               </div>
		           </div>
				   
				   
	<?
		echo FooterView::render();
	?>

	
				
				<!-- Scripts Zone -->
				<script type="text/javascript" src="/core/js/main.js"></script>
				<script type="text/javascript" src="/core/js/plugins.js"></script>
				<script type="text/javascript" src="/core/js/actionResponse.js"></script>
				<script type="text/javascript" src="/core/js/allPopup.js"></script>
				<script type="text/javascript" src="/core/js/util.js"></script>
				<script type="text/javascript" src="/core/js/scripts.js"></script>
				<script type="text/javascript" src="/core/js/login.js"></script>
				<script type="text/javascript" src="/core/js/EnumsJS.js"></script>
			</body>
			</html>
		<?
		return ob_get_clean();
	}
}
