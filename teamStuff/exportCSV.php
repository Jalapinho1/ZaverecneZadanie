<?php
include_once "../config.php";
$dbname = "zavzadanie";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if points already exists
$sql="SELECT id,name,points,schoolyear,subject FROM teams";
$result = mysqli_query($conn,$sql);

if ($result->num_rows > 0){
    $delimiter = ";";
    $filename = "students_points_" . date('Y-m-d') . ".csv";

    //create a file pointer
    $f = fopen('php://memory', 'w');

    //set column headers
    $fields = array('ID', 'Name', 'Points','School year','Year');
    fputcsv($f, $fields, $delimiter);

    //output each row of the data, format line as csv and write to file pointer
    while($row = mysqli_fetch_array($result)) {
            $status = ($row['status'] == '1')?'Active':'Inactive';
        $lineData = array($row['id'], $row['name'], $row['points'],$row['schoolyear'],$row['subject']);
        fputcsv($f, $lineData, $delimiter);
    }

    //move back to beginning of file
    fseek($f, 0);

    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    //output all remaining data on a file pointer
    fpassthru($f);

}
