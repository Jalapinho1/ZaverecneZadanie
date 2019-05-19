<?php
session_start();
//echo "login ".$_SESSION['username'];
include 'loadCSV.php';

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
      <link rel="stylesheet" type="text/css" href="styles.css">
      <meta charset="utf-8">

      <script src="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"></script>

      <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel ="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.mon.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.es6.js" charset="UTF-8"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/boostrsap/4.3.1/js/bootstrap.min.js"></script>
    <!------------------------------------------------------------->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
    <script src="HtmlEditor.js"></script>
</head>
<body>


<?php
include 'navbar.php';
//$nazovSuboru = "vystup.csv";

//echo"vysledok";
//echo "<br>";
//var_dump($data);
//echo "ukladanie vystupu";
//echo "<br>";
?>


<div class="container-fluid" id="up1">
    <div class="row">
    <div class="col-sm">
        <h2><?php echo $lang['Header1']; ?></h2>

     <form method="post" enctype = "multipart/form-data">
         <div class="form-group">
           <label for="subor"><?php echo $lang['Label1']; ?></label>
            <input type="file" name="subor">
             <br>
             <label for="odelovac"><?php echo $lang['Oddelovac']; ?></label>
             <input type="text" name="oddelovac">
             <br>
              <input type="submit" class="btn btn-primary mb-2" value="<?php echo $lang['Potvrdenie1'];?>" name="submit">


        </div>
     </form>
    </div>

    <div class="col-sm">
        <h2><?php echo $lang['Header2']; ?></h2>
        <form method="post">
            <label><?php echo $lang['Sablona']; ?></label>
            <input type="number" id="param" name="param"><br>
            <input type="submit" class="btn btn-primary mb-2" value="<?php echo $lang['Sablona2']; ?>" name="submit3" >
        </form>
        <form id="eemail" method="post" enctype = "multipart/form-data">
            <div class="form-group">
                <label for="subor"><?php echo $lang['Label2']; ?></label>
                <input type="file" name="subor2" required>
                <br>
                <input type="text" name="usr" placeholder="<?php echo $lang['PlaceHolder1']; ?>" required>
                <input type="email" name="mail" placeholder="<?php echo $lang['PlaceHolder2']; ?>" required>
                <input type="password" name="pass" placeholder="<?php echo $lang['PlaceHolder3']; ?>" required><br>
                <!--label>Id Sablony    </label>
                <input type="number" id="idsablony" name="idsablony"><br-->
                <label><?php echo $lang['PlaceHolder4']; ?></label>
                <input type="text" name="subject" placeholder="<?php echo $lang['PlaceHolder5']; ?>" required><br><br>
                <label><?php echo $lang['Priloha']; ?></label><br>
                <input type="file" name="attachment"><br><br>
                <input type="submit" class="btn btn-primary mb-2" value="<?php echo $lang['Odoslanie']; ?>" name="submit2" >
                <input type="radio" name="emailType" value="plain" checked> <?php echo $lang['Text1']; ?>
                <input type="radio" name="emailType" value="html"> <?php echo $lang['Text2']; ?><br>
            </div>

        </form>

        <textarea id="summernote" form="eemail" name="edited" > <?php if(isset($_POST['param'])){echo nacitajSablonu($_POST['param']); $_SESSION['IDS']=$_POST['param'];} ?></textarea>
        <button onclick="show()" ><?php echo $lang['Tabulka']; ?></button>
    <!--<button id="gimmemytemplate">Upraviť šablónu</button><script>

        $("#gimmemytemplate").click(function(){
            var id = $('#idsablony').val();
            $.ajax({
                url: "loadCSV.php",
                param: id,
                success: function(msgg){
                    $("#summernote").html(msgg);    }});

        });

    </script>-->
    </div>
</div>
</div><br>


   <!-- <input form="eemail" type="submit" class="btn btn-primary mb-2" value="Odoslať" name="submit2">
    <input  type="submit" class="btn btn-primary mb-2" value="Odoslať" name="submit3" >-->


<script>
    $('#summernote').summernote({
        placeholder: 'Hello',
        tabsize: 2,
        height: 200
    });
</script>

<div id="results" style="display: none"></div><br>
<script>
    $.ajax({url: "databaseLog.php"}).done(function( msg ) {
        $("#results").html(msg);
    });

</script>

<?php
error_reporting(E_ERROR | E_PARSE);




if(isset($_FILES["subor2"])){
    $HopefullyCSV = $_FILES["subor2"];
    $nazovSuboru1 = $_FILES['subor2']['tmp_name'];
    $oddelovac = ';';
    $data = nacitaj($nazovSuboru1,$oddelovac);
    $idsablony = $_SESSION['IDS'];
    $sablona = nacitajSablonu($_POST['idsablony']);
    $userData[0]=$_POST['usr'];
    $userData[1]=$_POST['mail'];
    $userData[2]=$_POST['pass'];
    $userData[3]=$_POST['subject'];

    $sablona = $_POST['edited'];
    $flag = "plain";
    if($_POST['emailType']=="plain") {
        $flag = "plain";
        $_POST['edited']=$sablona;

        // echo "this is html";
    }else if($_POST['emailType']=="html"){
        $flag = "html";
        if(isset($_POST['edited'])){
            $sablona = $_POST['edited'];
        }


    }
   // echo "<br>sabla:<br>".$sablona."<br><br>";

    /*foreach ($data as $x) {

        var_dump($x);
        $sablonaUpravena = pripravEmail($sablona, $data[0], $x, $userData[0]);
        if (isset($_FILES['attachment']) &&
            $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
            if(odosliEmail((String)$x['email'], $sablonaUpravena, $userData, $flag, $_FILES['attachment']['tmp_name'], $_FILES['attachment']['name'])){
                databaseLog($_POST['idsablony'],$data[0], $x,$userData[3]);
            }
        }else{
            if(odosliEmail((String)$x['email'], $sablonaUpravena, $userData, $flag)){
                databaseLog($_POST['idsablony'],$data[0], $x,$userData[3]);
            }
        }
    }*/


}


if(isset($_POST['edited'])){
    echo "<br><br> got there yea";
    $sablona = $_POST['edited'];

    foreach ($data as $x) {

        var_dump($x);
        $sablonaUpravena = pripravEmail($sablona, $data[0], $x, $userData[0]);
        if (isset($_FILES['attachment']) &&
            $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
            if (odosliEmail((String)$x['email'], $sablonaUpravena, $userData, $flag, $_FILES['attachment']['tmp_name'], $_FILES['attachment']['name'])) {
                databaseLog($idsablony, $data[0], $x, $userData[3]);
            }
        } else {
            echo "<br>xxx";
            if (odosliEmail((String)$x['email'], $sablonaUpravena, $userData, $flag)) {
                databaseLog($idsablony, $data[0], $x, $userData[3]);
                echo "<br>xxx";
            }
        }
    }

}
if(isset($_FILES["subor"])){


    $nazovSuboru1 = $_FILES['subor']['tmp_name'];
    $oddelovac = $_POST['oddelovac'];
    $data = nacitaj($nazovSuboru1,$oddelovac);
    $data = pridajHeslo($data);
    $novySubor = generateRandomString(5);
    $cesta = "csvSHeslami/".$novySubor.".csv";
    saveCSV($data,$cesta);
   echo "<a href='".$cesta ."'>".$lang['Hesla']."</a>";
}



?>


<script src="myscript.js"></script>

</body>
</html>
