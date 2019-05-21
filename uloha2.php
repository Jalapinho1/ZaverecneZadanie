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
    <title>Task 2</title>
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
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

</head>
<body>
<?php include 'navbar.php' ?>
<div class="container">
    <form class="w-75 p-3 mb-5 mt-5 mx-auto shadow p-3 mb-5 bg-white rounded" id="loginForm" style="background-color: rgba(0,0,0,.05) !important;">
        <h5 class="mb-3 text-center"><?php echo $lang['FORM_HEADER'];?></h5>
        <div class="form-row">
            <div class="form-group col">
                <input type="text" name="login" class="form-control" placeholder="<?php echo $lang['FORM_NAME'];?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col">
                <input type="password" name="password" class="form-control" placeholder="<?php echo $lang['FORM_PASSW'];?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col">
                <button type="button" class="btn btn-primary" onclick="submitForm('ldaplogin.php')"><?php echo $lang['FORM_LOGIN'];?></button>
                <button type="button" class="btn btn-primary" onclick="submitForm('loginadmin.php')"><?php echo $lang['FORM_ADMLOGIN'];?></button>
            </div>
        </div>
    </form>
    <div id="success"  class="mx-auto text-danger" style="width: 300px;" ></div>
    <div class="mt-5 mx-auto" style="width: 200px;" >
    </div>
    <?php
    include_once "config.php";
    $dbname = "zavzadanie";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql="SELECT subject FROM teamPoints GROUP BY subject";
    $result = mysqli_query($conn,$sql);
    $sql1="SELECT schoolyear FROM teamPoints GROUP BY schoolyear";
    $result1 = mysqli_query($conn,$sql1);
    if ($result->num_rows > 0) :
    ?>
    <form class="w-75 p-3 mb-5 mt-5 mx-auto shadow p-3 mb-5 bg-white rounded" id="stats" style="background-color: rgba(0,0,0,.05) !important;">
        <h5 class="mb-3 text-center"><?php echo $lang['FORM_HEADER'];?></h5>
        <div class="form-row">
            <div class="form-group col">
                <label for="schoolyear"><?php echo $lang['FORM_SUBJECT'];?></label>
                <select  class="custom-select mr-sm-2" name="subject" size="1" required>
                    <?php     while($row = mysqli_fetch_array($result)) : ?>
                    <option value="<?php echo $row['subject']?>" selected><?php echo $row['subject']?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col">
                <label for="schoolyear"><?php echo $lang['FORM_YEAR'];?></label>
                <select  class="custom-select mr-sm-2" name="schoolyear" size="1" required>
                    <?php     while($row1 = mysqli_fetch_array($result1)) : ?>
                        <option value="<?php echo $row1['schoolyear']?>" selected><?php echo $row1['schoolyear']?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col">
                <button type="submit" id="submit" name="submit" class="btn btn-primary">Statistics</button>
            </div>
        </div>
    </form>
    <?php endif;?>
    <div class="row">
        <div class="col" id="graphDiv"></div>
        <div class="col" id="graphDiv2"></div>
    </div>

</div>
<script src="myscript.js"></script>

</body>
</html>
