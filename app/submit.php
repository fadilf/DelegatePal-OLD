<?php

include "app-functions.php";
if(!empty($_FILES) and empty($_POST["profilepic"])){
    $filename = $_FILES["file"]["name"];
    $filetype = $_FILES["file"]["type"];
    $isimg = strpos($filetype, "image/") === 0;
    $isword = $filetype === "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
    $ispdf = $filetype === "application/pdf";
    if(!$isimg and !$ispdf and !$isword){
        http_response_code(500);
        header("Content-Type: text/plain");
        exit("Error while uploading.");
    } else {
        if($isimg) $type = "image";
        elseif($ispdf) $type = "pdf";
        elseif($isword) $type = "word";

        $dataURI = "data:" . $filetype . ";base64," . base64_encode(file_get_contents($_FILES["file"]["tmp_name"]));
        http_response_code(200);
        if(empty($_POST["notename"]) or $_POST["notename"] == "undefined") $notename = $filename;
        else $notename = $_POST["notename"];
        $notename = cleanup($notename);
        $foldernum = $_POST["foldernum"];
        if($_POST["bloc"] === "true") $bloc = true;
        else $bloc = false;
        echo newnote($notename, $type, $dataURI, $foldernum, $bloc);
    }
} elseif(!empty($_FILES)){
    $filename = $_FILES["file"]["name"];
    $filetype = $_FILES["file"]["type"];
    $isgif = strpos($filetype, "image/gif") === 0;
    $isjpeg = strpos($filetype, "image/jpeg") === 0;
    $ispng = strpos($filetype, "image/png") === 0;
    if(!$isgif and !$isjpeg and !$ispng){
        http_response_code(500);
        header("Content-Type: text/plain");
        exit("Error while uploading.");
    } else {
        $dataURI = "data:" . $filetype . ";base64,";
        $dataURI .= base64_encode(file_get_contents($_FILES["file"]["tmp_name"]));
        http_response_code(200);
        $dataURI = preview($dataURI, "image", false);
        echo setprofilepic($dataURI, username());
    }
} else {
    $params = json_decode(file_get_contents('php://input'),true);
    if(!isset($params["function"])) echo "false";
    else {
        switch($params["function"]){
            case "notedata":
                if(!isset($params["id"])) echo "ID not given";
                elseif(!isset($params["name"])) echo "name not given";
                else {
                    $id = $params["id"];
                    $name = $params["name"];
                    $bloc = $params["bloc"];
                    if(!empty($params["data"])) $data = $params["data"];
                    else $data = "";
                    $success = editnote($id, $name, "name", $bloc);
                    if($success){
                        if(in_array(notearr($id, true, $bloc)["type"], ["text","url"])) {
                            if(!isset($params["data"])) echo "Data not given";
                            else echo editnote($id, $data, "data", $bloc);
                        } else echo false;
                    } else echo $success;
                }
                break;

            case "newfolder":
                if(sizeof(fullarray()["folders"]) >= 10) echo "Too many folders";
                else echo newfolder($params["name"]);
                break;

            case "newbloc":
                echo newfolder($params["name"], true);
                break;

            case "newnote":
                $params["note"] = cleanup($params["note"]);
                $params["type"] = cleanup($params["type"]);
                if(empty($params["data"])) $params["data"] = "";
                else $params["data"] = cleanup($params["data"]);
                $params["foldernum"] = cleanup($params["foldernum"]);
                echo newnote($params["note"], $params["type"], $params["data"], $params["foldernum"], $params["bloc"]);
                break;

            case "deletefolder":
                $params["foldernum"] = cleanup($params["foldernum"]);
                echo deletefolder($params["foldernum"]);
                break;

            case "deletebloc":
                    $params["blocnum"] = cleanup($params["blocnum"]);
                    echo deletefolder($params["blocnum"], true);
                break;

            case "leavebloc":
                    $params["blocnum"] = cleanup($params["blocnum"]);
                    echo leavebloc($params["blocnum"]);
                break;

            case "editfolder":
                $folderid = cleanup($params["folderid"]);
                $foldername = cleanup($params["foldername"]);
                $foldercolor = cleanup($params["foldercolor"]);
                $success = renamefolder($folderid, $foldername);
                if($success === true){
                    echo foldercolor($folderid, $foldercolor);
                } else echo $success;
                break;

            case "editbloc":
                $blocid = cleanup($params["blocid"]);
                $blocname = cleanup($params["blocname"]);
                $bloccolor = cleanup($params["bloccolor"]);
                $success = renamefolder($blocid, $blocname, true);
                if($success === true){
                    echo foldercolor($blocid, $bloccolor, true);
                } else echo $success;
                break;

            case "joinbloc":
                $refcode = cleanup($params["code"]);
                echo joinbloc($refcode);
                break;

            case "deletenote":
                $params["noteid"] = cleanup($params["noteid"]);
                $bloc = $params["bloc"];
                if($bloc === "true")
                    $bloc = true;
                elseif($bloc === "false")
                    $bloc = false;
                echo deletenote($params["noteid"], $bloc);
                break;

            case "renamenote":
                $noteid = cleanup($params["noteid"]);
                $notename = cleanup($params["notename"]);
                $bloc = $params["bloc"];
                if($bloc === "true")
                    $bloc = true;
                elseif($bloc === "false")
                    $bloc = false;
                echo editnote($noteid, $notename, "name", $bloc);
                break;

            case "userdetails":
                $name = cleanup($params["name"]);
                $username = cleanup($params["username"]);
                if(empty($params["education"])) $education = "";
                else $education = cleanup($params["education"]);
                if(empty($params["muns"])) $muns = "";
                else $muns = cleanup($params["muns"]);
                if(empty($params["awardswon"])) $awardswon = "";
                else $awardswon = cleanup($params["awardswon"]);
                echo edituser($name, $username, $education, $muns, $awardswon);
                break;

            case "newpassword":
                $oldpassword = cleanup($params["oldpassword"]);
                $newpassword = cleanup($params["newpassword"]);
                echo editpass($oldpassword, $newpassword);
                break;

            case "logout":
                logout();
                break;

            default:
                echo "false";
        };
    }
}