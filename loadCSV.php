<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpMailer/Exception.php';
require 'phpMailer/PHPMailer.php';
require 'phpMailer/SMTP.php';

function nacitaj($nazovSuboru,$oddelovac){


    $file_handle = fopen($nazovSuboru, "r");

    $hlavicka = fgetcsv($file_handle, 1024,$oddelovac);

    $vysledok = array();
    array_push($vysledok,$hlavicka);
    while (!feof($file_handle) ) {
        $obj = array();

        $line_of_text = fgetcsv($file_handle, 1024, $oddelovac);


        for($i = 0;$i<count($line_of_text);$i++){

            $obj[$hlavicka[$i]] = $line_of_text[$i];
        }
        array_push($vysledok,$obj);
    }
    fclose($file_handle);
    return $vysledok;
}

function saveCSV($vstup,$nazovSuboru){
   // echo "zaciatok ukladania";
    $fp = fopen($nazovSuboru, 'w');
    foreach ($vstup as $row) {

        fputcsv($fp, $row,';');
    }
    fclose($fp);
}

function generateRandomString($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function pridajHeslo($vstup){
    $vystup = array();
    $isHeader = 0;
    foreach ($vstup as $row) {
        if($isHeader==0){
            array_push($row,"heslo");
            $isHeader= 4;
        }
        else{
            $row["heslo"] = generateRandomString();
        }
        array_push($vystup,$row);
    }
    return $vystup;
}

function nacitajSablonu($idSablony){
    $servername = "localhost";
    $username = "xkocalka";
    $password = "VvniA3fHVkt8";
    $db = "prvadb";
    $port = 8158;

    $conn = mysqli_connect($servername, $username, $password, $db, $port);
    mysqli_query($conn, "SET NAMES utf8");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }else{
        //echo "connected";
    }

    $template = "";
    $sql = "SELECT emailContent FROM `EmailTemplate` WHERE emailId = '$idSablony'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $template = $row['emailContent'];
            break;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    return $template;
}


function pripravEmail($sablona,$hlavicka,$student, $sender){
    foreach ($hlavicka as $hlav){
       $premennaSablony =   "{{".$hlav."}}";
       $sablona =  str_replace($premennaSablony,$student[$hlav],$sablona);
    }
    $premennaSablony =   "{{sender}}";
    $sablona =  str_replace($premennaSablony,$sender,$sablona);
    return $sablona;
}

function databaseLog($idsablony,$hlavicka,$student, $subject){
    $servername = "localhost";
    $username = "xkocalka";
    $password = "VvniA3fHVkt8";
    $db = "prvadb";
    $port = 8158;

    $conn = mysqli_connect($servername, $username, $password, $db, $port);
    mysqli_query($conn, "SET NAMES utf8");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }else{
        echo "<br>connected<br>";
    }

    foreach ($hlavicka as $hlav){
        $premenna =  $hlav;
        if($premenna == 'meno'){
            $date = date("Y-m-d");
            $sql = "INSERT INTO LogTable (datum, menoStudenta, predmetSpravy, idSablony) VALUES ('$date','$student[$premenna]', '$subject','$idsablony' )";
            if ($conn->query($sql) === TRUE) {
                echo "<br><br>successfully uploaded";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

}

/*
function vyberMail($nazov){
    $file_handle = fopen($nazov, "r");
    $maily = array();

    while (!feof($file_handle) ) {
        $line_of_text = fgetcsv($file_handle, 1024, ';');


    }
}
*/

function odosliEmail($adresa,$sprava, $data ,$flag, $attachment = null, $idkwhat=null){
    echo"<br>";
    echo"<br>";
    echo "funkcia zacala".$attachment.$idkwhat;
    echo"<br>";
    echo"<br>";

    if(!isset($idkwhat)){
        $attachment = null;
    }

    $mail = new PHPMailer(true);
try {

    $mail->isSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->IsHTML(true);
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = "mail.stuba.sk";
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = $data[0];//"xkocalka";//"xmullerm";
    $mail->Password = $data[2];//"L.n.a.n.i.127";//"MARtin1234dext";
    $mail->setFrom(/*'muller.martin65@stuba.sk''xkocalka@stuba.sk'*/$data[1], $data[0]);
    $mail->addAddress($adresa, 'To');



    if($flag == "html"){

            $mail->Subject = $data[3];//"Subject"; //parameter
            $mail->Body ="<div class=\"editor\" contenteditable><p>".$sprava."</p></div>";
/* "<link rel=\"stylesheet\" href=\"css.css\">
<a href=\"#\" data-command='h2'>H2</a>
<a href=\"#\" data-command='undo'>a<i class='fa fa-undo'></i></a>
<a href=\"#\" data-command='createlink'>b<i class='fa fa-link'></i></a>
<a href=\"#\" data-command='justifyLeft'>c<i class='fa fa-align-left'></i></a>
<a href=\"#\" data-command='superscript'>d<i class='fa fa-superscript'></i></a>
<div class=\"fore-wrapper\"><i class='fa fa-font'>pal</i>
  <div class=\"fore-palette\">
  </div>
</div>
<script src=\"HtmlEditor.js\"></script>*/
            if(isset($attachment)){
                $mail->AddAttachment($attachment,
                    $idkwhat);
            }
            $mail->IsHTML(true);

    }else {
        $mail->Subject = $data[3];//"Subject"; //parameter
        $mail->Body = $sprava;
        if(isset($attachment)){
        $mail->AddAttachment($attachment,
            $idkwhat);
        }
        $mail->IsHTML(false);
    }

    if (!$mail->send()) {
        echo "Error sending message";
        return false;
    } else {
        echo "Message sent!";
        return true;
    }
}catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    return false;

}

}