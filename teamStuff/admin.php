<h2 class="mt-4">
    <b><?php echo htmlspecialchars($_SESSION["username"])." ".$lang['TEAM_MSG']; ?></b>
</h2>
<a href="logout.php" class="btn btn-danger mt-2"><?php echo $lang['TEAM_LOGOUT'];?></a>

<form class="w-75 p-3 mb-5 mt-5 mx-auto shadow p-3 mb-5 bg-white rounded" id="adminInsert" style="background-color: rgba(0,0,0,.05) !important;">
    <h5 class="mb-3 text-center"><?php echo $lang['FORM_ADMIN_HEADER'];?></h5>
    <div class="form-row">
        <div class="form-group col">
            <input type="text" name="schoolyear" class="form-control" placeholder="<?php echo $lang['FORM_NAME'];?>" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <input type="password" name="subjectname" class="form-control" placeholder="<?php echo $lang['FORM_PASSW'];?>" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <label for="csvfile"><?php echo $lang['FORM_FILE_LABEL'];?></label>
            <input type="file" class="form-control-file" id="csvfile" name="csvfile">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <input type="text" name="separator" class="form-control" maxlength="1"
                   pattern="\.*\,\;\.*" placeholder="<?php echo $lang['FORM_FILE_SEPARATOR'];?>" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <button type="button" class="btn btn-primary" onclick="submitForm('dbimport.php')"><?php echo $lang['FORM_DBIMPORT'];?></button>
        </div>
    </div>
</form>
<div id="success"  class="mx-auto text-danger" style="width: 300px;" ></div>