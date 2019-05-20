<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['adminTable']){
    $_SESSION['adminTable'] = false;
}else{
    $_SESSION['adminTable'] = true;
}
header("Location: ../teamview.php");
