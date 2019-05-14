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
    //sem vlozit vlkadanie sablon z datbazy
    return "Dobrý deň,
            na predmete Webové technológie 2 budete mať k dispozícii vlastný virtuálny linux server, ktorý budete
            používať počas semestra, a na ktorom budete vypracovávať zadania. Prihlasovacie údaje k Vašemu serveru
            su uvedené nižšie.
            ip adresa: {{verejnaIP}}
            prihlasovacie meno: {{login}}
            heslo: {{heslo}}
            Vaše web stránky budú dostupné na: http:// {{verejnaIP}}:{{http}}
            S pozdravom,
            {{sender}}";
}


function pripravEmail($sablona,$hlavicka,$student){
    foreach ($hlavicka as $hlav){
       $premennaSablony =   "{{".$hlav."}}";
       $sablona =  str_replace($premennaSablony,$student[$hlav],$sablona);
    }
    return $sablona;
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

function odosliEmail($adresa,$sprava){
    echo"<br>";
    echo"<br>";
    echo $adresa;
    echo "funkcia zacala";
    echo"<br>";
    echo"<br>";

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
    $mail->Username = "xmullerm";
    $mail->Password = "MARtin1234dext";
    $mail->setFrom('muller.martin65@stuba.sk', 'Your Name');
    $mail->addAddress($adresa, 'To');

    $mail->Subject = "Subject"; //parameter
    $mail->Body = $sprava;

    if (!$mail->send()) {
        echo "Error sending message";
    } else {
        echo "Message sent!";
    }
}catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

}


}