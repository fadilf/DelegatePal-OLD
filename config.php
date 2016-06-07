<?php

// SQL DB Configuration
//mysqli_report(MYSQLI_REPORT_OFF);
$dbinfo = [
    "servername" => "localhost",    
    "dbusername" => "file_browser", 
    "dbpassword" => "My7vCRxSbqhxBAGA", 
    "dbname" => "the_x_files"
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
$rheaders .= 'From: MUNme <no-reply@munme.com>' . "\r\n";
$rheaders .= 'Reply-To: MUNme <feedback@munme.com>' . "\r\n";
$websiteurl = "http://localhost/MUNme";
$app_id = '1157018394309884';
$app_secret = '11364cb3637b3a8fa4f861f3df964545';

/* Online Version */
//$websiteurl = "https://www.delegatepal.com";
//$app_id = '1156792647665792';
//$app_secret = '76a410d48e7666793556e99866f480c2';

// Output buffer to enable mid-page redirects
//ob_start();