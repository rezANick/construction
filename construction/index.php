<?php
    require("cx.php");	
		require("function.php");
		$today=date("Y-m-d H:i:s");
	

	
		if (isset($_POST["submit"])) {
			$nom_client = verifyimput($_POST["nom_client"]);
			$contact_client = verifyimput($_POST["contact_client"]);
			$email_client = verifyimput($_POST["email_client"]);
			
			
			
					$mdp_user="1234";
					$date_user=date("Y-m-d");
					$db=Database::connect();
		
					$req_enreg=$db->prepare("INSERT INTO client(nom_client,email_client,contact_client) 
																	VALUES (?, ?, ?)");
							$req_enreg->execute(array($nom_client,$email_client,$contact_client));

							$last_id_client=$db->lastInsertId();
							$db=Database::disconnect();
				if ($_POST["submit"]=="envoyer_projet") {

						$type_projet = verifyimput($_POST["type_projet"]);
						$type_commande="Réalisation du projet";
						$db=Database::connect();
						$req_enreg=$db->prepare("INSERT INTO projet(type_projet) 
																		 VALUES (?)");
						$req_enreg->execute(array($type_projet));
						$last_id_type=$db->lastInsertId();
						$db=Database::disconnect();
				}elseif ($_POST["submit"]=="envoyer_etude") {

					$type_commande="Etude de terrain";
					$emplacement_terrain = verifyimput($_POST["emplacement_terrain"]);
					$dim_terrain = verifyimput($_POST["dim_terrain"]);
					$cout_fouille = verifyimput($_POST["cout_fouille"]);
					$db=Database::connect();
					$type_projet=
					$req_enreg=$db->prepare("INSERT INTO etude(emplacement_etude,dimension_etude,cout_etude) 
																	 VALUES (?, ?, ?)");
					$req_enreg->execute(array($emplacement_terrain,$dim_terrain,$cout_fouille));
					$last_id_type=$db->lastInsertId();
					$db=Database::disconnect();
				}elseif ($_POST["submit"]=="envoyer_ciment") {

					$type_commande="vente de ciment";
					$localisation_ciment = verifyimput($_POST["localisation_ciment"]);
					$nbre_ciment = verifyimput($_POST["nbre_ciment"]);
					$cout_ciment = verifyimput($_POST["cout_ciment"]);
					$db=Database::connect();
					$req_enreg=$db->prepare("INSERT INTO ciment(nbre_ciment,cout_ciment,localisation_ciment) 
																	 VALUES (?, ?, ?)");
					$req_enreg->execute(array($nbre_ciment,$cout_ciment,$localisation_ciment));
					$last_id_type=$db->lastInsertId();
					$db=Database::disconnect();
				}elseif ($_POST["submit"]=="envoyer_beton") {

					$type_commande="vente de beton";
					$localisation_beton = verifyimput($_POST["localisation_beton"]);
					$qte_beton = verifyimput($_POST["qte_beton"]);
					$cout_beton = verifyimput($_POST["cout_beton"]);
					$db=Database::connect();
					$req_enreg=$db->prepare("INSERT INTO beton(localisation_beton,qte_beton,cout_beton) 
																	 VALUES (?, ?, ?)");
					$req_enreg->execute(array($localisation_beton,$qte_beton,$cout_beton));
					$last_id_type=$db->lastInsertId();
					$db=Database::disconnect();
				}

					$id_user=1;
					$db=Database::connect();
					$req_enreg=$db->prepare("INSERT INTO commande(type_commande,id_type_commande,id_client,id_user,date_commande,etat_commande) 
																	VALUES (?,?,?,?,?,?)");
					$req_enreg->execute(array($type_commande,$last_id_type,$last_id_client,$id_user,$today,0));
					$db=Database::disconnect();

			
			header("location: index.php?save=success");
					
			

}


















?>


















<!DOCTYPE html>
<html lang="en">
<head>

    <title>rezABuild | accueil</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link href="http://fonts.googleapis.com/css?family=Crete+Round" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Kelly+Slab" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="styles.css">

	<script>
		function verif_nbre(champ)
  {
    var chiffres = new RegExp("[0-9]");
    var verif;
    var points = 0;
 
    for(x = 0; x < champ.value.length; x++)
    {
            verif = chiffres.test(champ.value.charAt(x));
        if(champ.value.charAt(x) == "."){points++;}
            if(points > 1){verif = false; points = 1;}
        if(verif == false){champ.value = champ.value.substr(0,x) + champ.value.substr(x+1,champ.value.length-x+1); x--;}
    }
  }


	function calculetude(){
                var prix = Number(document.getElementById("dim_terrain").value);
 
                var quantite = 10000;
 
                var montant_recette = Number(prix * quantite);
                document.getElementById("cout_fouille").value = montant_recette;
            }

						function calculciment(){
                var prix = Number(document.getElementById("nbre_ciment").value);
 
                var quantite = 3000;
 
                var montant_recette = Number(prix * quantite);
                document.getElementById("cout_ciment").value = montant_recette;

            } function calculbeton(){
                var prix = Number(document.getElementById("qte_beton").value);
 
                var quantite = 1000;
 
                var montant_recette = Number(prix * quantite);
                document.getElementById("cout_beton").value = montant_recette;
            } 
 
</script>
	</script>
    
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
								<li class="active"><a href="index.php">accueil</a></li>
								<li><a href="vente.php">Ventes</a></li>
								
									
							
							</ul>
							
						</div>
					</div>
				</div>
		</nav>		
	</header>
	<!------------------------------Fin header------------------------------------------------------->
	<!------------------------------debut slider------------------------------------------------------->
	<div class="container" id="accueil">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div id="moncarousel" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#moncarousel" data-slide-to="0" class="active"></li>
					<li data-target="#moncarousel" data-slide-to="1"></li>
					<li data-target="#moncarousel" data-slide-to="2"></li>
					<li data-target="#moncarousel" data-slide-to="3"></li>
				</ol>
				<div class="carousel-inner" role="listbox">

					<div class="item ">
						<img src="img/affiche/3.jpg" class="defil" style="width: 100%; height:440px;">
						<div class="carousel-caption">
							<h3>Batissez la maison de vos rêves</h3>
						</div>
					</div>
					<div class="item">
						<img src="img/affiche/1.jpg" style="width: 100%; height: 440px;">
						<div class="carousel-caption">
							<h4>Outillé pour mieux vour servir</h4>
						</div>
					</div>
					<div class="item active">
						<img src="img/affiche/fouille2.jpg" style="width: 100%; height: 440px;">
						<div class="carousel-caption">
							<h3>Des machines à la hauteur des tâches.</h3>
						</div>
					</div>
					<div class="item ">
						<img src="img/affiche/2.jpg" style="width: 100%; height: 440px;">
						<div class="carousel-caption">
							<h3>Les meilleurs architectes à votre service  </h3>
						</div>
					</div>
					
				</div>

				<a href="#moncarousel" class="left carousel-control" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
				</a>

				<a href="#moncarousel" class="right carousel-control" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-right"></span>
				</a>
			</div>
		</div>
		
	</div>

	<!------------------------------Fin header------------------------------------------------------->
	<!------------------------------debut presentation------------------------------------------------------->
	

    <div class="container-fluid" id="envente">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
				<div id="lieux">

		<hr style="width: 100px; margin-top: 20px; margin-bottom: -10px; font-weight: bold;">
		<h3 class="text-title text-warning subtitle">Nos services</h3>
		<div class="row mix-block margin-bottom-40">
          <!-- TABS -->
          <div class="col-md-12 tab-style-1">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-1" data-toggle="tab">realisation du projet</a></li>
              <li><a href="#tab-2" data-toggle="tab"><span class="glyphicon glyphicon-envelope"></span>&nbsp;	etude de terrain</a></li>
              <li><a href="#tab-3" data-toggle="tab">sac de cimment</a></li>
              <li><a href="#tab-4" data-toggle="tab">commande de beton</a></li>
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane row fade in active" id="tab-1">
                <div class="col-md-5 col-sm-5">
                  <a href="" title="Cliquer pour voir">
                    <img class="img-responsive" src="img/affiche/7.jpg">
                  </a>
                </div>
                <div class="col-md-7 col-sm-7">
                  <p>Nous vous offrons une analyse complete de qualite de votre projet de construction.</p>
									<p>Faites une demande ci dessous et recevez les meilleurs analysites pour votre projet.</p>

									<div id="projet">
										<form action="index.php" method="post">
										
											<div class="form-group col-md-6">
													<label for="nom">Nom</label>
													<input type="text" class="form-control input-sm form-control-sm " name="nom_client" id="nom" required>
											</div>
											<div class="form-group col-md-6">
													<label for="email">Email</label>
													<input type="email" class="form-control input-sm form-control-sm " name="email_client" id="email" required>
											</div>
											<div class="form-group col-md-6">
													<label for="contact">Contact</label>
													<input type="text" class="form-control input-sm form-control-sm " onkeyup="verif_nbre(this)" name="contact_client" id="contact" required>
											</div>
											<div class="form-group col-md-6">
													<label for="type_projet">Votre projet de construction</label>
													<select name="type_projet" id="type_projet" class="form-control input-sm form-control-sm ">
														<option value="maison_basse_studio">Maison basse studio</option>
														<option value="maison_basse_1pcs">Maison basse 1 piece</option>
														<option value="maison_basse_2pcs">Maison basse 2 piece</option>
														<option value="maison_basse_3pcs">Maison basse 3 piece</option>
														<option value="maison_basse_4pcs">Maison basse 4 piece</option>
														<option value="maison_basse_5pcs">Maison basse 5 piece</option>
														<option value="maison_r+1">Maison R + 1 </option>
														<option value="maison_r+2">Maison R + 2 </option>
														
													</select>
								
											</div>
											<p class="erreur"></p>
											<a href="politique.html" class="col-md-6"><p>Politique de confidentialité</p></a>
											<div class="col-md-12">
											<div class="col-md-1">
												<input type="checkbox" name="" class="form-control col-md-2" id="lu" required>
											</div>
											<div class="col-md-11">
												<label for="lu" style="margin-top:10px; text-align:left"> J'ai lu et j'accepte les termes du contrat.</label>
											</div>
											</div>
											<button type="submit" name="submit" value="envoyer_projet" class="btn btn-primary btn-xs" id="send">envoyer la demande</button>
							
										
										</form>
									</div>
                 
                </div>
              </div>
              <div class="tab-pane row fade" id="tab-2">
							<div class="col-md-7 col-sm-7">
                  <p>Vous avez un terrain et vous voulez faire la fouille !?</p>
									<p>Nous vous proposons nos services de fouille à des prix forfaitaires.</p>

									<div id="projet">
										<form action="index.php" method="post">
										
											<div class="form-group col-md-6">
													<label for="nom">Nom</label>
													<input type="text" class="form-control input-sm form-control-sm " name="nom_client" id="nom" required>
											</div>
											<div class="form-group col-md-6">
													<label for="nom">Email</label>
													<input type="email" class="form-control input-sm form-control-sm " name="email_client" id="nom" required>
											</div>
											<div class="form-group col-md-6">
													<label for="nom">Contact</label>
													<input type="text" class="form-control input-sm form-control-sm " onkeyup="verif_nbre(this)" name="contact_client" id="nom" required>
											</div>
											<div class="form-group col-md-6">
													<label for="nom">Emplacement du terrain</label>
													<input type="text" class="form-control input-sm form-control-sm " name="emplacement_terrain" id="nom" required>
													
								
											</div>
											<p class="erreur"></p>

											<div class="form-group col-md-6">
												<label for="dim_terrain">Dimension du terrain (mètre carré)</label>
												<input type="number" class="form-control input-sm form-control-sm" onkeyup="verif_nbre(this);calculetude()"  name="dim_terrain" id="dim_terrain" required>
											</div>
											<div class="form-group col-md-6">
												<label for="cout_fouille">Coût de la fouille</label>
												<input type="text" id="cout_fouille" class="form-control input-sm form-control-sm " onkeyup="verif_nbre(this); calculetude();"; name="cout_fouille" readonly>
												<p class=" text-danger">* La fouille est facturée à 10 0000F le mètre carré.</p>
											</div>

											<a href="" class="col-md-12"><p>Politique de confidentialité</p></a>
											<div class="col-md-12" >
											<div class="col-md-1">
												<input type="checkbox" name="" class="form-control col-md-2" id="lu" required >
											</div>
											<div class="col-md-11">
												<label for="lu" style="margin-top:10px; text-align:left"> J'ai lu et j'accepte les termes du contrat.</label>
											</div>
											</div>
											
											<button type="submit" name="submit" value="envoyer_etude" class="btn btn-primary btn-xs" id="send">envoyer la demande</button>
							
										
										</form>
									</div>
                 
                </div>
                <div class="col-md-5 col-sm-5">
                  <a href="" title="Cliquer pour voir">
                    <img class="img-responsive" src="img/affiche/2.jpg" alt="">
                  </a>
                </div>
              </div>
              <div class="tab-pane fade" id="tab-3">
                <div class="col-md-5 col-sm-5">
                  <a href="img/hotel/azalai.jpg" title="Cliquer pour voir">
                    <img class="img-responsive" src="img/affiche/fouille.jpg" alt="">
                  </a>
                </div>
                <div class="col-md-7 col-sm-7">
                  
									<p>Nous vous offrons la meilleurequalité de ciment et vous pouvez le commandez maintenant.</p>

									<div id="projet">
										<form action="index.php" method="post">
										
											<div class="form-group col-md-6">
													<label for="nom">Nom</label>
													<input type="text" class="form-control input-sm form-control-sm " name="nom_client" id="nom" required>
											</div>
											<div class="form-group col-md-6">
													<label for="nom">Email</label>
													<input type="email" class="form-control input-sm form-control-sm " name="email_client" id="nom" required>
											</div>
											<div class="form-group col-md-6">
													<label for="nom">Contact</label>
													<input type="text" class="form-control input-sm form-control-sm " onkeyup="verif_nbre(this)" name="contact_client" id="nom" required>
											</div>
											<div class="form-group col-md-6">
													<label for="nom">localisation</label>
													<input type="text" class="form-control input-sm form-control-sm " name="localisation_ciment" id="nom" required>
													
								
											</div>
											<p class="erreur"></p>
											
											<div class="form-group col-md-6">
												<label for="nbre_ciment">Nombre de sac</label>
												<input type="number" class="form-control input-sm form-control-sm " onkeyup="verif_nbre(this);calculciment();" name="nbre_ciment" id="nbre_ciment" required>
											</div>

											<div class="form-group col-md-6">
												<label for="cout_ciment">Coût de l'opération</label>
												<input type="text" class="form-control input-sm form-control-sm" id="cout_ciment" onkeyup="verif_nbre(this);calculciment();"  name="cout_ciment" >
												<p class=" text-danger">* Le sac est à 3000F l'unité.</p>
											</div>

											<a href="politique.html" class="col-md-12"><p>Politique de confidentialité</p></a>
											<div class="col-md-12" >
											<div class="col-md-1">
												<input type="checkbox" name="" class="form-control col-md-2" id="lu" required>
											</div>
											<div class="col-md-11">
												<label for="lu" style="margin-top:10px; text-align:left"> J'ai lu et j'accepte les termes du contrat.</label>
											</div>
											</div>
											
											<button type="submit" name="submit" value="envoyer_ciment" class="btn btn-primary btn-xs" id="send">envoyer la demande</button>
							
										
										</form>
									</div>
                 
                </div>
              </div>
              <div class="tab-pane fade" id="tab-4">
							<div class="col-md-7 col-sm-7">
                  <p>Vous avez un besoin d'être livré en béton !?</p>
									<p>Commandez et recevez dans une votre commande.</p>

									<div id="projet">
										<form action="index.php" method="post">
										
											<div class="form-group col-md-6">
													<label for="nom">Nom</label>
													<input type="text" class="form-control input-sm form-control-sm " name="nom_client" id="nom" required>
											</div>
											<div class="form-group col-md-6">
													<label for="nom">Email</label>
													<input type="email" class="form-control input-sm form-control-sm " name="email_client" id="nom" required>
											</div>
											<div class="form-group col-md-6">
													<label for="nom">Contact</label>
													<input type="text" class="form-control input-sm form-control-sm " onkeyup="verif_nbre(this)" name="contact_client" id="nom" required>
											</div>
											<div class="form-group col-md-6">
													<label for="localisation_beton">localisation</label>
													<input type="text" class="form-control input-sm form-control-sm " name="localisation_beton" id="localisation_beton" required>
													<p class="erreur"></p>
											</div>

											<div class="form-group col-md-6">
												<label for="qte_beton">Quantité de béton (Kg)</label>
												<input type="number" class="form-control input-sm form-control-sm " onkeyup="verif_nbre(this);calculbeton();" name="qte_beton" id="qte_beton" required>
											</div>
											<div class="form-group col-md-6">
												<label for="cout_beton">Coût de la commande</label>
												<input type="text" class="form-control input-sm form-control-sm " id="cout_beton" onkeyup="verif_nbre(this);calculbeton();" name="cout_beton" >
												<p class=" text-danger">* Le beton est facturée à 1000F le kilogramme.</p>
											</div>

											<a href="politique.html" class="col-md-12"><p>Politique de confidentialité</p></a>
											<div class="col-md-12" >
											<div class="col-md-1">
												<input type="checkbox" name="" class="form-control col-md-2" id="lu" required>
											</div>
											<div class="col-md-11">
												<label for="lu" style="margin-top:10px; text-align:left"> J'ai lu et j'accepte les termes du contrat.</label>
											</div>
											</div>
											
											<button type="submit" name="submit" value="envoyer_beton" class="btn btn-primary btn-xs" id="send">envoyer la demande</button>
							
										
										</form>
									</div>
                 
								</div>
								<div class="col-md-5 col-sm-5">
                  <a href="" title="Cliquer pour voir">
                    <img class="img-responsive" src="img/affiche/4.jpg" alt="">
                  </a>
                </div>
							</div>
							
              <div class="tab-pane fade" id="tab-5">
                
              </div>
            </div>
          </div>
          <!-- END TABS -->
        
          
        </div>
	</div>
        </div>


					 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="marche">
					<hr style="width: 100px; margin-top: 20px; margin-bottom: -10px; font-weight: bold;">
					<h3 class="text-title text-warning subtitle">Sur le marché</h3>
					<?php
                    $db=Database::connect();
                    $req_affiche=$db->query("SELECT * FROM vente ORDER BY id_vente DESC LIMIT 3 ");
                    while ($row=$req_affiche->fetch()){
                    $id_vente=$row["id_vente"];
                    $titre_vente=$row["titre_vente"];
                    $date_vente=$row["date_vente"];
                    $description_vente=$row["description_vente"];
                    $photo_vente=$row["photo_vente"];
        ?>
						<div class="col-md-12 divente">
							<div class="col-md-6">
								<img src="img/vente/<?php echo $photo_vente; ?>" class="img-responsive thumbnail" style="width: 100%; height: 100px;">
							</div>
							<div class="col-md-6">
								<p><span class=" glyphicon glyphicon-calendar"></span> <?php echo dcomplete3($date_vente); ?></p>
								<p><?php echo $description_vente; ?></p>
								<p><a href="vente.php?bien=1">voir plus ...</a></p>
							</div>
						</div>
				<?php } ?>
				<div class=" col-md-12 text-center">
					<a href="" class="btn btn-warning btn-xs" style="padding:0px 20px;">Voir plus d'opprotunités</a>
					</div>
					</div> 
				</div>
				
    </div>
	<!------------------------------Fin presentation------------------------------------------------------->
	
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