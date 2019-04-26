<?php
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
        $req_annul=$db->exec("DELETE  FROM user_transfert WHERE id_user='$id_annuler'");
        header("location: notification.php?annuler=success");
    }

}

if (isset($_GET["detail"])) {
    $detail=$_GET["detail"];
}



    if (isset($_POST["submit"]) and $_POST["submit"]=="enregistrer") {
            $nom_user = verifyimput($_POST["nom_user"]);
            $contact_user = verifyimput($_POST["contact_user"]);
            $email_user = verifyimput($_POST["email_user"]);
            //$image = verifyimput($_POST["image"]);
            $image= verifyimput($_FILES["image"]["name"]);
            $imagepath="../img/profil/".basename($image);
            $imageExt=pathinfo($imagepath, PATHINFO_EXTENSION);
            
                $isuploadsuccess=TRUE;
                if ($imageExt!="jpg" && $imageExt!="png" && $imageExt!="jpeg" && $imageExt!="gif"){
                    $imagerror="Les fichiers autorisés sont: .jpg, .png, .jpeg, .gif";
                    $isuploadsuccess=FALSE;
                }
                if (file_exists($imagepath)){
                    $imagerror="Le fichier existe déjà";
                    $isuploadsuccess=FALSE;
                }
                if ($_FILES["image"]["size"]>5000){
                    $imagerror="Le fichier ne doit pas dépasser 500KB";
                    $isuploadsuccess=FALSE;
                }
                if ($isuploadsuccess){
                    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagepath)){
                        $imagerror="Il y'a eu une erreur lors de l'upload";
                        $isuploadsuccess=FALSE;
                    }
                }
            
                $mdp_user="1234";
                $date_user=date("Y-m-d");
                $db=Database::connect();
                $req_verify=$db->query("SELECT * FROM user WHERE email_user='$email_user' AND mdp_user='$mdp_user' " );
                $row=$req_verify->fetch();
                if (!empty($row)){
                    header("location: architecte.php?save=echec");
                $messagerreur="Mot de passe ou email incorrect";
                }else{
                
                
                $req_enreg=$db->prepare("INSERT INTO user(nom_user,email_user,mdp_user,privilege_user,etat_user,contact_user, photo_user, date_user) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $req_enreg->execute(array($nom_user,$email_user,$mdp_user,"architecte","0",$contact_user,$image,$date_user));
                    
                    
                    //mysql_insert_id()
                    
                //$req_enreg->execute(array($nom_user,$prenom_user,$email_user,$mdp_user,$image,$contact_user));

                //header("location: architecte.php?save=success");
                }
            

    }



?>

<!DOCTYPE html>
<html>
<head>
    <title>rezABuild | Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
    <link href="http://fonts.googleapis.com/css?family=Crete+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kelly+Slab" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body background="">

<div class="container-fluid">
    <div class="col-md-2" id="sidemenu">
        <?php require ("menu.php"); ?>
    </div>
    <div class=" col-md-10">
        <div class="col-md-12">
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <div class="col-md-12">
                <h3 class="text-uppercase">Liste des commandes</h3>  
                </div>
                
                  	
                <table class="table table-bordered table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th>date et heure </th>
                            <th>Type de commande</th>
                            <th>Detail </th>
                            <th>Client </th>
                            <th>Etat </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $db=Database::connect();
                    $req_affiche=$db->query("SELECT com.id_commande, com.type_commande, com.id_type_commande, com.id_client, com.id_user, com.date_commande, com.etat_commande,
                                                    cl.id_client, cl.nom_client, cl.email_client, cl.contact_client,
                                                     us.id_user, us.id_user, us.nom_user, us.email_user, us.privilege_user, us.etat_user, us.contact_user, us.photo_user
                                             FROM commande com
                                             INNER JOIN client cl
                                             ON com.id_client=cl.id_client
                                             INNER JOIN user us
                                             ON com.id_user=us.id_user ");

                    
                    while ($row=$req_affiche->fetch()){
                    $id_user=$row["id_user"];
                    $nom_user=$row["nom_user"];
                    $contact_user=$row["contact_user"];
                    $etat_user=$row["etat_user"];
                    ?>
                        <tr class="<?php if (isset($_GET["detail"]) and $_GET["detail"]==$id_user) {echo "active"; } ?> ">
                            <td>
                                <a href="?detail=<?php echo $id_user; ?>" alt="voir les détails"><?php echo $nom_user; ?></a>
                            </td>
                            <td><?php echo $contact_user; ?></td>
                            <td>
                                <?php if ($etat_user==0) {?>
                                    <button class="btn btn-success btn-xs">
                                    disponible
                                </button>
                            <?php }elseif($etat_user==1) { ?>
                                <button class="btn btn-danger btn-xs">
                                    indisponible
                                </button>
                            <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    
                </table>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <?php if (isset($_GET["detail"])) {
                    
                    $db=Database::connect();
                    $req_detail=$db->query("SELECT * FROM user WHERE id_user='$detail' ");
                    $row=$req_detail->fetch();
                    $id_user=$row["id_user"];
                    $nom_user=$row["nom_user"];
                    $contact_user=$row["contact_user"];
                    $email_user=$row["email_user"];
                    $photo_user=$row["photo_user"];
                    $etat_user=$row["etat_user"];
                    $date_user=$row["date_user"];
                    
                    ?>

<div class="col-md-12 tab-style-1">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-1" data-toggle="tab">Infos personnelles</a></li>
              <li><a href="#tab-2" data-toggle="tab"><span class="glyphicon glyphicon-envelope"></span>&nbsp;	Activités</a></li>
              <?php if ($etat_user==1) { ?>

                <li><a href="#tab-3" data-toggle="tab">En cours</a></li>

              <?php } ?>    
              
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane row fade in active" id="tab-1">
                  <div class="col-md-4 col-md-offset-4" style="margin-top:5px;s">
                      <img class="img-responsive thumbnail" src="../img/logo.png" alt="">
                  </div>
                  <div class="col-md-6" style="font-size:17px;">
                      <span class="glyphicon glyphicon-user"></span> &nbsp; <?php echo $nom_user ?> <br>
                      <span class="glyphicon glyphicon-phone"></span> &nbsp; <?php echo $contact_user ?> 
                  </div>

                  <div class="col-md-6" style="font-size:17px;">
                      <span class="glyphicon glyphicon-envelope"></span> &nbsp; <?php echo $email_user ?> <br>
                      <span class="glyphicon glyphicon-calendar"></span> &nbsp; <?php echo dcomplete2($contact_user) ?> 
                  </div>
                  <div class="col-md-12" style="text-align:center; margin-top:10px;" >
                  <?php if ($etat_user==0) {?>
                                    <button class="btn btn-success btn-xs" style="padding:3px 50px;">
                                    disponible
                                </button>
                            <?php }elseif($etat_user==1) { ?>
                                <button class="btn btn-danger btn-xs" style="padding:3px 50px;">
                                    indisponible
                                </button>
                           <?php } ?>
                  </div>
                  
              </div>

              <div class="tab-pane row fade" id="tab-2">
					activités
              </div>
              <div class="tab-pane fade" id="tab-3">
                   En cours
              </div>
              
            </div>
          </div>
                    
               <?php } if (!isset($_GET["detail"])) { ?>
                    
               <?php } ?>
            </div>
        </div>
    </div>
</div>

<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

<script src="../bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>