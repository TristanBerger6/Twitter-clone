<?php 

if (isset($_SESSION['id'])){
    require_once(ROOT.'views/homeView.php');
}else{
    die("Erreur : La page recherchée n'existe pas");
}
    
