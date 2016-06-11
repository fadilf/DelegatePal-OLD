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

$pdf = new Merger();
$group = randtoken(20);

// First page
function pageval(){
    global $folderarr;
    global $bloc;
    return '
    <div style="text-align:center;">
    <br />
    <br />
    <br />
    <br />
    <br />
    <img style="display:inline-block; width:500px;" src="img/merged.png" />
    <br />
    <br />
    <br />
    <img style="display:inline-block; width:450px;" src="img/textlogo.png" />
    <br />
    <br />
    <br />
    <hr />
    <br />
    <br />
    <br />
    <div style="font-size:3.3em; margin-top:-.5em; font-family:clearsans; color:#101010;">
    '.
    folderinfo($folderarr[0]["folder"], $bloc)["name"]
    .'
    </div>
    <br />
    <hr />
    </div>
    ';
}

$kpdf = new mPDF();
$kpdf->WriteHTML(pageval());
$blob = $kpdf->Output(null,"S");
file_put_contents("sandbox/$group-.pdf", $blob);
$pdf->addFromFile("sandbox/$group-.pdf");

// Included pages
if(!empty($_GET["docs"])){
    $docarr = explode(",",$_GET["docs"]);
    foreach($docarr as $file){
        if(file_exists("docs/$file.pdf"))
            $pdf->addFromFile("docs/$file.pdf");
    }
}

set_time_limit(60);
    
// Notebook notes
foreach($folderarr as $i => $note){
    $approved = false;
    foreach($ufolders as $notebook)
        if($note["folder"] == $notebook["id"]){
            $approved = true;
        }
    if(!$approved){
        $note["type"] = null;
    }
    switch($note["type"]){
        case "text":
            $id = $note["id"];
            $mpdf = new mPDF();
            $mpdf->WriteHTML($note["data"]);
            $blob = $mpdf->Output(null,"S");
            file_put_contents("sandbox/$group-$i.pdf", $blob);
            $pdf->addFromFile("sandbox/$group-$i.pdf");
            $total++;
            break;/*
        case "url":
            $prefix = "http://";
            $pr1 = "HTTP://";
            $pr2 = "HTTPS://";
            $comp = strtoupper($note["data"]);
            if(strpos($comp,$pr1)===0 or strpos($comp,$pr2)===0) $prefix = "";
            $data = $prefix . $note["data"];
            if(filter_var($data, FILTER_VALIDATE_URL) !== false){
                if(PHP_OS === "Linux")
                    $cmd = "cd ../wkhtmltopdf/bin && ./wkhtmltopdf $data ../../app/sandbox/$group-$i.pdf";
                else
                    $cmd = "cd ../wkhtmltopdf/bin && wkhtmltopdf.exe $data ../../app/sandbox/$group-$i.pdf";
                exec($cmd, $result);
                var_dump($result);
                $pdf->addFromFile("sandbox/$group-$i.pdf");
            }
            break;*/
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
            $total++;
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
            $total++;
            break;
        case "pdf":
            $data = $note["data"];
            $strpos = strpos($data, ";base64,");
            $data = substr($data,$strpos + 8);
            file_put_contents("sandbox/$group-$i.pdf", base64_decode($data));
            $pdf->addFromFile("sandbox/$group-$i.pdf");
            $total++;
    }
}

header("Content-type: application/pdf");
echo $pdf->merge();
array_map('unlink', glob("sandbox/$group-*"));

?>