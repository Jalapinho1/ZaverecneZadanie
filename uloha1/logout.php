<?php
/**
 * Created by PhpStorm.
 * User: Eduardo Martinez
 * Date: 9. 3. 2019
 * Time: 20:15
 */
// Initialize the session
session_start();

// Unset all of the session variables
//$_SESSION = array();

// Destroy the session.
//session_destroy();

//Unset all of the session variables for login, dont reset lang variables
unset($_SESSION["loggedin"]);
unset($_SESSION["username"]);
unset($_SESSION["type"]);

// Redirect to login page

header("location: uloha1.php");
exit;
?>
