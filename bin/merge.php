<?php

include_once("app-functions.php");
use iio\libmergepdf\Merger;

if(!loggedin())
    die("Not logged in.");
elseif(empty($_GET["nb"]))
    die("No folder ID given.");

$nb = $_GET["nb"];
if(!empty($_GET["bloc"]) and ($_GET["bloc"] === "true" or $_GET["bloc"] === true))
    $bloc = true;
else
    $bloc = false;
$folderarr = foldernotesarr($nb, $bloc);
$exists = in_array(true,array_map(function($var1){global $nb;if($var1["id"]==$nb)return true;}, foldersarr($bloc)));

if(!$exists)
    die("Invalid notebook.");

header("Content-Disposition: attachment; filename='merged.pdf'");
$mpdf = new mPDF();
$pdf = new Merger();
$group = randtoken(20);

foreach($folderarr as $i => $note){
    switch($note["type"]){
        case "text":
            $id = $note["id"];
            $mpdf->WriteHTML(notearr($id, $bloc)["data"]);
            $blob = $mpdf->Output(null,"S");
            file_put_contents("sandbox/$group-$i.pdf", $blob);
            $pdf->addFromFile("sandbox/$group-$i.pdf");
            break;
        case "image":
            $im = new Imagick();
            $uri = notearr($note["id"], $bloc)["data"];
            $uri = substr($uri, strpos($uri, ";base64,")+8);
            $blob = base64_decode($uri);
            $im->readImageBlob($blob);
            $im->setImageFormat("pdf");
            $blob = $im->getImageBlob();
            file_put_contents("sandbox/$group-$i.pdf", $blob);
            $pdf->addFromFile("sandbox/$group-$i.pdf");
            break;
        case "word":
            $data = notearr($note["id"], $bloc)["data"];
            $strpos = strpos($data, ";base64,");
            $data = substr($data,$strpos + 8);
            file_put_contents("sandbox/$group-$i.docx", base64_decode($data));
            if(PHP_OS === "Linux")
                $cmd = "cd ../loffice/opt/libreoffice5.1/program && ./soffice --headless --convert-to pdf ../../../../app/sandbox/$group-$i.docx --outdir ../../../../app/sandbox/";
            else
                $cmd = "cd ../loffice/App/libreoffice/program && soffice.exe --headless --convert-to pdf ../../../../app/sandbox/$group-$i.docx --outdir ../../../../app/sandbox/";
            exec($cmd);
            $pdf->addFromFile("sandbox/$group-$i.pdf");
            break;
        case "pdf":
            $data = notearr($note["id"], $bloc)["data"];
            $strpos = strpos($data, ";base64,");
            $data = substr($data,$strpos + 8);
            file_put_contents("sandbox/$group-$i.pdf", base64_decode($data));
            $pdf->addFromFile("sandbox/$group-$i.pdf");
    }
}

echo $pdf->merge();
array_map('unlink', glob("sandbox/$group-*"));

?>