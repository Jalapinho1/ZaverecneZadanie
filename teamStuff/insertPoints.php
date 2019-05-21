<?php
include_once "../config.php";
$dbname = "zavzadanie";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$subject = $_POST['subject'];
$year = $_POST['schoolyear'];

$points = $_POST['points'];
$teamID = $_POST['teamID'];

// Check if points already exists
$sql="SELECT team_id FROM teamPoints WHERE team_id LIKE '".$teamID."' AND subject LIKE '".strval($subject)."' AND schoolyear LIKE '".strval($year)."'";
$result = mysqli_query($conn,$sql);

if (!empty($subject) && !empty($year)){
    if ($result->num_rows == 1){
        $sql2 = "UPDATE teamPoints SET points = '".$points."' WHERE team_id LIKE '".$teamID."'
             AND subject LIKE '".strval($subject)."' AND schoolyear LIKE '".strval($year)."'";

        if ($conn->query($sql2) === TRUE) {
            echo "✓";
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
    }
}else{
    echo "Error updating the database.";
}


