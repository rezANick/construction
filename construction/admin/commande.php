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
    $privilege_user=$_SESSION["privilege_user"];


}else{
    header("location: index.php");
}

$db=Database::connect();
if (isset($_GET["com"]) and isset($_GET["attribut"])) {
    $id_attribut=$_GET["attribut"];
    $id_com=$_GET["com"];

    $req_modif_com=$db->exec("UPDATE commande SET etat_commande='1',id_user='$id_attribut' WHERE id_commande='$id_com'");

    $req_modif_user=$db->exec("UPDATE user SET attribut_user=attribut_user + 1 WHERE id_user='$id_attribut'");
    $req_verify=$db->query("SELECT attribut_user FROM user WHERE id_user='$id_attribut' " );
    $row_verif=$req_verify->fetch();
    if ($row_verif["attribut_user"]>='3') {
        $req_modif=$db->exec("UPDATE user SET etat_user='1' WHERE id_user='$id_attribut'");
    }
    
    header("location: commande.php?attribut=success");
   
}if (isset($_GET["livraison"])) {
    $id_com=$_GET["livraison"];

   
    $req_modif_com=$db->exec("UPDATE commande SET etat_commande='1' WHERE id_commande='$id_com'");
        
    header("location: commande.php?attribut=success");
   
}

