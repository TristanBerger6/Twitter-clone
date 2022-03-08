<?php 

require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");

$tweetsManager = new TweetsManager();
$usersManager = new UsersManager();
$followsManager = new FollowsManager();




if (isset($_SESSION['id'])){
    $reqUser = $usersManager->getUser($_SESSION['id']);
    $reqUser = $reqUser->fetch();
    if( isset($_POST['postTweet']) ){
    
        // check tweet length
        $tweetText = htmlspecialchars($_POST['tweet-text']);
        $tweetTextLength = strlen($tweetText);
        if( $tweetTextLength <= 140){
            if(isset($_FILES['tweet-img']) && !empty($_FILES['tweet-img']['name'])){
                $target_dirTweet = './public/img/tweets/';
                $tweetImg = $_FILES['tweet-img'];
                $maxSize = 10000000;
                [$resErr, $resName] = image_check_upload($target_dirTweet,$tweetImg,$maxSize); 
                if($resErr == null){
                    $insTweet = $tweetsManager->newTweet($reqUser['id'],$tweetText,$resName);
                }else{
                    $error = $resErr;  
                }
            }else{
                if($tweetTextLength !=0){
                    $insTweet = $tweetsManager->newTweet($reqUser['id'],$tweetText,"");
                }
            }
        }else{
            $error = 'Le tweet ne peut pas dépasser 140 caractères <br/>';
        }
    }

    $allTweets = [];

    $reqUserTweets = $tweetsManager->getTweets($reqUser['id']);
    $reqUserTweets = $reqUserTweets->fetchAll();
    foreach($reqUserTweets as $t){
        array_push($allTweets, $t);
    }
    
    $reqFollowed = $followsManager->getFollowed($reqUser['id']);
    foreach($reqFollowed as $followed){
        $reqFollowedTweets = $tweetsManager->getTweets($followed['id_followed']);
        $reqFollowedTweets = $reqFollowedTweets->fetchAll();
        foreach($reqFollowedTweets as $t){
            array_push($allTweets, $t);
        }
    }

    uasort($allTweets,function($a,$b){
        if ($a == $b){
            return 0;
        }
        return ($a['date_hour_creation']> $b['date_hour_creation']) ? -1: 1;
    });


    var_dump($allTweets);
   







    require_once(ROOT.'views/homeView.php');
}else{
    die("Erreur : La page recherchée n'existe pas");
}
    
