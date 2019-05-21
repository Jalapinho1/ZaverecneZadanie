<?php
include_once "config.php";
$dbname = "zavzadanie";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql="SELECT team_id,schoolyear,subject FROM teams GROUP BY team_id, schoolyear, subject ORDER BY schoolyear DESC, subject";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result)) :?>
<div class="row">
    <h5><?php echo  $row['subject']?></h5><br>
</div>
<div class="row">
    <h5><?php echo  $row['schoolyear']?></h5>
</div>
<?php
    $tim_ID = $row['team_id'];
    $schoolyear = $row['schoolyear'];
    $subject = $row['subject'];

    $sql2="SELECT email,name,id,points,accepted,disagreed FROM teams Where team_id LIKE '$tim_ID' AND subject LIKE '".strval($subject)."' AND schoolyear LIKE '".strval($schoolyear)."'";
    $result2 = mysqli_query($conn,$sql2);

    $currentFormID = "pointsForm".$tim_ID.substr($schoolyear, -4).$subject;

    $sql3="SELECT points FROM teamPoints Where team_id LIKE '$tim_ID'  AND subject LIKE '".strval($subject)."' AND schoolyear LIKE '".strval($schoolyear)."'";
    $result3 = mysqli_query($conn,$sql3);
    $pointsPlacer = 0;
    while($row3 = mysqli_fetch_array($result3)) {
        $pointsPlacer = $row3['points'];
    }

    $sql4="SELECT adminInput,adminAgreement FROM teamPoints Where team_id LIKE '$tim_ID'  AND subject LIKE '".strval($subject)."' AND schoolyear LIKE '".strval($schoolyear)."'";
    $result4 = mysqli_query($conn,$sql4);

    $input = false;
    $agreed = false;
    $disagreed = false;
    while($row4 = mysqli_fetch_array($result4)) {
        if ($row4['adminInput'] == 1){
            $input = true;
            if ($row4['adminAgreement'] == 1){
                $agreed = true;
            }else{
                $disagreed = false;
            }
        }
    }
?>
<div class='row'>
    <form class="w-50  groupForm" id='<?php echo $currentFormID ?>' name="uploadCSV" enctype="multipart/form-data">
           <div class="form-row">
                <h5 class="mb-3 text-center"><?php echo $lang['ADMIN_GROUP']; ?>: <?php echo $tim_ID ?></h5>
                <input type="hidden"  name="teamID" value='<?php echo $tim_ID ?>'>
                <input type="hidden"  name="subject" value='<?php echo $subject ?>'>
                <input type="hidden"  name="schoolyear" value='<?php echo $schoolyear ?>'>
           </div>
            <div class="form-row">
                <div class="form-group col">
                    <input type="number" name="points" class="form-control points" value='<?php echo $pointsPlacer?>' required>
                </div>
                <div class="form-group col">
                    <button type="submit" name="submit" class="change btn btn-dark" id='<?php echo $currentFormID ?>Submit' name="Change"
                    <?php  if ($input){echo "disabled";}?>><?php echo $lang['ADMIN_CHANGE']; ?></button>
                </div>
            </div>
    </form>
    <div id='<?php echo $currentFormID?>Result' >
        <?php
        if ($input){
            if ($agreed){
                echo $lang['ADMIN_ADM_AGR'] ;
            }else if ($disagreed){
                echo $lang['ADMIN_ADM_DSGR'] ;
            }
        }
        ?>
    </div>
</div>
<div class='row'>
    <table class='table table-bordered table-striped mt-1 table-hover shadow-md p-3 bg-white rounded'>
        <thead>
        <tr>
            <th><?php echo $lang['ADMIN_EMAIL'];?></th>
            <th><?php echo $lang['ADMIN_FULLNAME'];?></th>
            <th><?php echo $lang['ADMIN_POINTS'];?></th>
            <th><?php echo $lang['ADMIN_AGREE_BTN'];?></th>
        </tr>
        </thead>
        <tbody>
        <?php while($row2 = mysqli_fetch_array($result2)) : ?>
        <tr>
            <td><?php echo $row2['email']?></td>
            <td><?php echo $row2['name']?></td>
            <td><?php echo $row2['points']?></td>
            <td>
                <?php
                if ($row2['accepted'] == 1){
                    echo "<input  type='image' src='img/tup.png' width='20' height='20'>";
                }else if ($row2['disagreed'] == 1){
                    echo "<input  type='image' src='img/tdown.png' width='20' height='20'>";
                }else {
                    echo "-";
                }
                ?>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <?php if ($input == false) : ?>
    <button class="btn btn-light mb-5 eval" id='<?php echo $tim_ID?>-true-true-<?php echo $subject?>-<?php echo $schoolyear?>'">I agree</button>
    <button class="btn btn-light mb-5 eval" id='<?php echo $tim_ID?>-false-true-<?php echo $subject?>-<?php echo $schoolyear?>'">I disagree</button>
    <?php endif; ?>
</div>
<?php endwhile;
mysqli_close($conn);
?>

