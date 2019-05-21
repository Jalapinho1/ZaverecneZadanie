<?php
session_start();
header('Cache-control: private'); // IE 6 FIX

if(isSet($_GET['lang'])) {
    $lang = $_GET['lang'];
// register the session and set the cookie
    $_SESSION['lang'] = $lang;
} else if(isSet($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
} else {
    $lang = 'sk';
}
$langtmp = $lang;
switch ($lang) {
    case 'en':
        $lang_file = 'lang_en.php';
        break;
    case 'sk':
        $lang_file = 'lang_sk.php';
        break;
    default:
        $lang_file = 'lang_sk.php';
}
include_once 'lang/'.$lang_file;
?>
<!DOCTYPE html>
<html lang="<?php echo $langtmp;?>">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <!--    <link rel="stylesheet" type="text/css" href="style.css">-->
    <meta charset="utf-8">

    <script src="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.es6.js" charset="UTF-8"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
<?php include 'navbar.php' ?>
<div class="undernavimg">
    <img id="headerimg" src="img/bcg2.png" alt="Nature" style="width: 100%;">
</div>
<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col text-center">
            <h2><?php echo $lang['HEADING'] ;?></h2>
        </div>
    </div>
    <table class="table table-bordered table-striped mt-5 table-hover shadow-lg p-3 mb-5 bg-white rounded dataTable no-footer">
        <thead>
        <tr><td class="text-center font-weight-bold" colspan="4 "><?php echo $lang['T_HEAD'] ;?></td></tr>
        </thead>
        <tbody>
            <tr>
                <th></th>
                <th><?php echo $lang['TASK_1'] ;?></th>
                <th><?php echo $lang['TASK_2'] ;?></th>
                <th><?php echo $lang['TASK_3'] ;?></th>
            </tr>
            <tr>
                <th>Eduardo Martinez</th>
                <td>x</td>
                <td>✓</td>
                <td>x</td>
            </tr>
            <tr>
                <th>Erik Lampert</th>
                <td>✓</td>
                <td>x</td>
                <td>x</td>
            </tr>
            <tr>
                <th>Martin Muller</th>
                <td>x</td>
                <td>x</td>
                <td>✓</td>
            </tr>
            <tr>
                <th>Peter Kocalka</th>
                <td>x</td>
                <td>x</td>
                <td>✓</td>
            </tr>
        </tbody>
    </table>
    <div class="row ml-2 mt-5 mb-5" >
        <a href="Technicka_dokumentacia.pdf"><?php echo $lang['T_Link'];?></a>
    </div>
</div>
<script src="myscript.js"></script>
</body>
</html>
