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

<?php // Sign Up Validation and Submission
$name = "";
$user = "";
$email = "";
$pass = "";
if(isset($_POST["s"])){
    $loginresult = register($_POST["name"], $_POST["user"], $_POST["email"], $_POST["pass"]);
    if($loginresult === true){
        $_SESSION["amodal"] = true;
        changeto("");
    } else {
        echo $loginresult;
        $name = $_POST["name"];
        $user = $_POST["user"];
        $email = $_POST["email"];
        $pass = $_POST["pass"];
    }
}
?>
<a href="index.php">Back</a>
<br />
<p>Sign Up</p>
<form method="post" action="">
    Name:
    <br />
    <input type="text" value="<?=$name?>" name="name" autofocus />
    <br />
    <br />
    Username*:   
    <br />
    <input type="text" value="<?=$user?>" name="user" />
    <br />
    <br />
    Email*:
    <br />
    <input type="email" value="<?=$email?>" name="email" />
    <br />
    <br />
    Password*:
    <br />
    <input type="password" value="<?=$pass?>" name="pass" />
    <br />
    <br />
    <input type="submit" value="Sign Up" />
    <input type="hidden" name="s" />
</form>
<br />
*Marked fields are required
<br />
<br />
<a href="<?=htmlspecialchars($loginUrl)?>">Log in with Facebook</a>

<?php else: ?>
<?php changeto(""); ?>
<?php
endif;


// Footer File
include "footer.php"; ?>