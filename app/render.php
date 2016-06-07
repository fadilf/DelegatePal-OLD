<?php

include 'app-functions.php';

$uriinput = explode("?",$_SERVER["REQUEST_URI"]);
$uriinput = array_slice($uriinput, 1);
$params = [];
$verified;
if(count($uriinput) > 0) {
    $uriinput = explode("*",$uriinput[0]);
    foreach($uriinput as $val){
        $temp = explode("=",$val);
        $params[$temp[0]] = $temp[1];
    }
    if(count($params) > 1) {
        $verified = checkuserhash($params["hash"],$params["userid"]);
        header("Access-Control-Allow-Origin: *");
    }
}
if(empty($_GET["id"]) and empty($verified))
    echo "Note ID not given.";
else {
    if(loggedin() or (!empty($verified) and $verified)) {
        if(empty($verified)) {
            $id = $_GET["id"];
        } else {
            $id = intval($params["id"]);
            $bloc = $params["bloc"];
        }
        if(!empty($_GET["bloc"])){
            $bloc = false;
            if($_GET["bloc"] === "true")
                $bloc = true;
            elseif($_GET["bloc"] === "false")
                $bloc = false;
            $notearr = notearr($id, true, $bloc);
        } elseif(!empty($bloc)){
            if($bloc === "true")
                $bloc = true;
            elseif($bloc === "false")
                $bloc = false;
            $notearr = notearr($id, true, $bloc);
        } else
            $notearr = notearr($id, true);

        if($notearr["folder"]===null)
            echo "Note id is invalid";
        elseif(!empty($_GET["zip"]) and $_GET["zip"] == true){
            $data = $notearr["data"];
            $type = $notearr["type"];
            if($type === "text") {
                echo strip_tags($data);
            } elseif($type === "url") {
                $prefix = "http://";
                $pr1 = "HTTP://";
                $pr2 = "HTTPS://";
                $comp = strtoupper($data);
                if(strpos($comp,$pr1)===0 or strpos($comp,$pr2)===0) $prefix = "";
                $data = $prefix . $data;
                echo file_get_contents($data);
            } else {
                $strpos = strpos($data,";base64,");
                $substr = substr($data,$strpos+8);
                echo base64_decode($substr);
            }
        } else {
            $data = $notearr["data"];
            $type = $notearr["type"];
            if($type === "text") {
                header("Content-type: text/html");
                echo $data;
            } elseif($type === "url") {
                header("Content-type: text/html");
                $prefix = "http://";
                $pr1 = "HTTP://";
                $pr2 = "HTTPS://";

                $comp = strtoupper($data);
                if(strpos($comp,$pr1)===0 or strpos($comp,$pr2)===0) $prefix = "";
                $data = $prefix . $data;
                echo file_get_contents($data);
            } elseif($type === "word") {
                $arr = separateprefix($data);
                header("Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
                echo base64_decode($arr["data"]);
            } else {
                $arr = separateprefix($data);
                header("Content-type: ".$arr["mime"]);
                echo base64_decode($arr["data"]);
            }
        }
    } else echo "ERROR";
}
?>