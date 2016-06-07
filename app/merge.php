<?php

include_once("app-functions.php");
use iio\libmergepdf\Merger;

if(!loggedin())
    die("Not logged in.");
elseif(empty($_GET["notes"]))
    die("No note IDs given.");

$notes = $_GET["notes"];
if(!empty($_GET["bloc"]) and ($_GET["bloc"] === "true" or $_GET["bloc"] === true))
    $bloc = true;
else
    $bloc = false;
$folderarr = explode(",",$notes);
$sfolderarr = sizeof($folderarr);
$blocarr = array_fill(0, $sfolderarr, $bloc);
$falsearr = array_fill(0, $sfolderarr, false);
$folderarr = array_map("notearr", $folderarr, $falsearr, $blocarr);
$ufolders = foldersarr($bloc);

header("Content-Disposition: attachment; filename='merged.pdf'");
//header("Content-type: application/pdf");
$pdf = new Merger();
$group = randtoken(20);

if(!empty($_GET["docs"])){
    $docarr = explode(",",$_GET["docs"]);
    foreach($docarr as $file){
        if(file_exists("docs/$file.pdf"))
            $pdf->addFromFile("docs/$file.pdf");
    }
}

foreach($folderarr as $i => $note){
    $approved = false;
    foreach($ufolders as $notebook)
        if($note["folder"] == $notebook["id"]){
            $approved = true;
            break;
        }
    if(!$approved)
        $note["type"] = null;
    switch($note["type"]){
        case "text":
            $id = $note["id"];
            $mpdf = new mPDF();
            $mpdf->WriteHTML($note["data"]);
            $blob = $mpdf->Output(null,"S");
            file_put_contents("sandbox/$group-$i.pdf", $blob);
            $pdf->addFromFile("sandbox/$group-$i.pdf");
            break;
        case "image":
            $im = new Imagick();
            $uri = $note["data"];
            $uri = substr($uri, strpos($uri, ";base64,")+8);
            $blob = base64_decode($uri);
            $im->readImageBlob($blob);
            $im->setImageFormat("pdf");
            $blob = $im->getImageBlob();
            file_put_contents("sandbox/$group-$i.pdf", $blob);
            $pdf->addFromFile("sandbox/$group-$i.pdf");
            break;
        case "word":
            $data = $note["data"];
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
            $data = $note["data"];
            $strpos = strpos($data, ";base64,");
            $data = substr($data,$strpos + 8);
            file_put_contents("sandbox/$group-$i.pdf", base64_decode($data));
            $pdf->addFromFile("sandbox/$group-$i.pdf");
    }
}

echo $pdf->merge();
array_map('unlink', glob("sandbox/$group-*"));

?>