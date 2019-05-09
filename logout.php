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
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: uloha2.php");
exit;
?>