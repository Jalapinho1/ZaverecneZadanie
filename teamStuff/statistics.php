<?php

include_once "config.php";
$dbname = "zavzadanie";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$subject = $_POST['subject'];
$schoolyear = $_POST['schoolyear'];

//------------------POCET STUDENTOV--------
$sql="SELECT COUNT(*) as cnt FROM teams WHERE subject LIKE '".strval($subject)."' AND schoolyear LIKE '".strval($schoolyear)."'";
$result = mysqli_query($conn,$sql);
$countNum = "0";
while($row = mysqli_fetch_array($result)) {
    $countNum = $row['cnt'];
}
//echo $countNum;

//------POCET SUHLASIACICH STUDENTOV--------
$sql="SELECT COUNT(*) as cnt FROM teams WHERE accepted = 1 AND subject LIKE '".strval($subject)."' AND schoolyear LIKE '".strval($schoolyear)."'";
$result = mysqli_query($conn,$sql);
$countNumA = "0";
while($row = mysqli_fetch_array($result)) {
    $countNumA  = $row['cnt'];
}
//echo $countNumA;

//-----POCET NESUHLASIACICH STUDENTOV--------
$sql="SELECT COUNT(*) as cnt FROM teams WHERE disagreed = 1 AND subject LIKE '".strval($subject)."' AND schoolyear LIKE '".strval($schoolyear)."'";
$result = mysqli_query($conn,$sql);
$countNumD = "0";
while($row = mysqli_fetch_array($result)) {
    $countNumD = $row['cnt'];
}
//echo $countNumD;

//-----POCET NEVYJADRENYCH STUDENTOV--------
$sql="SELECT COUNT(*) as cnt FROM teams WHERE disagreed = 0 AND accepted = 0 AND subject LIKE '".strval($subject)."' AND schoolyear LIKE '".strval($schoolyear)."'";
$result = mysqli_query($conn,$sql);
$countNumAD = "0";
while($row = mysqli_fetch_array($result)) {
    $countNumAD = $row['cnt'];
}
//echo $countNumAD;

$studentInfo = array($countNum, $countNumA,$countNumD, $countNumAD);
//echo json_encode($studentInfo);

//-----POCET TIMOV--------
$sql="SELECT COUNT(*) as cnt FROM teamPoints WHERE subject LIKE '".strval($subject)."' AND schoolyear LIKE '".strval($schoolyear)."'";
$result = mysqli_query($conn,$sql);
$countTeams = "0";
while($row = mysqli_fetch_array($result)) {
    $countTeams = $row['cnt'];
}

//-----POCET uzavretych TIMOV--------
$sql="SELECT COUNT(*) as cnt FROM teamPoints WHERE adminInput = 1 AND adminAgreement = 1 AND subject LIKE '".strval($subject)."' AND schoolyear LIKE '".strval($schoolyear)."'";
$result = mysqli_query($conn,$sql);
$countTeamsC = "0";
while($row = mysqli_fetch_array($result)) {
    $countTeamsC = $row['cnt'];
}

//-----POCET TIMOV ku ktorym sa treba vyjadrit--------
$sql="SELECT COUNT(*) as cnt FROM teamPoints WHERE adminInput = 0 AND subject LIKE '".strval($subject)."' AND schoolyear LIKE '".strval($schoolyear)."'";
$result = mysqli_query($conn,$sql);
$countTeamsO = "0";
while($row = mysqli_fetch_array($result)) {
    $countTeamsO = $row['cnt'];
}

//-----POCET TIMOV S KTORYMI NESUHLASI ADMIN--------
$sql="SELECT COUNT(*) as cnt FROM teamPoints WHERE adminInput = 1 AND adminAgreement = 0 AND subject LIKE '".strval($subject)."' AND schoolyear LIKE '".strval($schoolyear)."'";
$result = mysqli_query($conn,$sql);
$countTeamsS= "0";
while($row = mysqli_fetch_array($result)) {
    $countTeamsS = $row['cnt'];
}

$teamInfo = array($countTeams, $countTeamsC, $countTeamsO,$countTeamsS );

echo json_encode(array($studentInfo, $teamInfo));

?>
