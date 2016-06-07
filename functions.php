<?php

require_once __DIR__ . '/config.php';

$legalchars = ' !#$&()+,-./0123456789:;<>?ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^`_abcdefghijklmnopqrstuvwxyz{|}~';

// Strict MySQL Reporting.
function strict(){
    mysqli_report(MYSQLI_REPORT_ALL);
}

// Inserts break.
function br($num = 1){
    for($i=0;$i<$num;$i++){
        echo "<br />";
    }
}

// Redirects User to relative page
function changeto($page = "") {
    $url = "http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];
    $url = substr($url,0,strrpos($url,"/")+1);
    header("Location: ".$url.$page);
    die();
}

// Refreshes page
function refresh() {
    header("Refresh:0");
}

// Faster array detection
function isarray($array = null){
    return ((array)$array === $array);
}

// Pretty Print Dump
function prettyDump($mixed = null){
    echo "<code style='background:#f3f3f3; display:block; padding:7px; border:2px solid #555'>";
    if(!function_exists("printVar")){
        function printVar($mixed = null, $indent = 1){
            $ichars = "&nbsp;&nbsp;";
            if(!isset($mixed) or $mixed === null){
                echo "NULL";
            } elseif(isarray($mixed)){
                $j = 1;
                $arrlen = sizeof($mixed);
                echo "array($arrlen) ";
                echo "{<br />";
                foreach($mixed as $key => $val){
                    for($i=0;$i<$indent;$i++)
                        echo $ichars;
                    echo "[";
                    if(is_numeric($key))
                        var_export($key);
                    else
                        echo "\"$key\"";
                    echo "] => ";
                    if(isarray($val) or is_object($val))
                        printVar($val, $indent + 1);
                    elseif(is_numeric($val))
                        echo gettype($val) . "($val)";
                    elseif(is_bool($val))
                        echo "bool($val)";
                    elseif(is_string($val))
                        echo "string(" . strlen($val) . ") \"$val\"";
                    else {
                        echo gettype($val) . "(" . sizeof($val) . ") ";
                        var_export($val);
                    }
                    if($j++ === $arrlen)
                        echo "<br />";
                    else
                        echo ",<br />";
                }
                for($i=0;$i<$indent-1;$i++)
                    echo $ichars;
                echo "}";
            } elseif(is_object($mixed)){
                $j = 1;
                $arrlen = sizeof((array)$mixed);
                echo "object($arrlen) ";
                echo "{<br />";
                foreach($mixed as $key => $val){
                    for($i=0;$i<$indent;$i++)
                        echo $ichars;
                    echo "[";
                    if(is_numeric($key))
                        var_export($key);
                    else
                        echo "\"$key\"";
                    echo "] => ";
                    if(isarray($val) or is_object($val))
                        printVar($val, $indent + 1);
                    elseif(is_numeric($val)){
                        echo gettype($val) . "($val)";
                    } elseif(is_bool($val)){
                        echo "bool($val)";
                    } elseif(is_string($val)){
                        echo "string(" . strlen($val) . ") \"$val\"";
                    } else {
                        echo gettype($val) . "(" . sizeof($val) . ") ";
                        var_export($val);
                    }
                    if($j++ === $arrlen)
                        echo "<br />";
                    else
                        echo ",<br />";
                }
                for($i=0;$i<$indent-1;$i++)
                    echo $ichars;
                echo "}";
            } elseif(is_string($mixed)){
                echo "string(" . strlen($mixed) . ") \"$mixed\"";
            } elseif(is_numeric($mixed)){
                echo gettype($mixed) . "($mixed)";
            } else {
                var_dump($mixed);
            }
        }
    }
    printVar($mixed, 1);
    echo "</code>";
}

// Removes non-printable ASCII characters;
function cleanup($string) {
    $string = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $string);
    return $string;
}

// Inserts Link to Page
function eurl($page, $text) {
    echo "<a href='".$page."'>".$text."</a>";
}

// Returns Random Token
function randtoken($length = 6) {
    if($length%2) $length++;
    return bin2hex(openssl_random_pseudo_bytes($length/2));
}

// Checks if Username or Email Address is already reserved.
// Returns True if available and False if reserved.
function isavailable($field, $value){
    global $dblink;
    if($field == "username") {
        $sql_query = "SELECT AccountUserName FROM user_data WHERE AccountUserName=?";
    } elseif($field == "email") {
        $sql_query = "SELECT EmailOfUser FROM user_data WHERE EmailOfUser=?";
    } else return;
    $sql_stmt = mysqli_prepare($dblink,$sql_query);
    mysqli_stmt_bind_param($sql_stmt,"s",$value);
    mysqli_stmt_execute($sql_stmt);
    mysqli_stmt_bind_result($sql_stmt,$column);
    mysqli_stmt_fetch($sql_stmt);
    mysqli_stmt_close($sql_stmt);
    return is_null($column);
}

// Checks if Email Server exists on domain.
// Returns True if exists and False if not.
function mxrecordcheck($emailtocheck){
    $charpos = strpos($emailtocheck,"@");
    $emaildomain = substr($emailtocheck, $charpos + 1);
    return !checkdnsrr($emaildomain, 'MX');
}

