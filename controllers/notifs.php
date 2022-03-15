<?php 

require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");

$usersManager = new UsersManager();
$followsManager = new FollowsManager();
$tweetsManager = new TweetsManager();



if (isset($_SESSION['id'])){

   

    $reqUser = $usersManager->getUser($_SESSION['id']);
    $reqUser = $reqUser->fetch();
    

    

    require_once(ROOT.'views/notifsView.php');

}else{
    die("Erreur : La page recherchée n'existe pas");
}



