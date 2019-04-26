<?php
/**
 * Created by PhpStorm.
 * User: Reza Opias
 * Date: 26/02/2019
 * Time: 10:36
 */

session_start();
require ("../function.php");
require ("../cx.php");


if (isset($_SESSION["id_user"])){
    $id_user=$_SESSION["id_user"];
    $nom_user=$_SESSION["nom_user"];
    $email_user=$_SESSION["email_user"];
    $mdp_user=$_SESSION["mdp_user"];
    $photo_user=$_SESSION["photo_user"];
    $contact_user=$_SESSION["contact_user"];
    $privilege_user=$_SESSION["privilege_user"];
    $etat_user=$_SESSION["etat_user"];

}else{
    header("location: index.php");
}

if (isset($_POST["annuler"])){
    $id_annuler=$_POST["id_annuler"];
    $num_rezasika=$_POST["num_rezasika"];
    if ($num_rezasika!=$rezasika_user){
        header("location: notification.php?annuler=error");
    }else{
        $db=Database::connect();
        $req_annul=$db->exec("DELETE  FROM operation_transfert WHERE id_operation='$id_annuler'");
        header("location: notification.php?annuler=success");
    }

}

/**/if (isset($_POST["valider"])){
    $code_secret=$_POST["code_secret"];
    $code_entrer=$_POST["code_entrer"];
    $id_valider=$_POST["id_valider"];

        if ($code_secret==$code_entrer){
            $db=Database::connect();
            $req_annul=$db->exec("UPDATE FROM operation_transfert SET etat_operation='1' WHERE id_operation='$id_annuler'");
            $req_account=$db->exec("UPDATE FROM user_transfert SET account_user='$new_montant' WHERE id_user='$id_user");
            header("location: notification.php?valider=success");
        }else{
            header("location: notification.php?valider=error");
        }



}

?>
<!DOCTYPE html>
<html>
<head>
    <title>rezABuild | Accueil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
    <link href="http://fonts.googleapis.com/css?family=Crete+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kelly+Slab" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body background="">

<?php require ("menu.php"); ?>


<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

<script src="bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
