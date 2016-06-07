<?php
// Configuration and DB Functions
require_once __DIR__ . '/header.php';
if($_SESSION["amodal"]) {
    $_SESSION["amodal"] = false;
    echo "Registration successful! Check your email for a confirmation link to activate your account.";
    br();
    br();
}
?>
<?php // If user is not logged in
if(!$_SESSION["loggedin"] and !isset($_POST["cntxt"])): ?>
<a href="signup.php">Sign Up</a>
<br />
<a href="login.php">Login</a>



<?php elseif(!isset($_POST["cntxt"]) and $_SESSION["loggedin"]): ?>
<a href="app/">Go to app</a>
<br />
<br />
<form action="" method="post">
    <input type="hidden" name="cntxt" value="logout" />
    <input type="submit" value="Logout" />
</form>


<?php // If user wants to logout
elseif(isset($_POST["cntxt"]) and $_POST["cntxt"] === "logout"): ?>
<?php 
logout();
changeto("");
?>


<?php elseif($_SESSION["loggedin"]): ?>
<a href="app/index.php">Go to app</a>
<br />
<br />
<form action="" method="post">
    <input type="hidden" name="cntxt" value="logout" />
    <input type="submit" value="Logout" />
</form>


<?php else: ?>
ERROR?
<?php endif;
include "footer.php";
?>