if (isset($_GET["termine"])) {
    $id_com=$_GET["termine"];

   
    $req_modif_com=$db->exec("UPDATE commande SET etat_commande='2' WHERE id_commande='$id_com'");
        
    header("location: commande.php?valide=success");
}
if (isset($_GET["acheve"])) {
    $id_com=$_GET["acheve"];

   
    $req_modif_com=$db->exec("UPDATE commande SET etat_commande='2' WHERE id_commande='$id_com'");
    $req_modif_user=$db->exec("UPDATE user SET attribut_user=attribut_user - '1' WHERE id_user='$id_user'");
        
    header("location: commande.php?valide=success");
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

    <div class=" col-md-10 ">
        <div class="col-md-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-12">
                <h3 class="text-uppercase">Liste des commandes</h3>  
                </div>
                
                  	
                <table class="table table-bordered table-responsive table-bordered">
                <?php if ($privilege_user=="administrateur") { ?>
                    <thead>
                        <tr>
                            <th>date et heure </th>
                            <th>Type de commande</th>
                            <th>Detail </th>
                            <th>Client </th>
                            <th>En charge</th>
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
                        <tr class="<?php if (isset($_GET["detail"]) and $_GET["detail"]==$id_user) {echo "active"; } ?> ">
                            <td>
                                <a href="?detail=<?php echo dcomplete3($date_commande); ?>" alt="voir les détails">
                                <?php echo dcomplete3($date_commande)?> &nbsp;<span style="font-size:12px;"> à</span> &nbsp; <?php echo $heure_commande ; ?>
                            </a>
                            </td>
                            <td><?php echo $type_commande; ?></td>
                             
                            <td>
                                <?php
                                if ($type_commande=="Réalisation du projet") {
                                    $req_detail=$db->query("SELECT * FROM projet WHERE id_projet='$id_type_commande' ");
                                    $row_projet=$req_detail->fetch();
                                    $detail_tableau=$row_projet["type_projet"];
                                    
                                }elseif ($type_commande=="Etude de terrain") {
                                    $req_detail=$db->query("SELECT * FROM etude WHERE id_etude='$id_type_commande' ");
                                    $row_etude=$req_detail->fetch();
                                    $emplacement_etude=$row_etude["emplacement_etude"];
                                    $dimension_etude=$row_etude["dimension_etude"];
                                    $cout_etude=$row_etude["cout_etude"];

                                    $detail_tableau="fouille d'un terrain d'une dimension de <span class='bold'>".$dimension_etude.".</span><br>
                                     Localisation : <span class='bold'>".$emplacement_etude.".</span><br>
                                     Coût : <span class='bold'>".$cout_etude."<span style='font-size:13px'>Fcfa</span></span>";
                                    
                                }elseif ($type_commande=="vente de ciment") {
                                    $req_detail=$db->query("SELECT * FROM ciment WHERE id_ciment='$id_type_commande' ");
                                    $row_ciment=$req_detail->fetch();
                                    $nbre_ciment=$row_ciment["nbre_ciment"];
                                    $localisation_ciment=$row_ciment["localisation_ciment"];
                                    $cout_ciment=$row_ciment["cout_ciment"];

                                    $detail_tableau="Livraison de <span class='bold'>".$nbre_ciment."sacs de ciment</span><br>
                                     Localisation : <span class='bold'>".$localisation_ciment."</span><br>.
                                     Coût : <span class='bold'>".$cout_ciment."<span style='font-size:13px'>Fcfa</span></span>";

                                }elseif ($type_commande=="vente de beton") {
                                    $req_detail=$db->query("SELECT * FROM beton WHERE id_beton='$id_type_commande' ");
                                    $row_beton=$req_detail->fetch();
                                    $qte_beton=$row_beton["qte_beton"];
                                    $localisation_beton=$row_beton["localisation_beton"];
                                    $cout_beton=$row_beton["cout_beton"];

                                    $detail_tableau="Livraison de <span class='bold'>".$qte_beton."Kg de béton</span><br>
                                     Localisation : <span class='bold'>".$localisation_beton."</span><br>.
                                     Coût : <span class='bold'>".$cout_beton."<span style='font-size:13px'>Fcfa</span></span>";
                                }
                                echo $detail_tableau;
                                ?>

                                


                            </td>
                            <td>
                                <span class=" glyphicon glyphicon-user " style="font-size:15px;"></span> <?php echo $nom_client; ?><br>
                                <span class=" glyphicon glyphicon-envelope "> <?php echo $email_client; ?><br>
                                <span class=" glyphicon glyphicon-phone "> <?php echo $contact_client; ?>
                            </td>
                            <td>
                            <?php if($id_user==1) { ?>
                                        Insdisponible
                                <?php }else { echo $nom_user."<br>".$contact_user; } ?>
                            </td>


                            <td>
                                <?php if ($etat_commande==0) {?>
                                    <a class="btn btn-danger btn-xs " href="javascript:;" data-toggle="modal" data-target="#monmodal<?php echo $id_commande; ?>">
                                        En attente
                                    </a>
                                    <div class="modal fade" id="monmodal<?php echo $id_commande; ?>">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                            <?php if ($type_commande=="Réalisation du projet" or  $type_commande=="Etude de terrain") { ?>
                                                <div class="modal-header">
                                                    <h4 class="modal-title text-uppercase" style="text-align:center;">
                                                        Attribuer un architecte au projet
                                                    </h4>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered table-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th>Nom</th>
                                                                <th>Contact</th>
                                                                <th>Option</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $req_atribut=$db->query("SELECT * FROM user WHERE privilege_user    ='architecte' and etat_user='0' ");
                                                                while ($row_attribut=$req_atribut->fetch()){
                                                                    $id_archi=$row_attribut["id_user"];
                                                                    $nom_archi=$row_attribut["nom_user"];
                                                                    $contact_archi=$row_attribut["contact_user"];
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $nom_archi; ?></td>
                                                                <td><?php echo $contact_archi; ?></td>
                                                                <td>
                                                                    <a href="commande.php?com=<?php echo $id_commande; ?>&attribut=<?php echo $id_archi; ?>" class="btn btn-primary btn-xs " href="javascript:;">
                                                                        Attribuer
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>

                                                    </table>
                                                </div>
                                                
                                            <?php   }else{ ?>
                                                <div class="modal-header">
                                                    <h4 class="modal-title text-uppercase" style="text-align:center;">
                                                        Démarrer la livraison?
                                                    </h4>
                                                </div> 
                                                <div class="modal-body text-center" >
                                                <button type="submit" class="btn btn-danger btn-sm" data-dismiss="modal" style="margin-right:15px;">
                                                    non
                                                </button>
                                                <a href="commande.php?livraison=<?php echo $id_commande; ?>" class="btn btn-primary btn-sm">oui</a>
                                                </div>                          
                                            <?php } ?>   
                                            </div>
                                        </div>
                                    </div>
                                <?php }elseif($etat_commande==1) {
                                    if ($id_user==1) { ?>
                                        <a class="btn btn-warning btn-xs " href="javascript:;" data-toggle="modal" data-target="#monmodal<?php echo $id_commande; ?>">
                                        En cours
                                    </a>
                                    <div class="modal fade" id="monmodal<?php echo $id_commande; ?>">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title text-uppercase" style="text-align:center;">
                                                        Terminer la livraison ?
                                                    </h4>
                                                </div>
                                                
                                                <div class="modal-body text-center" >
                                                <button type="submit" class="btn btn-danger btn-sm" data-dismiss="modal" style="margin-right:15px;">
                                                    non
                                                </button>
                                                <a href="commande.php?termine=<?php echo $id_commande; ?>" class="btn btn-primary btn-sm">oui</a>
                                                </div>                          
                                            </div>
                                        </div>
                                    </div>
                                    <?php }else{ ?>
                                    
                                        <button class="btn btn-warning btn-xs">
                                            En cours
                                        </button>
                                    
                                <?php } }elseif($etat_commande==2) { 
                                    
                                    ?>
                                    <button class="btn btn-success btn-xs">
                                        Terminer
                                    </button>
                            <?php } ?>
                            </td>
                        </tr>
                    <?php }  ?>

                    </tbody>
               <?php }else{ ?>

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

                        $req_liste=$db->query("SELECT com.id_commande, com.type_commande, com.id_type_commande, com.id_client, com.id_user, com.date_commande, com.etat_commande,
                                                    cl.id_client, cl.nom_client, cl.email_client, cl.contact_client,
                                                     us.id_user, us.id_user, us.nom_user, us.email_user, us.privilege_user, us.etat_user, us.contact_user, us.photo_user
                                             FROM commande com
                                             INNER JOIN client cl
                                             ON com.id_client=cl.id_client
                                             INNER JOIN user us
                                             ON com.id_user=us.id_user 
                                             WHERE com.id_user='$id_user'");
                                    while ($row=$req_liste->fetch()){ 
                                        
                                        $id_user=$row["id_user"];
                                    $nom_user=$row["nom_user"];
                                    $contact_user=$row["contact_user"];
                                    $etat_user=$row["etat_user"];

                                    $id_commande=$row["id_commande"];
                                    $type_commande=$row["type_commande"];
                                    $id_type_commande=$row["id_type_commande"];
                                    $date_de_commande=$row["date_commande"];
                                    list($date_commande,$heure_commande) = explode(" ",$date_de_commande);
                                    $etat_commande=$row["etat_commande"];

                                    $id_client=$row["id_client"];
                                    $nom_client=$row["nom_client"];
                                    $email_client=$row["email_client"];
                                    $contact_client=$row["contact_client"];?>
                        
                        <tr class=" ">
                            <td>
                                <a href="?detail=<?php echo dcomplete3($date_commande); ?>" alt="voir les détails">
                                <?php echo dcomplete3($date_commande)?> &nbsp;<span style="font-size:12px;"> à</span> &nbsp; <?php echo $heure_commande ; ?>
                            </a>
                            </td>
                            <td><?php echo $type_commande; ?></td>
                             
                            <td>
                                <?php
                                if ($type_commande=="Réalisation du projet") {
                                    $req_detail=$db->query("SELECT * FROM projet WHERE id_projet='$id_type_commande' ");
                                    $row_projet=$req_detail->fetch();
                                    $detail_tableau=$row_projet["type_projet"];
                                    
                                }elseif ($type_commande=="Etude de terrain") {
                                    $req_detail=$db->query("SELECT * FROM etude WHERE id_etude='$id_type_commande' ");
                                    $row_etude=$req_detail->fetch();
                                    $emplacement_etude=$row_etude["emplacement_etude"];
                                    $dimension_etude=$row_etude["dimension_etude"];
                                    $cout_etude=$row_etude["cout_etude"];

                                    $detail_tableau="fouille d'un terrain d'une dimension de <span class='bold'>".$dimension_etude.".</span><br>
                                     Localisation : <span class='bold'>".$emplacement_etude."</span><br>.
                                     Coût : <span class='bold'>".$cout_etude."<span style='font-size:13px'>Fcfa</span></span>";
                                    
                                }elseif ($type_commande=="vente de ciment") {
                                    $req_detail=$db->query("SELECT * FROM ciment WHERE id_ciment='$id_type_commande' ");
                                    $row_ciment=$req_detail->fetch();
                                    $nbre_ciment=$row_ciment["nbre_ciment"];
                                    $localisation_ciment=$row_ciment["localisation_ciment"];
                                    $cout_ciment=$row_ciment["cout_ciment"];

                                    $detail_tableau="Livraison de <span class='bold'>".$nbre_ciment."sacs de ciment</span><br>
                                     Localisation : <span class='bold'>".$localisation_ciment."</span><br>.
                                     Coût : <span class='bold'>".$cout_ciment."<span style='font-size:13px'>Fcfa</span></span>";

                                }elseif ($type_commande=="vente de beton") {
                                    $req_detail=$db->query("SELECT * FROM beton WHERE id_beton='$id_type_commande' ");
                                    $row_beton=$req_detail->fetch();
                                    $qte_beton=$row_beton["qte_beton"];
                                    $localisation_beton=$row_beton["localisation_beton"];
                                    $cout_beton=$row_beton["cout_beton"];

                                    $detail_tableau="Livraison de <span class='bold'>".$qte_beton."Kg de béton</span><br>
                                     Localisation : <span class='bold'>".$localisation_beton."</span><br>.
                                     Coût : <span class='bold'>".$cout_beton."<span style='font-size:13px'>Fcfa</span></span>";
                                }
                                echo $detail_tableau;
                                ?>


                            </td>
                            <td>
                                <?php echo $nom_client; ?><br>
                                <?php echo $email_client; ?><br>
                                <?php echo $contact_client; ?>
                            </td>
                            
                            <td>
                                
                                <?php if($etat_commande==1) { ?>
                                    
                                        <a class="btn btn-danger btn-xs " href="javascript:;" data-toggle="modal" data-target="#monmodal<?php echo $id_commande; ?>">
                                        En attente
                                    </a>
                                    <div class="modal fade" id="monmodal<?php echo $id_commande; ?>">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title text-uppercase" style="text-align:center;">
                                                        Avez-vous terminé ce service ?
                                                    </h4>
                                                </div>
                                                
                                                <div class="modal-body text-center" >
                                                <button type="submit" class="btn btn-danger btn-sm" data-dismiss="modal" style="margin-right:15px;">
                                                    non
                                                </button>
                                                <a href="commande.php?acheve=<?php echo $id_commande; ?>" class="btn btn-primary btn-sm">oui</a>
                                                </div>                          
                                            </div>
                                        </div>
                                    </div>
                                    
                                <?php  }elseif($etat_commande==2) { 
                                    
                                    ?>
                                    <button class="btn btn-success btn-xs">
                                        Terminer
                                    </button>
                            <?php } ?>
                            </td>
                        </tr>
                    <?php }  ?>

                    </tbody>
                    <?php }  ?>
                </table>
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