<?php
include_once "config.php";
$dbname = "zavzadanie";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$subject = $_REQUEST['subject'];
$year =  $_REQUEST['schoolyear'];
$value = $_REQUEST['value'];
$admin = $_REQUEST['admin'];

if ($admin == "false"){
    $idToCut= $_REQUEST['id'];

    $id = substr(strval($idToCut), -5);
    //echo $id;

    $agreed = $_REQUEST['agreed'];
    $true = 1;
    if ($agreed === "true"){
        $sql = "UPDATE teams SET accepted = '".$true."' WHERE id LIKE '".$id."' AND subject LIKE '".$subject."' AND schoolyear LIKE '".$year."'";

        if ($conn->query($sql) === TRUE) {
            echo "updated";
        } else {
            echo "Error: " . $sql0 . "<br>" . $conn->error;
        }

    }else{
        $sql = "UPDATE teams SET disagreed = '".$true."' WHERE id LIKE '".$id."' AND subject LIKE '".$subject."' AND schoolyear LIKE '".$year."'";

        if ($conn->query($sql) === TRUE) {
            echo "updated";
        } else {
            echo "Error: " . $sql0 . "<br>" . $conn->error;
        }

    }
    //echo $agreed;
}else{
    $id= $_REQUEST['id'];
//    echo $operation;
//    echo $id;

    $true = 1;
    $sql = "UPDATE teamPoints SET adminInput= '".$true."',adminAgreement= '".$true."' WHERE team_id LIKE '".$id."' 
            AND subject LIKE '".$subject."' AND schoolyear LIKE '".$year."'";

    if ($conn->query($sql) === TRUE) {
        echo "updatedAdmin";
    } else {
        echo "Error: " . $sql0 . "<br>" . $conn->error;
    }

}


