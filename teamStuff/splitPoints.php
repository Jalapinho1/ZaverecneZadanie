<?php
include_once "config.php";
$dbname = "zavzadanie";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$values = $_REQUEST['valuesArray'];
$ids = $_REQUEST['idsArray'];

$successUpdates = 0;
for ($i = 0;$i < sizeof($values);$i++){

    $sql="SELECT points FROM teams WHERE id LIKE '".$ids[$i]."'";
    $result = mysqli_query($conn,$sql);

    if ($result->num_rows == 1){
        $sql2 = "UPDATE teams SET points = '".$values[$i]."' WHERE id LIKE '".$ids[$i]."'";

        if ($conn->query($sql2) === TRUE) {
            $successUpdates++;
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
    }else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
if ($successUpdates == sizeof($values)){
    echo "Data succesfully updated";
}