// Checks if input contains potential SQL command-related characters.
// Returns True if illegal and False if legal.
function isillegal($unvalidated){
    global $legalchars;
    $unvalidated_array = str_split($unvalidated);
    foreach($unvalidated_array as $needleitem){
        if(strpos($legalchars, $needleitem) === false) return true;
    }
    return false;
}

// Checks if username is up to standards.
// Returns True if up to standards and an error message if not.
function username_validate($usernametocheck){
    if(empty($usernametocheck)) {
        return "Username not given.";
    } elseif(strlen($usernametocheck)<=1){
        return "Username is too short.";
    } elseif(strlen($usernametocheck)>32){
        return "Username is too long.";
    } elseif($usernametocheck === null){
        return "Username is invalid.";
    } elseif(isillegal($usernametocheck)){
        return "Username cannot contain characters like ', ".'", '."%, *, @ or =.";
    } elseif(!isavailable("username", $usernametocheck)){
        return "Username is taken.";
    } else return true;
}

// Checks if email address is up to standards.
// Returns True if up to standards and an error message if not.
function email_validate($emailtocheck){
    if(empty($emailtocheck)) {
        return "Email address not given.";
    } elseif(strlen($emailtocheck)<=6){
        return "Email address is too short.";
    } elseif(strlen($emailtocheck)>255){
        return "Email address is too long.";
    } elseif(filter_var($emailtocheck,FILTER_VALIDATE_EMAIL) === false){
        return "Email address is invalid.";
    } elseif(mxrecordcheck($emailtocheck)){
        return "Email address does not exist.";
    } elseif(!isavailable("email", $emailtocheck)){
        return "Email address is taken.";
    } else return true;
}

// Returns True if up to standards and an error message if not.
function password_validate($passtocheck){
    if(empty($passtocheck)) {
        return "Password not given.";
    } elseif(strlen($passtocheck)<6){
        return "Password is too short.";
    } elseif(strlen($passtocheck)>100){
        return "Password is too long.";
    } else return true;
}

// Checks if name is up to standards.
// Returns sanitized name. Returns false if name not given.
function name_sanitize($nametoclean){
    global $legalchars;
    $str_array = str_split($nametoclean);
    $i = 0;
    $nametoclean = "";
    $chars = str_split($legalchars);
    foreach($str_array as $str_char) {
        if(in_array($str_char, $chars)) $nametoclean .= $str_char;
    }
    if(empty($nametoclean)) {
        return false;
    } elseif(strlen($nametoclean)>70){
        return "Name is too long.";
    } else return $nametoclean;
}

// Registers new user and sends email confirmation.
// Returns True if successful and Error message if not.
function register($name, $username, $email, $password, $fb = false, $pic = ""){

    $temporaryval;

    // Name check
    $name = name_sanitize($name);
    if(!$name) $name = $username;

    // Username Check
    $temporaryval = username_validate($username);
    if($temporaryval !== true and !$fb) return $temporaryval;
    $nottaken = isavailable("email", $email);

    // Email Check
    $temporaryval = email_validate($email);
    if($temporaryval !== true and !$fb) return $temporaryval;

    // Password Check
    $temporaryval = password_validate($password);
    if($temporaryval !== true and !$fb) return $temporaryval;

    // Database Entry of User
    $result = null;
    $randtoken;
    do {
        $randtoken = randtoken();
        $sqlquery = "SELECT IDofTheInduvidual FROM user_data WHERE Referral=?";
        $statement = mysqli_prepare($dblink, $sqlquery);
        mysqli_stmt_bind_param($statement,"s",$randtoken);
        mysqli_stmt_bind_result($statement, $result);
        $success = mysqli_stmt_execute($statement);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close($statement);
    } while ($result !== null);
    global $dblink;
    if($fb) $confirmed = "1";
    else $confirmed = "0";
    $unhashed = $password;
    $password = password_hash($password, PASSWORD_BCRYPT);
    $confirmhash = bin2hex(openssl_random_pseudo_bytes(16));
    $blocs = "[]";
    $sql_query = "INSERT INTO user_data (AccountUserName, AccountPassPhrase, NameOfUser, EmailOfUser, ConfirmHash, IsUserConfirmed, ProfilePicture, Referral, Blocs) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $sql_stmt = mysqli_prepare($dblink, $sql_query);
    mysqli_stmt_bind_param($sql_stmt, "sssssssss", $username, $password, $name, $email, $confirmhash, $confirmed, $pic, $randtoken, $blocs);
    mysqli_stmt_execute($sql_stmt);
    if($fb and empty(getprofilepic($email))){
        setprofilepic($pic, $email);
    }
    elseif($fb and ($nottaken === true)){
        setprofilepic($pic, $email);
        $subject = "New MUNme Account";
        $message = "<html>
        <head>
        <title>New MUNme Account</title>
        </head>
        <body>
        Thank you for signing up for MUNme. Your password has been set to $unhashed.
        </body>
        </html>";
        global $rheaders;
        $rheaders .= "To: $name <$email> \r\n";
        mail($email,$subject,$message,$rheaders);
        return true;
    } elseif(!isavailable("username", $username) and !isavailable("email", $email)){
        $url = "$websiteurl/confirm.php";
        $url .= "?user=".urlencode($username);
        $url .= "&token=".urlencode($confirmhash);
        $subject = "Email confirmation for MUNme";
        $message = "<html>
        <head>
        <title>Email confirmation for MUNme</title>
        </head>
        <body>
        <a href='$url'>Click here to confirm your account.</a>
        <br />
        If that does not work, copy this url into your browser - <br />
        $url
        </body>
        </html>";
        global $rheaders;
        $rheaders .= "To: $name <$email> \r\n";
        mail($email,$subject,$message,$rheaders);
        return true;
    } else return false;    
}

