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
    <!--   <link rel="stylesheet" type="text/css" href="styles.css">-->
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
    <script src="HtmlEditor.js"></script>
</head>
<body onLoad="iFrame()">


<?php
include 'navbar.php';
//$nazovSuboru = "vystup.csv";

//echo"vysledok";
//echo "<br>";
//var_dump($data);
//echo "ukladanie vystupu";
//echo "<br>";
?>
<div class="container-fluid">
    <div class="row">
    <div class="col-sm tab1">
        <h2><?php echo $lang['Header1']; ?></h2>

     <form method="post" enctype = "multipart/form-data">
         <div class="form-group">
           <label for="subor"><?php echo $lang['Label1']; ?></label>
            <input type="file"  name="subor" >
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
        <form method="post" enctype = "multipart/form-data">
            <div class="form-group">
                <label for="subor"><?php echo $lang['Label2']; ?></label>
                <input type="file" name="subor2" value="skuska">
                <br>
                <input type="text" name="usr" placeholder="<?php echo $lang['PlaceHolder1']; ?>">
                <input type="email" name="mail" placeholder="<?php echo $lang['PlaceHolder2']; ?>">
                <input type="password" name="pass" placeholder="<?php echo $lang['PlaceHolder3']; ?>"><br>
                <input type="text" name="subject" placeholder="<?php echo $lang['PlaceHolder4']; ?>"><br><br>
                <label>Attachment (optional)</label><br>
                <input type="file" name="attachment"><br><br><br>

                <div id="textEditor">

                        <input type="button" id="bold" value="B" onclick="boldtt()">
                        <input type="button" id="italic" value="I" onclick="italictt()">
                        <input type="button" id="underline" value="U" onclick="underlinett()">
                        <input type="button" id="fs" value="<?php echo $lang['Font']; ?>" onclick="fontsizett()">
                        <input type="button" id="fc" value="<?php echo $lang['Farba']; ?>" onclick="fontcolortt()">
                        <input type="button" id="highlight" value="<?php echo $lang['Farba']; ?>" onclick="highlighttt()">


<br><br>
                        <textarea id="textarea" name = "textarea" style="display: none;"></textarea>
                        <iframe id="editor" name="editor" style="width: 500px; height: 400px;"></iframe>

                    <br><br>


                <input type="submit" class="btn btn-primary mb-2" value="<?php echo $lang['Odoslanie']; ?>" name="submit2">
                <input type="radio" name="emailType" value="plain" checked> <?php echo $lang['Text1']; ?>
                <input type="radio" name="emailType" value="html"> <?php echo $lang['Text2']; ?><br>

                    <button onclick="show()" ><?php echo $lang['Tabulka']; ?></button>
                    <div id="results" style="display: none"></div>
            </div>
        </form>
    </div>
    </div>
</div>


<script>
    $.ajax({url: "databaseLog.php"}).done(function( msg ) {
        $("#results").html(msg);
    });
</script>

<?php
error_reporting(E_ERROR | E_PARSE);

if(isset($_FILES["subor2"])){
    $nazovSuboru1 = $_FILES['subor2']['tmp_name'];
    $oddelovac = ';';
    $data = nacitaj($nazovSuboru1,$oddelovac);
    $sablona = nacitajSablonu(2);
    $userData[0]=$_POST['usr'];
    $userData[1]=$_POST['mail'];
    $userData[2]=$_POST['pass'];
    $userData[3]=$_POST['subject'];


    $flag = "plain";
    if($_POST['emailType']=="plain") {
        $flag = "plain";
        // echo "this is html";
    }else if($_POST['emailType']=="html"){
        $flag = "html";
        //echo "this is plain text";
    }


    foreach ($data as $x) {
        var_dump($x);
        $sablonaUpravena = pripravEmail($sablona, $data[0], $x, $userData[0]);
        if (isset($_FILES['attachment']) &&
            $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
            if(odosliEmail((String)$x['email'], $sablonaUpravena, $userData, $flag, $_FILES['attachment']['tmp_name'], $_FILES['attachment']['name'])){
                databaseLog(2,$data[0], $x,$userData[3]);
            }
        }else{
            if(odosliEmail((String)$x['email'], $sablonaUpravena, $userData, $flag)){
                databaseLog(2,$data[0], $x,$userData[3]);
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
   echo "<a href='".$cesta ."'>vystup s heslom</a>";
}

?>


<script src="myscript.js"></script>

</body>
</html>
