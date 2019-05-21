


<h2 class="mt-4">
    <b><?php echo htmlspecialchars($_SESSION["username"])." ".$lang['TEAM_MSG']; ?></b>
</h2>
<a href="uloha1/logout.php" class="btn btn-danger mt-2"><?php echo $lang['TEAM_LOGOUT'];?></a>

<form class="w-75 p-3 mb-5 mt-5 mx-auto shadow p-3 mb-5 bg-white rounded" id="uploadForm" action="./teamview1.php" style="background-color: rgba(0,0,0,.05) !important;" method="POST" enctype="multipart/form-data">
    <h5 class="mb-3 text-center"><?php echo $lang['FORM_ADMIN_HEADER'];?></h5>
    <div class="form-row">
        <div class="form-group col">
            <input type="text" name="subject" id="subject" class="form-control" placeholder="<?php echo $lang['FORM_SUBJECT'];?>" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <?php echo $lang['FORM_SCHOOL_YEAR'];?>
            <select name="year" id="year" class="form-control" required>
                <?php
                $initialYear = 2012;
                $currentYear = date('Y');

                for ($i=$initialYear;$i <= $currentYear+1 ;$i++)
                {
                    $checked = ($i == $currentYear ? "selected" : "");

                    echo '<option value="'.$i.'" '.$checked.'>'.$i.'</option>';

                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <label for="csvfile"><?php echo $lang['FORM_FILE_LABEL'];?></label>
            <input type="file" class="form-control-file" id="csvInput" name="csvInput" accept=".csv">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col">
            <input type="text" name="delimiter" id="delimiter" class="form-control" maxlength="1"  placeholder="<?php echo $lang['FORM_FILE_SEPARATOR'];?>" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <button type="submit" class="btn btn-primary"  name="uploadFile" id="uploadFile""><?php echo $lang['FORM_DBIMPORT'];?></button>

        </div>
    </div>
</form>


<div id="success"  class="mx-auto text-danger" style="width: 300px;" ></div>




