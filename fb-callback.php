<?php
//error_reporting(E_ALL); ini_set('display_errors', 'On');
if(session_id() == '' || !isset($_SESSION)) session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
$fb = new Facebook\Facebook([
    'app_id' => $app_id,
    'app_secret' => $app_secret,
    'default_graph_version' => 'v2.5',
]);
$helper = $fb->getRedirectLoginHelper();
try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
} catch(Exception $e) {
    echo "ERROR";//'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo "ERROR";//'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
if (! isset($accessToken)) {
    if ($helper->getError()) {
        echo $helper->getErrorDescription() . "<br /><br />";
        include "index.php";
        $error = true;
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'ERROR';
    }
    exit;
}
// Logged in
$oAuth2Client = $fb->getOAuth2Client();
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
$tokenMetadata->validateAppId($app_id);
if (! $accessToken->isLongLived()) {
    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
        exit;
    }
    echo '<h3>Long-lived</h3>';
    var_dump($accessToken->getValue());
}
$_SESSION['fb_access_token'] = (string) $accessToken;
$fb->setDefaultAccessToken($_SESSION['fb_access_token']);


if(empty($error)) {
//    echo "<br /><br /><br />";
    include "functions.php";
    
    $response = $fb->get('/me?fields=name,email,id');
    $userNode = $response->getGraphUser();
    $name = $userNode['name'];
    $email = $userNode['email'];
    $userid = $userNode['id'];
    $pic = "data:image/jpeg;base64,";
    $pic .= base64_encode(file_get_contents("https://graph.facebook.com/".$userid."/picture?type=large"));
    $hash = bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_URANDOM));
    $success = register($name, $email, $email, $hash, true, $pic);
    $success = login($email, "", true);
    if($success === true) changeto("app/");
    else echo $success;
}