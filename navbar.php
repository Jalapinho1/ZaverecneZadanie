<?php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $actual_link;

$matchFound = ( isset($_GET["lang"]) );
$getvariable = $matchFound ? trim ($_GET["lang"]) : '';

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php"><?php echo $lang['MENU_HOME']; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="uloha1.php"><?php echo $lang['MENU_1']; ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="uloha2.php"><?php echo $lang['MENU_2']; ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="uloha3.php"><?php echo $lang['MENU_3']; ?></a>
            </li>
            <li class=" navbar-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $lang['MENU_Dropdown']; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    if ($getvariable != ''){
                        $actual_link = explode("?",$actual_link);
                    }
                    ?>
                    <a class="dropdown-item" href="<?php echo ($getvariable != '') ? $actual_link[0] : $actual_link;?>?lang=sk">
                        <label class="mr-2"><?php echo $lang['MENU_4']; ?></label>
                        <img src="img/sk.png" width='45px' alt="SK">
                    </a>
                    <a class="dropdown-item" href="<?php echo ($getvariable != '') ? $actual_link[0] : $actual_link;?>?lang=en">
                        <label class="mr-3"><?php echo $lang['MENU_5']; ?></label>
                        <img src="img/uk.jpg" width='45px' alt="EN">
                    </a>
                </div>
            </li>
        </ul>
<!--        <ul class="navbar-nav ml-auto">-->
<!---->
<!--        </ul>-->
<!--        <div class="dropdown dropdown-pull-right btn-group">-->
<!--            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">-->
<!--                Open Dropdown-->
<!--                <span class="caret"></span>-->
<!--            </a>-->
<!--            <ul class="dropdown-menu">-->
<!--                <li>                  <img src="img/sk.png" width='45px' alt="SK"></a>-->
<!--                </li>-->
<!--                <li>Item 2</li>-->
<!--                <li>Item 3</li>-->
<!--            </ul>-->
<!--        </div>-->
    </div>
</nav>
