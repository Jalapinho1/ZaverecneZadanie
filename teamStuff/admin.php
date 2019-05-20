<h2 class="mt-4">
    <b><?php echo htmlspecialchars($_SESSION["username"])." ".$lang['TEAM_MSG']; ?></b>
</h2>
<a href="logout.php" class="btn btn-danger mt-2"><?php echo $lang['TEAM_LOGOUT'];?></a><br>
<a href="teamStuff/showGroups.php" class="btn btn-primary mt-2"><?php echo $lang['B_SHOW/HIDE'];?></a><br>
<a href="teamStuff/exportCSV.php" class="btn btn-primary mt-2"><?php echo $lang['B_EXPORT'];?></a>

<form class="w-75 p-3 mb-5 mt-5 mx-auto shadow p-3 mb-5 bg-white rounded" action="teamStuff/dbimport.php" method="post" style="background-color: rgba(0,0,0,.05) !important;"   name="uploadCSV" enctype="multipart/form-data">
    <h5 class="mb-3 text-center"><?php echo $lang['FORM_ADMIN_HEADER'];?></h5>
    <div class="form-row">
        <div class="form-group col">
            <label for="schoolyear"><?php echo $lang['FORM_YEAR'];?></label>
            <select  class="custom-select mr-sm-2" name="schoolyear" size="1" required>
                <option value="2018/2019" selected>2018/2019</option>
                <option value="2017/2018">2017/2018</option>
                <option value="2016/2017">2016/2017</option>
                <option value="2015/2016">2015/2016</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <input type="text" name="subjectname" class="form-control" placeholder="<?php echo $lang['FORM_SUBJECT'];?>" maxlength="10" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <label for="file"><?php echo $lang['FORM_FILE_LABEL'];?></label>
            <input type="file" class="form-control-file" id="file" name="file" accept=".csv">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <input type="text" name="separator" class="form-control" maxlength="1"
                   placeholder="<?php echo $lang['FORM_FILE_SEPARATOR'];?>" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <button type="submit" id="submit" name="submit" class="btn btn-primary"><?php echo $lang['FORM_DBIMPORT'];?></button>
        </div>
    </div>
</form>
<div id="success"  class="mx-auto text-danger" style="width: 300px;" ></div>
