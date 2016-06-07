<?php

// Header File
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/vendor/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.5',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['public_profile'];
$permissions = ['email'];
$loginUrl = $helper->getLoginUrl("$websiteurl/fb-callback.php", $permissions);


// If User is not logged in
if(!$_SESSION["loggedin"]): ?>

<?php // Login Credentials Validation
$user = "";
$pass = "";
if(isset($_POST["s"])){
    $loginresult = login($_POST["user"],$_POST["pass"]);
    if($loginresult === true) changeto("");
    else {
        echo $loginresult;
        $user = $_POST["user"];
        $pass = $_POST["pass"];
    }
}
?>

<a href="index.php">Back</a>
<br />
<p>Log In</p>
<form method="post" action="">
    Username/Email:
    <br />
    <input type="text" value="<?=$user?>" name="user" autofocus />
    <br />
    <br />
    Password:
    <br />
    <input type="password" value="<?=$pass?>" name="pass" />
    <br />
    <br />
    <input type="submit" value="Log In" />
    <input type="hidden" name="s" />
    <br />
    <br />
    <a href="<?=htmlspecialchars($loginUrl)?>">Log in with Facebook</a>
</form>

<?php else: ?>
<?php changeto(""); ?>
<?php
endif;


// Footer File
include "footer.php"; ?>