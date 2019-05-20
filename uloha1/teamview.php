<?php
/**
 * Created by PhpStorm.
 * User: Eduardo Martinez
 * Date: 9. 3. 2019
 * Time: 19:10
 */

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: uloha1.php");
    exit;
}

header('Cache-control: private'); // IE 6 FIX

if (isSet($_GET['lang'])) {
    $lang = $_GET['lang'];
// register the session and set the cookie
    $_SESSION['lang'] = $lang;
} else if (isSet($_SESSION['lang'])) {
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
include_once 'lang/' . $lang_file;

?>

<!DOCTYPE html>
<html lang="<?php echo $langtmp;?>">
<head>
    <meta charset="utf-8">
    <title>Team view</title>

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

</head>
<body>
<?php include 'navbar.php' ?>
<div class="container">
    <?php
    $type = 0;
    $loginname = $_SESSION["type"];
     switch ($loginname){
         case 'admin':
             $type = 0;
             break;
         case 'student':
             $type = 1;
             break;
         default:
             $type = 0;
     }

     if ($type == 0){
         include "teamStuff/admin.php";
     }else{
         include "teamStuff/student.php";
     }
    ?>

    <?php
    include "funkcie.php";
    $servername = "localhost";
    $username = "xlamperte";
    $password = "heslo";
    $dbname = "zavzadanie";
    $connect = mysqli_connect($servername, $username, $password, $dbname);

    if (mysqli_connect_errno()) {
        printf("Connection failed: %s\n", mysqli_connect_error());
        exit();
    }


    if(isset($_POST["uploadFile"])) {

        if($_FILES['csvInput']['name']) {
            $name = explode(".",$_FILES["csvInput"]["name"]);

            if(end($name) == "csv") {
                $subj = "'".$_POST["subject"]."'";

                $year = "'".$_POST["year"]."'";
                $delimiter = $_POST['delimiter'];

                $subId = overPredmet($connect,$subj);

                $fileHandler = fopen($_FILES["csvInput"]["tmp_name"],"r");
                naplnTabulku($fileHandler,$connect,$year,$subId,$delimiter);
                fclose($fileHandler);
            } else {
                $msg = '<label class="text-danger"> Input file must be csv! </label>';
            }
        }
    }

    if($_SESSION["type"] != "student") {
        echo '<form id="deleteForm" class="w-75 p-3 mb-5 mt-5 mx-auto shadow p-3 mb-5 bg-white rounded" style="background-color: rgba(0,0,0,.05) !important;" method="post" action="./teamview.php">
        
            <div class="form-group">
                <label>'. $lang["TEAMLBL"].'</label><br>
                
                <select id="deleteInput" class="form-control" name="subjectDelete" >';
        //naplnenie selectu hodnotami z databazy
        $fillSubjects = "SELECT * FROM Predmety";
        $fillRes = mysqli_query($connect, $fillSubjects);
        while ($row = mysqli_fetch_array($fillRes)) {
            $subjname = $row['Nazov'];
            echo('<option value="' . $subjname . '">' . $subjname . '</option>');
        }
        echo '</select>
                    
            </div>
            <br>
            <div class="form-row">
                <div class="form-group col">
                <input type="submit" name="delete" class="btn btn-primary" value="'. $lang['TEAMRMW'].'">
                    </div>
            </div>
        </div>
        </div>
    </form>
    <br>';
    }

    if(isset($_POST["delete"])) {
        $subjname= $_POST["subjectDelete"];


        deleteSub($subjname,$connect);

    }


    ?>
</div>
</body>
</html>