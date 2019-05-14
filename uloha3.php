<?php
session_start();
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


<?php
include 'navbar.php';
//$nazovSuboru = "vystup.csv";

//echo"vysledok";
//echo "<br>";
//var_dump($data);
//echo "ukladanie vystupu";
//echo "<br>";
?>
<div class="container" id="x1">
    <div class="div1">
        <h2>Generovanie hesiel žiakom</h2>

     <form method="post" enctype = "multipart/form-data">
         <div class="form-group">
           <label for="subor">Výber súboru pre ktorý sa majú vygenerovať heslá:   </label>
            <input type="file" name="subor">
             <br>
             <label for="odelovac">Voľba oddelovača</label>
             <input type="text" name="oddelovac">
             <br>
              <input type="submit" class="btn btn-primary mb-2" value="potvrdiť" name="submit">
        </div>
     </form>
    </div>

    <div class="div2">
        <h2>Rozposielanie hesiel mailom</h2>
        <form method="post" enctype = "multipart/form-data">
            <div class="form-group">
                <label for="subor">Výber súboru pre ktorý sa majú rozposlať maily   </label>
                <input type="file" name="subor2">
                <br>
                <input type="submit" class="btn btn-primary mb-2" value="Odoslať" name="submit2">
            </div>
        </form>
    </div>
</div>

<?php
error_reporting(E_ERROR | E_PARSE);

if(isset($_FILES["subor2"])){
    $nazovSuboru1 = $_FILES['subor2']['tmp_name'];
    $oddelovac = ';';
    $data = nacitaj($nazovSuboru1,$oddelovac);
    $sablona = nacitajSablonu(1);

    foreach ($data as $x){
        var_dump($x);
        $sablonaUpravena = pripravEmail($sablona,$data[0],$x);

        odosliEmail( $x['email'],$sablonaUpravena);
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
