<?php 

require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");

$usersManager = new UsersManager();
$followsManager = new FollowsManager();
$tweetsManager = new TweetsManager();



if (isset($_SESSION['id'])){
    if (isset($_GET['id']) && !empty($_GET['id'])){
     
        $gg = $_GET['id'];

        require_once(ROOT.'views/statusView.php');
    }else{
        die("Erreur : La page recherchée n'existe pas");
    }
}else{
    die("Erreur : La page recherchée n'existe pas");
}
    