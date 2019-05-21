<!doctype html>
<html lang="en">
<head>

</head>
<body>
<br>
<div class="container bg-info" style="position: relative">
    <br>
<h2 class="mt-4">
    <?php
        $meno = $_SESSION["meno"];
        $id = $_SESSION["idcko"];
        $priezvisko = $_SESSION["priezvisko"];

    ?>
    <b><?php echo htmlspecialchars($_SESSION["username"])." ".$lang['EX1MSG']; ?></b>
    <p><?php echo $meno. " ". $priezvisko ?></p>
    <p><?php echo $lang['STUDIDVAIS'].$id ?></p>
</h2>
<a href="uloha1/logout.php" class="btn btn-danger mt-2 pull-right" style="position: absolute; top: 5px; right: 5px;"><?php echo $lang['TEAM_LOGOUT'];?></a>

    <br><br>
<?php
$servername = "localhost";
$username = "eduardom";
$password = "webteXmartinez97";
$dbname = "zavzadanie";
$connect = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    printf("Connection failed: %s\n", mysqli_connect_error());
    exit();
}

$id = $_SESSION["idcko"];

$pom = 0;
$x="SELECT p.Nazov, b.Rok FROM Predmety p INNER JOIN Main b ON p.Id = b.Id_predmet WHERE b.Id_student =$id";
$predmet=$connect->query($x);
$rowcount = mysqli_num_rows($predmet);
$pomocna = $lang['STUDNAMESUB'];
$pomocna2 = $lang['STUDNAMEYR'];
if($predmet->num_rows>0){
    while($rovv = $predmet->fetch_array() ){
        $array[$pom] =  "<h3>". $pomocna .$rovv["Nazov"].$pomocna2.$rovv["Rok"]."</h3><br>";

        $pom++;

    }
}

$y="SELECT Id_predmet FROM Main WHERE Id_student=$id";
$predmet=$connect->query($y);
$index=0;
if ($predmet->num_rows > 0) {
while($rovv = $predmet->fetch_assoc()){

  $abc[$index]=$rovv['Id_predmet'];
  $index++;


}
}
$index--;
while($index>=0) {

    $sql = "SELECT * FROM Main WHERE Id_student=$id AND Id_predmet=" . $abc[$index];
    $result = $connect->query($sql);
    $rowcount2 = mysqli_num_rows($result);

    if ($result->num_rows > 0) {
        echo $array[$index];
        echo "<table class='table'><tr><th >Zapocet</th><th>Skuska_rt</th><th>Skuska_ot</th><th>Bonus</th><th>Spolu</th><th>Znamka</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['Zapocet'] . "</td>";
            echo "<td>" . $row['Skuska_rt'] . "</td>";
            echo "<td>" . $row['Skuska_ot'] . "</td>";
            echo "<td>" . $row['Bonus'] . "</td>";
            echo "<td>" . $row['Spolu'] . "</td>";
            echo "<td>" . $row['Znamka'] . "</td></tr>";

        }
        echo "</table>";
    } else {
        echo "Error: " . $sql . "<br>" . $connect->error;
    }
$index--;
}


?>
    <br>
</div>
</body>
</html>
