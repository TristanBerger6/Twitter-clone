<?php if(isset($_SESSION['id'])){ ?>
<div class='nav'>
    <a href='index.php?page=home'> Accueil </a>
    <a href='index.php?page=home'> Notifications </a>
    <?php echo "<a href='index.php?page=profile&id=".$_SESSION['id']."'> Profil </a>" ?>
    <a href='index.php?page=settings'> Paramètres </a>
    <a href='index.php?page=logout'> Déconnexion </a>
</div>

 <?php } ?>