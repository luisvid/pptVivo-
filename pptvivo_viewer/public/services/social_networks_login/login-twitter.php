<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Configurator.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Util.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/CommonFunctions.php';

require_once 'twitter/twitteroauth.php';
require_once 'config/twconfig.php';

session_start ();

$twitteroauth = new TwitterOAuth ( YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET );

// Requesting authentication tokens, the parameter is the URL we will be redirected to
$request_token = $twitteroauth->getRequestToken ( getCurrenProtocol() . '/services/social_networks_login/getTwitterData.php?returnUrl=' . $_GET['returnUrl'] );


// Saving them into the session
$_SESSION ['oauth_token'] = $request_token ['oauth_token'];
$_SESSION ['oauth_token_secret'] = $request_token ['oauth_token_secret'];

// If everything goes well..
if ($twitteroauth->http_code == 200) {
	// Let's generate the URL and redirect
	$url = $twitteroauth->getAuthorizeURL ( $request_token ['oauth_token'] );
	header ( 'Location: ' . $url );
}
else {
	throw new Exception(Util::getLiteral('twitter_url_error'));
}
