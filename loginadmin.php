<?php
/**
 * Created by PhpStorm.
 * User: Eduardo Martinez
 * Date: 9. 3. 2019
 * Time: 18:22
 */

include_once "config.php";
$dbname = "zavzadanie";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['login'])){
    $log = $_POST['login'];
    $passw = $_POST['password'];

    $result = $conn->query("SELECT login,password FROM admins WHERE login LIKE '$log'");
    $row = mysqli_fetch_assoc($result);

    if($result->num_rows != 0) {
        if (password_verify($passw, $row['password'])){
            session_start();

            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] =  $log;
            $_SESSION["type"] = 'admin';

            echo "teamview.php";
        }else {
            $password_err = "The password you entered was not valid.";
            echo $password_err;
        }
    } else {
        echo "No account with username " .$log ." found";
    }
}else{
    echo "Go back and insert Login data.";
}

