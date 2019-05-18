<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 17.05.2019
 * Time: 15:36
 */


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


    $sql = "SELECT * FROM `LogTable`";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>Datum</th><th>Meno Studenta</th><th>Predmet spravy</th><th>ID sablony</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row['datum']."</td>";
            echo "<td>".$row['menoStudenta']."</td>";
            echo "<td>".$row['predmetSpravy']."</td>";
            echo "<td>".$row['idSablony']."</td></tr>";

        }
        echo "</table>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
