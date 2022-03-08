<?php 

require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");

$usersManager = new UsersManager();
$followsManager = new FollowsManager();
$tweetsManager = new TweetsManager();



if (isset($_SESSION['id'])){
    if (isset($_GET['id']) && !empty($_GET['id'])){
     
        $reqUser = $usersManager->getUser($_GET['id']);
        $reqUser = $reqUser->fetch();
        $month = utf8_encode(strftime('%B', strtotime($reqUser['date_hour_creation'])));
        $year = strftime('%Y', strtotime($reqUser['date_hour_creation']));
        $reqUser['date_hour_creation'] = $month. ' ' . $year;

        $reqTweets = $tweetsManager->getTweets($reqUser['id']);
        $reqFollowers = $followsManager->getFollowers($reqUser['id']);
        $reqFollowed = $followsManager->getFollowed($reqUser['id']);

        $nbFollowers = $reqFollowers->rowCount();
        $nbFollowed = $reqFollowed->rowCount(); 
        $nbTweets = $reqTweets->rowCount();

        $isFollowed = $followsManager->isFollowed($_SESSION['id'],$reqUser['id']);
        $isFollowed = $isFollowed->rowCount();

        require_once(ROOT.'views/profileView.php');
    }else{
        die("Erreur : La page recherchée n'existe pas");
    }
}else{
    die("Erreur : La page recherchée n'existe pas");
}
    