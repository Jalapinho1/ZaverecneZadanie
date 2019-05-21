<h2 class="mt-4">
    <b><?php echo htmlspecialchars($_SESSION["username"])." ".$lang['TEAM_MSG']; ?></b>
</h2>
<a href="logout.php" class="btn btn-danger mt-2 mb-5"><?php echo $lang['TEAM_LOGOUT'];?></a>

<?php
include_once "config.php";
$dbname = "zavzadanie";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id =  $_SESSION['user_id'];

$sql0="SELECT team_id,points,schoolyear,subject FROM teams WHERE id LIKE '".$user_id."'";
$result0 = mysqli_query($conn,$sql0);

$team_id = 0;
$pointsPlacer = 0;
while($row0 = mysqli_fetch_array($result0)):
    $team_id = $row0['team_id'];
    $subject = $row0['subject'];
    $year = $row0['schoolyear'];

    if ($team_id != 0) :
        $sql2="SELECT email,name,id,points,accepted,disagreed FROM teams Where team_id LIKE '$team_id' 
                AND subject LIKE '".strval($subject)."' AND schoolyear LIKE '".strval($year)."'";
        $result2 = mysqli_query($conn,$sql2);

        $currentFormID = "pointsForm".$team_id;

        $sql3="SELECT points,adminInput,adminAgreement FROM teamPoints Where team_id LIKE '$team_id'
                AND subject LIKE '".strval($subject)."' AND schoolyear LIKE '".strval($year)."'";
        $result3 = mysqli_query($conn,$sql3);
        $pointsPlacer = 0;
        $input = false;
        $agreed = false;
        $disagreed = false;
        while($row3 = mysqli_fetch_array($result3)) :
            $pointsPlacer = $row3['points'];
            if ($row3['adminInput'] == 1){
                $input = true;
                if ($row3['adminAgreement'] == 1){
                    $agreed = true;
                }else{
                    $disagreed = false;
                }
            }


?>
    <div class='row'>
        <div class="col">
            <h5 class="mb-3" id=""><?php echo $lang['ST_SUBJECT'];?>: <?php echo $subject;?>, <?php echo $lang['ST_YEAR'];?>: <?php echo $year ?></h5>
            <h5 class="mb-3" id=""><?php echo $lang['ADMIN_GROUP']; ?>: <?php echo $team_id ?></h5>
            <h5 class="mb-3"><?php echo $lang['ST_GRPVAL']; ?>: <?php echo $pointsPlacer ?></h5>
            <input type="number" name="points"  id="totalPoints<?php echo $subject.$year ?>"  class="form-control points" value='<?php echo $pointsPlacer?>' hidden>
        </div>
        <?php
        if ($input){
            if ($agreed){
                echo $lang['ST_ADM_AGR'];
            }else if ($disagreed){
                echo $lang['ST_ADM_DSGR'];
            }
        }
        ?>
    </div>
    <div class='row'>
        <table class='table table-bordered table-striped mt-1 table-hover shadow-md p-3 bg-white rounded'>
            <thead>
            <tr>
                <th><?php echo $lang['ADMIN_EMAIL'];?></th>
                <th><?php echo $lang['ADMIN_FULLNAME'];?></th>
                <th><?php echo $lang['ADMIN_POINTS'];?></th>
                <th><?php echo $lang['ST_AGREE_BTN'];?></th>
                <th><?php echo $lang['ST_DAGREE_BTN'];?></th>
            </tr>
            </thead>
            <tbody>
            <?php while($row2 = mysqli_fetch_array($result2)) : ?>
                <tr class="sum">
                    <td><?php echo $row2['email']?></td>
                    <td><?php echo $row2['name']?></td>
                    <td><input class="sumStudentsPoints" data-total="<?php echo $pointsPlacer?>" type="number" id="<?php echo $row2['id']?>" min="0" max="<?php echo $pointsPlacer?>" value="<?php echo $row2['points']?>"
                              <?php
                              $agreed = $row2['accepted'];
                              $disagreed = $row2['disagreed'];
                              if ($agreed == 1 || $disagreed == 1){
                                  $agreed = true;
                              }else{
                                  $agreed = false;
                              }
                              $val = $agreed ?'disabled' : '';

                              echo $val;
                              if ($user_id != $row2['id']){
                                  $val = 'disabled';
                              }
                              ?>></td>
                    <td ><input class="eval" id='<?php echo $row2['id']?>-true-false-<?php echo $subject?>-<?php echo $year?>' type='image' src='img/tup.png' width='20' height='20'
                        <?php echo $val;?>></td>
                    <td ><input class="eval" id='<?php echo $row2['id']?>-true-false-<?php echo $subject?>-<?php echo $year?>' type='image' src='img/tdown.png' width='20' height='20'
                        <?php echo $val;?>></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <button class="btn btn-light mb-5 " type="button" id="save" name="save" onclick="saveValues()"><?php echo $lang['ST_SAVE_BTN'];?></button>
    </div>
<?php endwhile;
    endif;
endwhile;
mysqli_close($conn);
?>


