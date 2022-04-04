<?php 

require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");
require_once("models/LikesManager.php");
require_once("models/RetweetsManager.php");
require_once("models/MentionsManager.php");



$tweetsManager = new TweetsManager();
$usersManager = new UsersManager();
$followsManager = new FollowsManager();
$likesManager = new LikesManager();
$retweetsManager = new RetweetsManager();
$mentionsManager = new MentionsManager();





if (isset($_SESSION['id'])){
    $reqUser = $usersManager->getUser($_SESSION['id']);
    $reqUser = $reqUser->fetch();

    if(isset($_GET['query']) && !empty($_GET['query'])){
        $textValue = htmlspecialchars($_GET['query']);
        $reqTweets = $tweetsManager->getTweetContentQuery($textValue)->fetchAll();

        // Add user info, nb of like, nb of retweet, nb of comment on each tweet
        $allTweetsWInfos = [];

        foreach($reqTweets as $t){
            array_push($allTweetsWInfos, get_tweet_infos($t)); // in php/utils.php
            
        }
        uasort($allTweetsWInfos,function($a,$b){
            if ($a == $b){
                return 0;
            }
            return ($a['date_hour_creation']> $b['date_hour_creation']) ? -1: 1;
        });
    }
    require_once('views/exploreView.php');
}else{
    die("Erreur : La page recherchée n'existe pas");
}
    
