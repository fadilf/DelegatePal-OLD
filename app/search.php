<?php

// Search Structure-
// search.php?case=[country]
include "../functions.php";

$search = isset($_GET["q"])? cleanup($_GET["q"]):"";
$wango = isset($_GET["wango"])? true:false;
$results = [];
$results["BBC"] = [];
$results["CIA Factbook"] = [];
$results["FindTheData"] = [];
$results["National Geographic"] = [];
$results["United Nations"] = [];
$results["Wikipedia"] = [];

if(empty($search) or $search === "undefined"){
    die(json_encode($results));
} elseif(!$wango){
    $jsons["BBC"] = file_get_contents("json/bbc.json");
    $jsons["CIA Factbook"] = file_get_contents("json/factbook.json");
    $jsons["FindTheData"] = file_get_contents("json/findthedata.json");
    $jsons["National Geographic"] = file_get_contents("json/natgeo.json");
    $jsons["United Nations"] = file_get_contents("json/un.json");
    $jsons["Wikipedia"] = file_get_contents("json/wiki.json");
    foreach($jsons as $id=>$json){
        $json = json_decode($json);
        foreach($json as $print=>$val){
            $parr = explode(" ", $print);
            foreach($parr as $word){
                if($word === "-")
                    break;
                if(stripos($print,$search)===0){
                    array_push($results[$id],[$print,$val]);
                    break;
                }
            }
        }
    }
    die(json_encode($results));
} ?>
Redirecting...
<?php if($wango): ?>
<form method="post" action="http://www.wango.org/resources.aspx?section=ngodir&sub=list&regionID=0">
    <input type="hidden" name="keyword" value="<?=$search?>">
    <input type="hidden" name="search_mission" value="">
    <input type="hidden" name="search_focus" value="">
    <input type="hidden" name="search_regionID" value="0">
    <input type="hidden" name="search_country" value="0">
    <input type="hidden" name="search_state" value="">
    <input type="hidden" name="search_city" value="">
    <input type="hidden" name="search_zip" value="">
    <input type="hidden" name="search_address" value="">
    <input type="hidden" name="InterestAreas" value="">
    <input type="hidden" name="currpage" value="">
    <input type="hidden" name="ffrom" value="">
    <input type="hidden" name="fto" value="zz">
    <input type="hidden" name="searching" value="1">
    <input id="wango" type="submit" name="submitbutton" value="Search" style="display:none">
</form>
<script>
    document.getElementById("wango").click();
</script>
<?php endif; ?>