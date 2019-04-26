<?php
/**
 * Created by PhpStorm.
 * User: Reza Opias
 * Date: 25/02/2019
 * Time: 20:51
 */
session_start();
require ("../function.php");
require ("../cx.php");
$messagerreur="";
if (isset($_POST["submit"]) and $_POST["submit"]=="envoi" ) {
    echo $email_user = verifyimput($_POST["email_user"]);
    echo $mdp_user = verifyimput($_POST["mdp_user"]);

    $db=Database::connect();
    $req_verify=$db->query("SELECT * FROM user WHERE email_user='$email_user' AND mdp_user='$mdp_user' " );
    $row=$req_verify->fetch();
    if (empty($row)){
        $messagerreur="Mot de passe ou email incorrect";
    }else{
        $_SESSION["id_user"]=$row["id_user"];
        $_SESSION["nom_user"]=$row["nom_user"];
        $_SESSION["email_user"]=$row["email_user"];
        $_SESSION["mdp_user"]=$row["mdp_user"];
        $_SESSION["photo_user"]=$row["photo_user"];
        $_SESSION["contact_user"]=$row["contact_user"];
        $_SESSION["privilege_user"]=$row["privilege_user"];
        $_SESSION["etat_user"]=$row["etat_user"];

     header("location:commande.php");
    }
    $db=Database::disconnect();
    
/**/

}
?>

<!DOCTYPE html>
<html>
<head>
	<title>rezABuild | Accueil</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">-->
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
	<link href="http://fonts.googleapis.com/css?family=Crete+Round" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Kelly+Slab" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body data-target=".navbar" data-offset="60">
    <?php //require ("header.php") ?>
    <div class="container" >
        <div class="col-md-12" id="text1" style="color:#31708f;">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3">
                <h1>rezABuild</h1>
                <p>Bâtissez vos rêves avec assurance</p>
                <span><hr></span>
            </div>
        </div>
        <?php
            if (isset($_GET["register"]) and $_GET["register"]=="success"){ ?>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-lg-offset-4 succes">
                    <span class="glyphicon glyphicon-check" style="margin-right: 5px;"></span> Vous avez été enregistré avec succes
                    <br> connectez vous avec vos paramètres.
                </div>
            <?php }

        /*function digitSum($n) {
            $nbre=explode("",$n);
            $result=0;
            foreach ($nbre as $element){
                $result+=$element;
            }
            return $result;
        }

        echo $nbre=digitSum(12);*/


        ?>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-lg-offset-4" id="corps">
            <div><h4>Connectez-vous</h4></div>
                <form action="index.php" method="post" role="form">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control input-sm form-control-sm " name="email_user" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="montant">Mot de passe</label>
                        <input type="password" class="form-control input-sm form-control-sm " name="mdp_user" id="montant_envoi" required>
                    </div>
                    <p class="erreur"><?php echo $messagerreur; ?></p>
                    <button type="submit" name="submit" value="envoi" class="btn btn-primary btn-xs" id="send">connexion</button>
                </form>


        <div class="row" id="textform">
        <p>Vous n'avez pas de compte veuillez contacter l'administrateur. </p>
        </div>
        </div>
    </div>
    <?php
       // require ("footer.php");
    ?>

    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

    <script src="../bootstrap/js/jquery.min.js"></script>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>