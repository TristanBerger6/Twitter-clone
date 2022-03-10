<?php 

require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");
require_once("models/LikesManager.php");
require_once("models/RetweetsManager.php");
require_once("models/CommentsManager.php");

$tweetsManager = new TweetsManager();
$usersManager = new UsersManager();
$followsManager = new FollowsManager();
$likesManager = new LikesManager();
$retweetsManager = new RetweetsManager();
$commentsManager = new CommentsManager();




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

    // get All tweets to display
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
        $reqFollowedInfos = $usersManager->getUser($followed['id_followed']);
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

    // Add user info, nb of like, nb of retweet, nb of comment on each tweet
    $allTweetsWInfos = [];

    foreach($allTweets as $t){
        $reqUserNameUsername = $usersManager->getUserNameUsername($t['id_user']);
        $reqUserNameUsername = $reqUserNameUsername->fetch();
        $t['name'] = $reqUserNameUsername['name'];
        $t['username'] = $reqUserNameUsername['username'];
        $reqLikes = $likesManager->getTweetLikes($t['id']);
        $t['nbLikes'] = $reqLikes->rowCount();
        $reqRetweets = $retweetsManager->getRetweetsOfTweet($t['id']);
        $t['nbRetweets'] = $reqRetweets->rowCount();
        $reqComments = $commentsManager->getTweetComments($t['id']);
        $t['nbComments'] = $reqComments->rowCount();
        $isFollowed = $followsManager->isFollowed($_SESSION['id'],$t['id_user']);
        $isFollowed = $isFollowed->rowCount();
        $t['followed']= $isFollowed;
        $isLiked = $likesManager->isLiked($_SESSION['id'],$t['id']);
        $isLiked = $isLiked->rowCount();
        $t['liked']= $isLiked;
        $isRetweeted = $retweetsManager->isRetweeted($_SESSION['id'],$t['id']);
        $isRetweeted = $isRetweeted->rowCount();
        $t['retweeted']= $isRetweeted;
        array_push($allTweetsWInfos, $t);
        
    }
 

    


  







    require_once(ROOT.'views/homeView.php');
}else{
    die("Erreur : La page recherchée n'existe pas");
}
    
