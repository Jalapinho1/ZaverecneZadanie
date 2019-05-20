<?php

include_once "../config.php";
$dbname = "zavzadanie";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$schoolyear =  "";
$subject =   "";
if(isset($_POST['submit'])){
    $filename=$_FILES["file"]["tmp_name"];
    $separator = $_POST['separator'];
    $schoolyear =  $_POST['schoolyear'];
    $subject =  $_POST['subjectname'];

    if($_FILES["file"]["size"] > 0)
    {
        $file = fopen($filename, "r");
        while (($getData = fgetcsv($file, 10000, strval($separator))) !== FALSE)
        {
            echo "here";
            $sql = "INSERT into teams (id,name,email,passw,team_id,subject,schoolyear) 
                   values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$subject."','".$schoolyear."')";
            $result = mysqli_query($conn, $sql);
            if(!isset($result))
            {
                echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"../teamview.php\"
              </script>";
            }
            else {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['adminTable'] = true;
                $_SESSION['subjectName'] = $subject;
                $_SESSION['schoolYear'] = $schoolyear;
                header("Location: ../teamview.php");
            }
        }

        fclose($file);
    }
}
$sql1="SELECT team_id,SUM(points) as sum FROM teams GROUP BY team_id,schoolyear,subject HAVING subject LIKE '".$subject."' AND schoolyear LIKE'".$schoolyear."'";
$result1 = mysqli_query($conn,$sql1);
while($row1 = mysqli_fetch_array($result1)) {
    $rowSum = $row1['sum'];
    $rowId =  $row1['team_id'];
    $sql = "INSERT into teamPoints (team_id,points,subject,schoolyear) 
                   values ('".$rowId."','".$rowSum."','".$subject."','".$schoolyear."')";
    if ($conn->query($sql) === TRUE) {
        echo "Inserted";
    } else {
        echo "Error: " . $sql0 . "<br>" . $conn->error;
    }
}
