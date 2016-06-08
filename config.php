<?php

// SQL DB Configuration
//mysqli_report(MYSQLI_REPORT_OFF);
$dbinfo = [
    "servername" => "xxxxxxxxxxx",    
    "dbusername" => "xxxxxxxxxxx", 
    "dbpassword" => "xxxxxxxxxxx", 
    "dbname" => "xxxxxxxxxxx"
];
$dblink = mysqli_connect($dbinfo["servername"],$dbinfo["dbusername"],$dbinfo["dbpassword"],$dbinfo["dbname"]);

// Session Variables
if(session_id() == '' || !isset($_SESSION)) session_start();
if(!isset($_SESSION["loggedin"])) $_SESSION["loggedin"] = false;
if(!isset($_SESSION["amodal"])) $_SESSION["amodal"] = false;
if(!isset($_SESSION["username"]) or !isset($_SESSION["email"]) or !isset($_SESSION["name"])){
    $_SESSION["username"] = "";
    $_SESSION["email"] = "";
    $_SESSION["name"] = "";
    $_SESSION["id"] = "";
}

// Mail Headers
$rheaders = 'MIME-Version: 1.0' . "\r\n";
$rheaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$rheaders .= 'From: DelegatePal <hello@delegatepal.com>' . "\r\n";
$rheaders .= 'Reply-To: DelegatePal <hello@delegatepal.com>' . "\r\n";
$websiteurl = "http://localhost/MUNme";
$app_id = 'xxxxxxxxxxxxxxxx';
$app_secret = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';

/* Online Version */
//$websiteurl = "https://www.delegatepal.com";
//$app_id = 'xxxxxxxxxxxxxxxx';
//$app_secret = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Output buffer to enable mid-page redirects
//ob_start();