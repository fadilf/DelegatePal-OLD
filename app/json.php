<?php 

include "app-functions.php";
if(loggedin()) if(!isset($_GET["noteid"])) arrayjson();
else {
    if(!isset($_GET["bloc"])) $bloc = false;
    else {
        $bloc = $_GET["bloc"];
        if($bloc === "true") $bloc = true;
        elseif($bloc === "false") $bloc = false;
    }
    notejson($_GET["noteid"], $bloc);
}