<?php
    if (isset($_GET["menu"])) {
        $menu=$_GET["menu"];
    }else{$menu="";}
?>

    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" id="side">
        
        <div>
            <h4>
                
                    <img class=" img-rounded " id="paramphoto" style="width:%;" src="../img/profil/<?php echo $photo_user; ?>" alt="">
                <br>
                 <?php echo $nom_user; ?> </h4>
                 <h5 class="text-center"><?php echo $privilege_user; ?></h5>
                 <a href="index.php"><span class="text-danger glyphicon glyphicon-off pull-right"></span></a>
        </div>
            <ul>

        <li class="<?php if ($menu=="commande") {echo "active"; } ?>" >
            <a href="commande.php?menu=commande">
                <i class="glyphicon glyphicon"></i>
                <span>Commandes</span>
            </a>
        </li>

        <?php if ($privilege_user=="administrateur") { ?>
        <li <?php if ($menu=="archi") {echo "active"; } ?>>
            <a href="architecte.php?menu=archi">
                <i class="glyphicon glyphicon"></i>
                <span>Architectes</span>
            </a>
        </li>
        
        
        <li <?php if ($menu=="vente") {echo "active"; } ?>>
            <a href="vente.php?menu=vente">
                <i class="glyphicon glyphicon"></i>
                <span>ventes</span>
            </a>
        </li> 
        <?php } ?>
        <li <?php if ($menu=="param") {echo "active"; } ?>>
            <a href="parametre.php?menu=param">
                <i class="glyphicon glyphicon"></i>
                <span>parametres</span>
            </a>
        </li>
        
            </ul>

    </div>