<?php
session_start();
require ("../function.php");
require ("../cx.php");
$today=date("Y-m-d");

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



if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST["submit"])) {
        $titre_vente = verifyimput($_POST["titre_vente"]);
        $description_vente = verifyimput($_POST["description_vente"]);
        //$image = verifyimput($_POST["image"]);
        $image= verifyimput($_FILES['image']['name']);
        $imagepath="../img/vente/".basename($image);
        $imageExt=pathinfo($imagepath, PATHINFO_EXTENSION);
        $isuploadsuccess=FALSE;
        $issuccess=TRUE;

    


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

           
            $db=Database::connect();
            if ( $_POST["submit"]=="enregistrer") {
                $req_enreg=$db->prepare("INSERT INTO vente(titre_vente,date_vente,description_vente,photo_vente) 
                                        VALUES (?, ?, ?, ?)");
                    $req_enreg->execute(array($titre_vente,$today,$description_vente,$image));
                    //header("location: vente.php?save=success");
            }elseif ( $_POST["submit"]=="modifier") {
                $id_modif=$_POST["id_modif"];
                $req_enreg=$db->exec("UPDATE vente 
                SET titre_vente='$titre_vente', description_vente='$description_vente', photo_vente='$image'
                WHERE id_vente='$id_modif'");
            }
            

            //$req_enreg->execute(array($nom_user,$prenom_user,$email_user,$mdp_user,$image,$contact_user));

            $db=Database::disconnect();
            //header("location: vente.php");
        }

        }

}

if (isset($_GET["supprimer"])) {
    $id_vente_sup=$_GET["supprimer"];

    $db=Database::connect();
    $req_supprimer=$db->exec("DELETE FROM vente WHERE id_vente='$id_vente_sup'");
    $db=Database::disconnect();
    header("location: vente.php?suppression=success");
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
<body background="">
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
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
            <div class="col-md-10">
                <h3 class="text-uppercase">Liste des affaires sur la plateforme.</h3>  
            </div>
            <div class="col-md-2">
                    <a class="btn btn-primary btn-xs pull-right" href="javascript:;" data-toggle="modal" data-target="#monmodal3">
                          nouvelle affaire
                    </a>
                  	<div class="modal fade" id="monmodal3">
                  		<div class="modal-dialog modal-sm">
                  			<div class="modal-content">
                  				<div class="modal-header">
                  					<h4 class="modal-title">Enregistrer une nouvelle affaire</h4>
                  				</div>
                  				<form action="vente.php" method="post" role="form" enctype="multipart/form-data">
                  				<div class="modal-body">
                  					<div class="form-group">
                  						<label for="nom">Titre de l'affaire : </label>
										<input type="text" name="titre_vente" class="form-control" id="nom">
									</div>
									<div class="form-group">
										<label for="description_vente">Description:</label>
                                        <textarea rows="" cols="" name="description_vente" class="form-control" id="description_vente">
                                        </textarea>
									</div>
							
                                    <div class="form-group ">
                                    <label for="contact">Ajouter une image:</label>
                                        <input name="image" type="file" value=""
                                        class="form-control input-sm" id="image">
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
            </div>
            
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="paravente">
        <?php
                    $db=Database::connect();
                    $req_affiche=$db->query("SELECT * FROM vente ");
                    while ($row=$req_affiche->fetch()){
                    $id_vente=$row["id_vente"];
                    $titre_vente=$row["titre_vente"];
                    $description_vente=$row["description_vente"];
                    $photo_vente=$row["photo_vente"];
        ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <img src="../img/vente/<?php echo $photo_vente; ?>" class="img-responsive img-rounded" alt="">
                    <h4 class=" text-center"> <?php echo $titre_vente; ?> </h4>
                    <p><?php echo $description_vente; ?></p>
                    <a class="btn btn-danger btn-xs " href="javascript:;" data-toggle="modal" data-target="#monmodal<?php echo $id_vente; ?>">
                                        supprimer
                                    </a>
                                    <div class="modal fade" id="monmodal<?php echo $id_vente; ?>">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" style="text-align:center;">
                                                        Voulez vous vraiment supprimer cette affaire ?
                                                    </h4>
                                                </div>
                                                
                                                <div class="modal-body text-center" >
                                                <a type="submit" class="btn btn-danger btn-sm" data-dismiss="modal" style="margin-right:15px;">
                                                    non
                                                </a>
                                                <a href="vente.php?supprimer=<?php echo $id_vente; ?>" class="btn btn-primary btn-sm">oui</a>
                                                </div>                          
                                            </div>
                                        </div>
                                    </div>
                    <a class="btn btn-primary btn-xs pull-right" href="javascript:;" data-toggle="modal" data-target="#modifmodal<?php echo $id_vente; ?>">
                          modifier
                    </a>
                    <div class="modal fade" id="modifmodal<?php echo $id_vente; ?>">
                  		<div class="modal-dialog modal-sm">
                  			<div class="modal-content">
                  				<div class="modal-header">
                  					<h4 class="modal-title">Modification d'une affaire</h4>
                  				</div>
                  				<form action="vente.php" method="post" role="form" enctype="multipart/form-data">
                  				<div class="modal-body">
                  					<div class="form-group">
                  						<label for="nom">Titre de l'affaire : </label>
										<input type="text" name="titre_vente" class="form-control" id="nom" value="<?php echo $titre_vente; ?>">
									</div>
									<div class="form-group">
										<label for="description_vente">Description:</label>
                                        <textarea rows="" cols="" name="description_vente" class="form-control" id="description_vente">
                                            <?php echo $description_vente; ?>
                                        </textarea>
									</div>
							
                                    <div class="form-group ">
                                    <label for="contact">changer l'image:</label>
                                    <img id="paramphoto" src="../img/vente/<?php echo $photo_vente; ?>" class="img-responsive img-rounded" alt="">
                                        <input name="image" type="file" value=""
                                        class="form-control input-sm" id="image">
                                    </div>
                                                                        
                                    
                  				</div>
                                  <div class="modal-footer" style="text-align: center;">
                                        <input type="text" name="id_modif" class="form-control hidden" value="<?php echo $id_vente; ?>">
										<button type="submit" name="submit" value="modifier" class="btn btn-primary btn-xs" >enregistrer</button>
										<button type="submit" class="btn btn-danger btn-xs" data-dismiss="modal">annuler</button>
                  					
                  				</div>
                  				</form>
                  			</div>
                  		</div>
                  	</div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

<script src="../bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>