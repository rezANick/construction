<?php
    require("cx.php");	
		require("function.php");
		$today=date("Y-m-d H:i:s");
	

        $db=Database::connect();
        $req_affiche=$db->query("SELECT * FROM vente ORDER BY id_vente DESC LIMIT 1 ");
        $row=$req_affiche->fetch();
        $lastid_vente=$row["id_vente"];
        if (isset($_GET["detail"])) {
           $detail=$_GET["detail"];
        }else{
           $detail=$lastid_vente; 
        }

?>






<!DOCTYPE html>
<html lang="en">
<head>

    <title>rezABuild | ventes</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link href="http://fonts.googleapis.com/css?family=Crete+Round" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Kelly+Slab" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="styles.css">
    
</head>
<body>
<body data-spy="scroll" data-target=".navbar" data-offset="60">
	<header class="header-fixed">
		<nav class="navbar navbar-default navbar-fixed-top" id="menu">
				<div class="container">
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#monmenu">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>

							</button>
							<h1 id="monlogo">rezA<span id="orange">Build</span></h1>
							<a href="admin/index.php"><p class="connexion">connexion</p></a>
							<!--<img src="img/logo.png" class="img-cirle img-responsive logo" id="monlogo">-->
						</div>
						<div class="collapse navbar-collapse" id="monmenu">
							<ul class="nav navbar-nav navbar-right">
								<li><a href="index.php">accueil</a></li>
								<li class="active"><a href="vente.php">Ventes</a></li>
								
									
							
							</ul>
							
						</div>
					</div>
				</div>
		</nav>		
	</header>
	

    <div class="container-fluid" id="envente">
        <div class=" col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top:50px;">
        <?php
                    $db=Database::connect();
                    $req_affiche=$db->query("SELECT * FROM vente WHERE id_vente=$detail ORDER BY id_vente DESC LIMIT 3 ");
                    $row=$req_affiche->fetch();
                    $id_vente_pp=$row["id_vente"];
                    $titre_vente_pp=$row["titre_vente"];
                    $date_vente_pp=$row["date_vente"];
                    $description_vente_pp=$row["description_vente"];
                    $photo_vente_pp=$row["photo_vente"];
        ?>  
            <h2><?php echo $titre_vente_pp; ?><span class=" pull-right" style=" font-size:14px; margin-top:15px;"><span class="glyphicon glyphicon-calendar"></span> Depuis le <?php echo dcomplete($date_vente_pp) ; ?></span></h2>
            <img src="img/vente/<?php echo $photo_vente_pp; ?>" class="img-responsive thumbnail" style="width: 100%; ">
            <p><?php echo $description_vente_pp; ?></p>

        </div>


        <div class=" col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top:113px;">

        <?php
                    $db=Database::connect();
                    $req_affiche=$db->query("SELECT * FROM vente WHERE id_vente!=$detail ORDER BY id_vente DESC ");
                    while ($row=$req_affiche->fetch()){
                    $id_vente=$row["id_vente"];
                    $titre_vente=$row["titre_vente"];
                    $date_vente=$row["date_vente"];
                    $description_vente=$row["description_vente"];
                    $photo_vente=$row["photo_vente"];
        ?>
        <div class="col-md-6 ">
							<div class="col-md-6">
								<img src="img/vente/<?php echo $photo_vente; ?>" class="img-responsive thumbnail" style="width: 100%; height: 100px;">
							</div>
							<div class="col-md-6">
								<p><span class=" glyphicon glyphicon-calendar"></span> <?php echo dcomplete3($date_vente); ?></p>
								<p><?php echo $titre_vente; ?></p>
								<p><a href="vente.php?detail=<?php echo $id_vente; ?>">détail ...</a></p>
							</div>
						</div>
				<?php } ?>
        </div>		
    </div>
	
	<!-- DEBUT FOOTER-->
	<footer id="contact">
		<div><a href="#accueil"><span class="glyphicon glyphicon-menu-up fleche"></span></a></div>
		<div class="container">
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<h2>Newsletter</h2>
              <p>Soucrivez à notre Newsletter afin de rester informé sur toutes nos expéditions!</p>
	              <form>
						<div class="form-group">
						<input type="text" name="rechercher" class="form-control" placeholder="Votre email...">
						<button type="submit" class="btn btn-default" id="boutton-rech">s'inscrire</button>
						</div>
				  </form>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="text-align: left;" id="reseaux">
				<h4 style=" margin-left: 90px; margin-top: 25px;"><span class="glyphicon glyphicon-phone text-primary"></span> Contact : +225 49 02 52 03</h4>
				<h4 style=" margin-left: 90px;"><span class="glyphicon glyphicon-envelope text-success"></span> Email : azerberenick@hotmail.fr</h4>
				<a href=""><div class="social-media" id="facebook"></div></a>
				<a href=""><div class="social-media" id="twitter"></div></a>
				<a href=""><div class="social-media" id="youtube"></div></a>
				<a href=""><div class="social-media" id="insta"></div></a>
              
	              
            </div>
            <hr style="width: 400px; margin-top: 160px; margin-bottom: 20px; font-weight: bold;">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="color: white;">
				<span>2019 © rezABuild. TOUS droits réservés.</span>
			</div>
			

		</div> 
	</footer>
	<!--FIN FOOTER-->

    <script src="bootstrap/js/jquery.min.js"></script>	
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>