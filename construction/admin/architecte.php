<?php
session_start();
require ("../function.php");
require ("../cx.php");


if (isset($_SESSION["id_user"])){
    $id_user=$_SESSION["id_user"];
    $nom_user=$_SESSION["nom_user"];
    $email_user=$_SESSION["email_user"];
    $mdp_user=$_SESSION["mdp_user"];
    $privilege_user=$_SESSION["privilege_user"];

    $photo_user=$_SESSION["photo_user"];
    $contact_user=$_SESSION["contact_user"];
    $etat_user=$_SESSION["etat_user"];

}else{
    header("location: index.php");
}



if (isset($_GET["detail"])) {
    $detail=$_GET["detail"];
}



    if (isset($_POST["submit"]) and $_POST["submit"]=="enregistrer") {
            $nom_user = verifyimput($_POST["nom_user"]);
            $contact_user = verifyimput($_POST["contact_user"]);
            $email_user = verifyimput($_POST["email_user"]);
            $image = "logo.png";
           
            
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
    <title>rezABuild | Accueil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
    <link href="http://fonts.googleapis.com/css?family=Crete+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kelly+Slab" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body style="background='white;'">
<header class="header-fixed">

    <nav class="navbar navbar-inverse navbar-fixed-top" id="menu" style="margin-bottom:130px;">
        <div class="container">
            <div class="container">
                
        
                    <a href="index.php"><h1 class="monlogo" style="text-align: center;">rezA<span id="bleu">Build</span></h1></a>
               
            </div>
        </div>
    </nav>
</header>
<div class="container-fluid" style="margin-top:80px;">
        <?php require ("menu.php"); ?>
    <div class=" col-md-10">
        <div class="col-md-12">
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <div class="col-md-12">
                <h3 class="text-uppercase">Liste des architectes</h3>  
                </div>
                
                  	<a class="btn btn-primary btn-xs pull-right" href="javascript:;" data-toggle="modal" data-target="#monmodal3" style="margin-bottom:5px;">
                          nouvel architecte
                    </a>
                  	<div class="modal fade" id="monmodal3">
                  		<div class="modal-dialog modal-sm">
                  			<div class="modal-content">
                  				<div class="modal-header">
                  					<h4 class="modal-title">Enregistrer un nouvel architecte</h4>
                  				</div>
                  				<form action="architecte.php" method="post" enctype="multipart/form-data">
                  				<div class="modal-body">
                  					<div class="form-group">
                  						<label for="nom">Nom et Prénom : </label>
										<input type="text" name="nom_user" class="form-control" id="nom">
									</div>
									<div class="form-group">
										<label for="personne">email:</label>
										<input type="email" name="email_user" class="form-control" id="personne">
									</div>
									<div class="form-group">
										<label for="contact">Contact:</label>
										<input type="text" name="contact_user" class="form-control" id="contact">
                                    </div>
                                                                        
                                    
                  				</div>
                  				<div class="modal-footer" style="text-align: center;">
										<button type="submit" name="submit" value="enregistrer" class="btn btn-primary btn-xs" >enregistrer</button>
										<button type="submit" class="btn btn-danger btn-xs" data-dismiss="modal">annuler</button>
                  					
                  				</div>
                  				</form>
                  			</div>
                  		</div>
                  	</div>
                  
                <table class="table table-bordered table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th>Nom </th>
                            <th>Contact</th>
                            <th>Etat </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $db=Database::connect();
                    $req_affiche=$db->query("SELECT * FROM user WHERE privilege_user='architecte' ");
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
                    $id_detail=$row["id_user"];
                    $nom_detail=$row["nom_user"];
                    $contact_detail=$row["contact_user"];
                    $email_detail=$row["email_user"];
                    $photo_detail=$row["photo_user"];
                    $etat_detail=$row["etat_user"];
                    $date_detail=$row["date_user"];
                    
                    ?>

<div class="col-md-12 tab-style-1">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-1" data-toggle="tab">Infos personnelles</a></li>
              <li><a href="#tab-2" data-toggle="tab"><span class="glyphicon glyphicon-envelope"></span>&nbsp;	Activités</a></li>
              <?php if ($etat_detail==1) { ?>

                <li><a href="#tab-3" data-toggle="tab">En cours</a></li>

              <?php } ?>    
              
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane row fade in active" id="tab-1">
                  <div class="col-md-4 col-md-offset-4" style="margin-top:5px;s">
                      <img class="img-responsive thumbnail" src="../img/logo.png" alt="">
                  </div>
                  <div class="col-md-6" style="font-size:17px;">
                      <span class="glyphicon glyphicon-user"></span> &nbsp; <?php echo $nom_detail ?> <br>
                      <span class="glyphicon glyphicon-phone"></span> &nbsp; <?php echo $contact_detail ?> 
                  </div>

                  <div class="col-md-6" style="font-size:17px;">
                      <span class="glyphicon glyphicon-envelope"></span> &nbsp; <?php echo $email_detail ?> <br>
                      <span class="glyphicon glyphicon-calendar"></span> &nbsp; <?php echo dcomplete2($date_detail) ?> 
                  </div>
                  <div class="col-md-12" style="text-align:center; margin-top:10px;" >
                  <?php if ($etat_detail==0) {?>
                                    <button class="btn btn-success btn-xs" style="padding:3px 50px;">
                                    disponible
                                </button>
                            <?php }elseif($etat_detail==1) { ?>
                                <button class="btn btn-danger btn-xs" style="padding:3px 50px;">
                                    indisponible
                                </button>
                           <?php } ?>
                  </div>
                  
              </div>

              <div class="tab-pane row fade" id="tab-2">
                    <table class="table table-bordered table-responsive">
                      <thead>
                          <tr>
                              <th> date</th>
                              <th> Type de projet</th>
                              <th> Client</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php 
                            $req_liste=$db->query("SELECT com.id_commande, com.type_commande, com.id_type_commande, com.id_client, com.id_user, com.date_commande, com.etat_commande,
                            cl.id_client, cl.nom_client, cl.email_client, cl.contact_client
                             
                            FROM commande com
                            INNER JOIN client cl
                            ON com.id_client=cl.id_client
                            WHERE com.id_user='$id_user' AND com.etat_commande='2' ");

                            while ($row=$req_liste->fetch()){ 

                            $id_commande=$row["id_commande"];
                            $type_commande=$row["type_commande"];
                            $id_type_commande=$row["id_type_commande"];
                            $date_de_commande=$row["date_commande"];
                            list($date_commande,$heure_commande) = explode(" ",$date_de_commande);
                            $etat_commande=$row["etat_commande"];

                            $id_client=$row["id_client"];
                            $nom_client=$row["nom_client"];
                            $email_client=$row["email_client"];
                            $contact_client=$row["contact_client"];
                          ?>
                          <tr>
                          <td>
                                <a href="?detail=<?php echo dcomplete3($date_commande); ?>" alt="voir les détails">
                                <?php echo dcomplete3($date_commande)?> &nbsp;<span style="font-size:12px;"> à</span> &nbsp; <?php echo $heure_commande ; ?>
                            </a>
                            </td>
                            <td><?php echo $type_commande; ?></td>
                             
                            <td>
                                <?php echo $nom_client; ?>
                            </td>
                          </tr>
                          <?php } ?>
                      </tbody>
                  </table>
              </div>
              <div class="tab-pane fade" id="tab-3">
              <table class="table table-bordered table-responsive">
                      <thead>
                          <tr>
                              <th> date</th>
                              <th> Type de projet</th>
                              <th> Client</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php 
                            $req_liste_cours=$db->query("SELECT com.id_commande, com.type_commande, com.id_type_commande, com.id_client, com.id_user, com.date_commande, com.etat_commande,
                            cl.id_client, cl.nom_client, cl.email_client, cl.contact_client
                             
                            FROM commande com
                            INNER JOIN client cl
                            ON com.id_client=cl.id_client
                            WHERE com.id_user='$id_user' AND com.etat_commande='1' ");

                            while ($row_cours=$req_liste_cours->fetch()){ 

                            $id_commande_cours=$row_cours["id_commande"];
                            $type_commande_cours=$row_cours["type_commande"];
                            $id_type_commande_cours=$row_cours["id_type_commande"];
                            $date_de_commande_cours=$row_cours["date_commande"];
                            list($date_commande_cours,$heure_commande_cours) = explode(" ",$date_de_commande_cours);
                            $etat_commande_cours=$row_cours["etat_commande"];

                            $id_client_cours=$row_cours["id_client"];
                            $nom_client_cours=$row_cours["nom_client"];
                            $email_client_cours=$row_cours["email_client"];
                            $contact_client_cours=$row_cours["contact_client"];
                          ?>
                          <tr>
                          <td>
                                <a href="" alt="voir les détails">
                                <?php echo dcomplete3($date_commande_cours)?> &nbsp;<span style="font-size:12px;"> à</span> &nbsp; <?php echo $heure_commande_cours ; ?>
                            </a>
                            </td>
                            <td><?php echo $type_commande_cours; ?></td>
                             
                            <td>
                                <?php echo $nom_client_cours; ?>
                            </td>
                          </tr>
                          <?php } ?>
                      </tbody>
                  </table>
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