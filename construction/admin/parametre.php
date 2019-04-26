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

}else{
    header("location: index.php");
}

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST["inscription"])) {
        $nom_user = verifyimput($_POST["nom_user"]);
        $contact_user = verifyimput($_POST["contact_user"]);
        $email_user = verifyimput($_POST["email_user"]);
        $mdp_user = verifyimput($_POST["mdp_user"]);
        //$image = verifyimput($_POST["image"]);
        $image= verifyimput($_FILES['image']['name']);
        $imagepath="../img/profil/".basename($image);
        $imageExt=pathinfo($imagepath, PATHINFO_EXTENSION);
        $isuploadsuccess=FALSE;
        $issuccess=TRUE;

        if (empty($nom_user)){
            $nomerreur="Veuillez entrer votre nom svp";
            $issuccess=FALSE;
        }else{
            $nomerreur="";
        }

        if (empty($prenom_user)){
            $prenomerreur="Veuillez entrez votre prenom";
            $issuccess=FALSE;
        }else{
            $prenomerreur="";
        }

        if (empty($email_user)){
            $emailerreur="Veuillez entrer votre email";
            $issuccess=FALSE;
        }else{
            $emailerreur="";
        }

        if (empty($contact_user)){
            $contacterreur="Veuillez entrer votre contact";
            $issuccess=FALSE;
        }else{
            $contacterreur="";
        }

        if (empty($mdp_user)){
            $mdperreur="Veuillez entrer votre mot de passe";
            $issuccess=FALSE;
        }else{
            $mdperreur="";
        }


        if (empty($image)){
            $imagerror="";
        }else{
            $isuploadsuccess=TRUE;
            if ($imageExt!="jpg" && $imageExt!="png" && $imageExt!="jpeg" && $imageExt!="gif"){
                $imagerror="Les fichiers autorisés sont: .jpg, .png, .jpeg, .gif";
                $isuploadsuccess=FALSE;
            }
            if (file_exists($imagepath)){
                $imagerror="Le fichier existe déjà";
                $isuploadsuccess=FALSE;
            }
            if ($_FILES["image"]["size"]>500000){
                $imagerror="Le fichier ne doit pas dépasser 500KB";
                $isuploadsuccess=FALSE;
            }
            if ($isuploadsuccess){
                if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagepath)){
                    $imagerror="Il y'a eu une erreur lors de l'upload";
                    $isuploadsuccess=FALSE;
                }
            }
        }
        if ( $isuploadsuccess){

            $_SESSION["id_user"]=$id_user;
            $_SESSION["nom_user"]=$nom_user;
            $_SESSION["email_user"]=$email_user;
            $_SESSION["mdp_user"]=$mdp_user;
            $_SESSION["photo_user"]=$image;
            $_SESSION["contact_user"]=$contact_user;

            $db=Database::connect();
            $req_enreg=$db->exec("UPDATE user 
SET nom_user='$nom_user', email_user='$email_user', mdp_user='$mdp_user', photo_user='$image', contact_user='$contact_user'
WHERE id_user='$id_user'");

            //$req_enreg->execute(array($nom_user,$prenom_user,$email_user,$mdp_user,$image,$contact_user));

            $db=Database::disconnect();
            header("location: commande.php");
        }

        }

}else{
    //$nom_user=$prenom_user=$email_user=$contact_user=$mdp_user=$mdp_confirm=$num_rezasika="";
    $nomerreur=$prenomerreur=$emailerreur=$contacterreur=$mdperreur=$mdpconfirmerreur=$imagerror=$image="";
}


if ($_SERVER["REQUEST_METHOD"]=="GET") {
    if (isset($_GET["pays"])) {
        $pays_envoi = verifyimput($_GET["pays"]);
        $montant_envoi = verifyimput($_GET["montant"]);
        $devise_envoi = verifyimput($_GET["devise1"]);
        $devise_recep = verifyimput($_GET["devise2"]);
        $frais=($montant_envoi*2.5)/100;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>rezASika | paramètre</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
    <link href="http://fonts.googleapis.com/css?family=Crete+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kelly+Slab" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body background=" #D6D6D6;">
<header class="header-fixed">

    <nav class="navbar navbar-inverse navbar-fixed-top" id="menu" style="margin-bottom:130px;">
        <div class="container">
            <div class="container">
                
        
                    <a href="index.php"><h1 class="monlogo" style="text-align: center;">rezA<span id="bleu">Build</span></h1></a>
               
            </div>
        </div>
    </nav>
</header>
<div class="container" id="">
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2" id="suivi">
        <h4>Parametre du compte</h4>
        <form action="parametre.php" method="post" role="form" enctype="multipart/form-data">
            <div class="form-group col-md-6 col-sm-12">
                <label for="montant">Nom <span class="rouge"></span></label>
                <input name="nom_user" type="text" value="<?php echo $nom_user; ?>"
                       class="form-control input-sm form-control-sm input-sm" id="montant">
                <p class="erreur"><?php echo $nomerreur; ?></p>
            </div>
           
            <div class="form-group col-md-6 col-sm-12">
                <label for="email">Email <span class="rouge"></span></label>
                <input name="email_user" type="text" value="<?php echo $email_user; ?>"
                       class="form-control input-sm form-control-sm input-sm" id="email">
                <p class="erreur"><?php echo $emailerreur; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="contact">Contact <span class="rouge"></span></label>
                <input name="contact_user" type="text" value="<?php echo $contact_user; ?>"
                       class="form-control input-sm form-control-sm input-sm" id="contact">
                <p class="erreur"><?php echo $contacterreur; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="mdp">Mot de passe <span class="rouge"></span></label>
                <input name="mdp_user" type="password" value="<?php echo $mdp_user; ?>"
                       class="form-control input-sm form-control-sm input-sm" id="mdp">
                <p class="erreur"><?php echo $mdperreur; ?></p>
            </div>

            <div class="form-group col-md-6 col-sm-12">
                <label for="num_rezasika"><?php if (!empty($photo_user)){ ?>
                    <div class="col-md-4" >
                        <img id="paramphoto" src="../img/profil/<?php echo $photo_user; ?>" alt="">
                    </div>
                        <span style="margin-left: 15px;" class="pull-right"></span>
                    <?php  } ?>  <span class="rouge"></span></label>
                <input name="image" type="file" value=""
                       class="form-control input-sm" id="image">
                <p class="erreur"><?php echo $imagerror; ?></p>
            </div>
            <button type="submit" class="btn btn-primary btn-xs" id="sendform" name="inscription" >enregistrer</button>
        </form>
    </div>
</div>




<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

<script src="bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