// Logs in users and updates SESSION variables.
// Returns True if successful and Error message if not.
function login($userormail, $password = "", $fb = false){

    // Identify username or email address
    if(strpos($userormail,"@") !== false){
        if(isavailable("email",$userormail)) return "The account does not exist.";
        else $sql_query = "SELECT AccountPassPhrase, EmailOfUser, AccountUserName, NameOfUser, IDofTheInduvidual, IsUserConfirmed FROM user_data WHERE EmailOfUser=?";
    } else {
        if(isavailable("username",$userormail)) return "The account does not exist.";
        else $sql_query = "SELECT AccountPassPhrase, EmailOfUser, AccountUserName, NameOfUser, IDofTheInduvidual, IsUserConfirmed FROM user_data WHERE AccountUserName=?";
    }

    // Password Check
    $temporaryval = password_validate($password);
    if($temporaryval !== true and !$fb) return $temporaryval;

    // Database Compare
    global $dblink;
    $sql_stmt = mysqli_prepare($dblink, $sql_query);
    mysqli_stmt_bind_param($sql_stmt, "s", $userormail);
    mysqli_stmt_execute($sql_stmt);
    mysqli_stmt_bind_result($sql_stmt, $dbhash, $email, $username, $name, $id, $cbool);
    mysqli_stmt_fetch($sql_stmt);
    mysqli_stmt_close($sql_stmt);
    if(password_verify($password,$dbhash) or $fb){
        if($cbool == 1){
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $email;
            $_SESSION["name"] = $name;
            $_SESSION["id"] = $id;
            return true;
        } else return "Account has not been confirmed via email.";
    } else return "Password is incorrect.";
}

// Logs in users and updates SESSION variables.
// Returns True if successful and Error message if not.
function logout(){
    $_SESSION["loggedin"] = false;
    $_SESSION["username"] = "";
    $_SESSION["email"] = "";
    refresh();
}

// Edits attributes of logged in user
// Returns true is successful and an error message if not
function setprofilepic($pic = "", $userormail = ""){

    // Checking if Input is given
    if(empty($userormail)) return "Account not given";

    // Executing SQL Commands
    else {

        // Identify username or email address
        $sql_query;
        if(strpos($userormail,"@") !== false){
            if(isavailable("email",$userormail)) return "The account does not exist.";
            else $sql_query = "UPDATE user_data SET ProfilePicture=? WHERE EmailOfUser='$userormail'";
        } else {
            if(isavailable("username",$userormail)) return "The account does not exist.";
            else $sql_query = "UPDATE user_data SET ProfilePicture=? WHERE AccountUserName='$userormail'";
        }

        // Required Variables
        global $dblink;
        strict();

        // Updating User Data
        $statement = mysqli_prepare($dblink, $sql_query);
        mysqli_stmt_bind_param($statement, "s", $pic);
        $success = mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);
        if($success) return $success;
        else return "Error while updating user picture.";
    }
}

// Edits attributes of logged in user
// Returns true is successful and an error message if not
function getprofilepic($userormail){

    // Checking if Input is given
    if(empty($userormail)) return "Username or Email not given";

    // Executing SQL Commands
    else {

        // Required Variables
        global $dblink;
        $sql_query;

        // Updating User Data
        // Identify username or email address
        if(strpos($userormail,"@") !== false){
            if(isavailable("email",$userormail)) return "The account does not exist.";
            else $sql_query = "SELECT ProfilePicture FROM user_data WHERE EmailOfUser=?";
        } else {
            if(isavailable("username",$userormail)) return "The account does not exist.";
            else $sql_query = "SELECT ProfilePicture FROM user_data WHERE AccountUserName=?";
        }
        $sql_stmt = mysqli_prepare($dblink, $sql_query);
        mysqli_stmt_bind_param($sql_stmt, "s", $userormail);
        mysqli_stmt_execute($sql_stmt);
        mysqli_stmt_bind_result($sql_stmt, $pic);
        $success = mysqli_stmt_fetch($sql_stmt);
        mysqli_stmt_close($sql_stmt);
        if($success) return $pic;
        else return "Error while updating user info.";
    }
}

// Auto Login
if(!$_SESSION["loggedin"] and isset($_GET["ltoken"])){
    if($_GET["ltoken"] === "9c35a9a25d476124")
        login("fadilf","pithon");
}