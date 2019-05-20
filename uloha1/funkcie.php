<?php
/**
 * Created by PhpStorm.
 * User: Erik
 * Date: 05/19/2019
 * Time: 11:48
 */
$servername = "localhost";
$username = "xlamperte";
$password = "heslo";
$dbname = "zavzadanie";
$connect = mysqli_connect($servername, $username, $password, $dbname);


function overPredmet($connect,$subjName)
{
    $findSub = "SELECT * FROM Predmety WHERE Nazov = $subjName";
    $subResult = mysqli_query($connect, $findSub);
    if(mysqli_num_rows($subResult) == 0) {
        $newSub  = "INSERT INTO Predmety(Nazov) VALUES ($subjName)";
        mysqli_query($connect,$newSub);
    }
    $sqlSub = "SELECT * FROM Predmety WHERE Nazov = $subjName";
    $subRes = mysqli_query($connect,$sqlSub);
    $subId = mysqli_fetch_array($subRes)['Id'];
    return $subId;
}

function overStudenta($connect,$studentId,$meno)
{
    $findStudent = "SELECT * FROM Studenti WHERE Id = $studentId";
    $StudentResult = mysqli_query($connect, $findStudent);
    if(mysqli_num_rows($StudentResult) == 0) {
        $newSub  = "INSERT INTO Studenti(Id,Meno) VALUES ($studentId,$meno)";
        mysqli_query($connect,$newSub);
    }
}

function naplnTabulku($fileHandler,$connect,$year,$subId,$delimiter) {
    $theader = true;
    while($result = fgetcsv($fileHandler,1000,"$delimiter")) {
        if ($theader) {
            $theader = false;
        } else {
            $idStudent = "'" . $result[0] . "'";
            $nameStudent = "'" . $result[1] . "'";
            $zapocet = $result[2];
            $skuska_rt = $result[3];
            $skuska_ot = $result[4];
            $bonus = "'" . $result[7] . "'";
            $spolu = $result[5];
            $znamka = "'" . $result[6] . "'";
            overStudenta($connect, $idStudent, $nameStudent);

            $sqlCheck = "SELECT * FROM Main WHERE Id_student = $idStudent AND Id_predmet = $subId";
            $checkRes = mysqli_query($connect, $sqlCheck);
            if (mysqli_num_rows($checkRes) == 0) {

                $sql = "INSERT INTO Main (Id_student, Zapocet,Skuska_rt,Skuska_ot,Bonus,Spolu,Znamka,Rok,Id_predmet)
                        VALUES ($idStudent, $zapocet, $skuska_rt, $skuska_ot, $bonus, $spolu, $znamka ,$year,$subId)";
                mysqli_query($connect, $sql);
            } else {

                $sqlUpdate = "UPDATE Main SET Zapocet=$result[2], Skuska_rt=$result[3] ,Skuska_ot=$result[4], Bonus = $result[7],Spolu=$result[5],Znamka='$result[6]' WHERE Id_student =  $idStudent AND Id_predmet = $subId";
                mysqli_query($connect, $sqlUpdate);
            }
        }
    }
}


function deleteSub($name,$connect)
{

    $findSub = "SELECT * FROM Predmety WHERE Nazov = '$name'";
    $delResult = mysqli_query($connect, $findSub);
    if(mysqli_num_rows($delResult) != 0) {
        $row = mysqli_fetch_array($delResult);
        $pid = $row['Id'];
        $delQuery = "DELETE FROM Main WHERE Id_predmet = $pid";
        mysqli_query($connect,$delQuery);
        $delQuery2 = "DELETE FROM Predmety WHERE Id = $pid";
        mysqli_query($connect,$delQuery2);
        $studentQuery = "SELECT * FROM Studenti";
        $studRes = mysqli_query($connect,$studentQuery);

        while($row = mysqli_fetch_array($studRes)) {
            $studId = $row['Id'];
            $sqlq = "SELECT * FROM Studenti JOIN Main ON Studenti.Id = Main.Id_student";
            $res  = mysqli_query($connect,$sqlq);
            if(mysqli_num_rows($res) == 0) {
                $deleteStud =  "DELETE FROM Studenti WHERE Id = '$studId'";
                mysqli_query($connect,$deleteStud);
            }
        }
    }
}




?>