<?php
/**
 * Created by PhpStorm.
 * User: Eduardo Martinez
 * Date: 9. 3. 2019
 * Time: 22:19
 */
session_start();
if(isset($_POST['login']) && isset($_POST['password'])) {
    $adServer = "ldap.stuba.sk";

    $dn  = 'ou=People, DC=stuba, DC=sk';
    $log = $_POST['login'];
    $passw = $_POST['password'];
    $ldaprdn  = "uid=$log, $dn";
    $hash_pass=password_hash ($passw , PASSWORD_BCRYPT,  ['cost'=>12] );

    $ldapconn = ldap_connect($adServer);
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    $bind = ldap_bind($ldapconn, $ldaprdn, $passw);
    if ($bind){

        $results=ldap_search($ldapconn,$dn,"uid=$log",array("givenname","sn","mail","cn","uisid","uid"));
        $info=ldap_get_entries($ldapconn,$results);
        $i=0;
        $aisUdaje = array("Meno"=>$info[$i]['givenname'][0],
            "Priezvisko"=>$info[$i]['sn'][0],
            "Používateľské meno"=>$info[$i]['uid'][0],
            "Id"=>$info[$i]['uisid'][0],
            "Email"=>$info[$i]['mail'][0]);

        $name=$info[$i]['givenname'][0];
        $surname=$info[$i]['sn'][0];
        $email=$info[$i]['mail'][0];
        $login=$info[$i]['uid'][0];
        $user_id = $info[$i]['uisid'][0];

        $_SESSION["idcko"] = $user_id;
        $_SESSION["priezvisko"] = $surname;

        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $login;
        $_SESSION["user_id"] = $user_id;
        $_SESSION["type"] = 'student';
        $_SESSION["meno"] = $name;

        echo "teamview.php";
    } else {
        $password_err = "The password you entered was not valid.";
        echo $password_err;
    }
}

?>
