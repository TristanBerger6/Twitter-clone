<?php 

require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");
require_once("models/LikesManager.php");
require_once("models/RetweetsManager.php");
require_once("models/MentionsManager.php");


$tweetsManager = new TweetsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
$usersManager = new UsersManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
$followsManager = new FollowsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
$likesManager = new LikesManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
$retweetsManager = new RetweetsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
$mentionsManager = new MentionsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);





if (isset($_SESSION['id'])){
    $reqUser = $usersManager->getUser($_SESSION['id']);
    $reqUser = $reqUser->fetch();

    // if the user posted a tweet from home page
    if( isset($_POST['postTweet']) ){
        // check tweet length
        $tweetText = htmlspecialchars($_POST['tweet-text']);
        $tweetTextLength = strlen($tweetText);
        $mentionedUsernames = get_mentions_from_string( $tweetText );
        $mentionedIds = [];
        foreach($mentionedUsernames as $mentionUsername){
            $reqId = $usersManager->getUserFromUsername($mentionUsername)->fetch()['id'];
            if($reqId){
                array_push($mentionedIds,$reqId);
            }
        } 
        if( $tweetTextLength <= 140){
            if(isset($_FILES['tweet-img']) && !empty($_FILES['tweet-img']['name'])){
                $target_dirTweet = './public/img/tweets/';
                $tweetImg = $_FILES['tweet-img'];
                $maxSize = 10000000;
                [$resErr, $resName] = image_check_upload($target_dirTweet,$tweetImg,$maxSize); 
                if($resErr == null){
                    $insTweet = $tweetsManager->newTweet($reqUser['id'],$tweetText,$resName)->fetch();
                    foreach($mentionedIds as $mentionedId){
                        $insMention = $mentionsManager->setMention($_SESSION['id'],$mentionedId,$insTweet['NewID']);
                    }
                }else{
                    $error = $resErr;  
                }
            }else{
                if($tweetTextLength !=0){
                    $insTweet = $tweetsManager->newTweet($reqUser['id'],$tweetText,"")->fetch();
                    foreach($mentionedIds as $mentionedId){
                        $insMention = $mentionsManager->setMention($_SESSION['id'],$mentionedId,$insTweet['NewID']);
                    }
                }
            }
        }else{
            $error = 'Le tweet ne peut pas dépasser 140 caractères <br/>';
        }
    }

    // get All tweets and retweets to display from current user + the people he is following
    $allTweets = [];

    $reqUserTweets = $tweetsManager->getTweets($reqUser['id']);
    $reqUserRetweets = $retweetsManager->getUserRetweets($reqUser['id']);
 
    foreach($reqUserTweets as $t){
        // get tweet of the user, but not the comments
        if($t['comment'] == false){
            $t['retweeter'] = '';
            $t['date'] = $t['date_hour_creation'];
            array_push($allTweets, $t);
        }
    }
    foreach($reqUserRetweets as $rt){
        // gets all the retweets of the user
        $reqOriginalTweet = $tweetsManager->getTweet($rt['id_original_tweet'])->fetch();
        $reqOriginalTweet['retweeter'] = 'Vous avez retweeté';
        $reqOriginalTweet['retweeter_id'] = $_SESSION['id'];
        $reqOriginalTweet['date'] = $rt['date_hour_creation'];
        array_push($allTweets, $reqOriginalTweet);
    }
    
    $reqFollowed = $followsManager->getFollowed($reqUser['id']);
    foreach($reqFollowed as $followed){
        $reqFollowedTweets = $tweetsManager->getTweets($followed['id_followed']);
        $reqFollowedRetweets = $retweetsManager->getUserRetweets($followed['id_followed']);

        //get all the tweets from the followed people, but not their comments
        foreach($reqFollowedTweets as $t){
            if($t['comment'] == false){
                $t['retweeter'] = '';
                $t['date'] = $t['date_hour_creation'];
                array_push($allTweets, $t);
            }
        }
        // get all the retweets from the followed people
        foreach($reqFollowedRetweets as $rt){
            $retweeterName = $usersManager->getUser($rt['id_user'])->fetch()['name'];
            $reqOriginalTweet = $tweetsManager->getTweet($rt['id_original_tweet'])->fetch();
            $reqOriginalTweet['retweeter'] = ''.$retweeterName.' a retweeté';
            $reqOriginalTweet['retweeter_id'] = $rt['id_user'];
            $reqOriginalTweet['date'] = $rt['date_hour_creation'];
            array_push($allTweets, $reqOriginalTweet);
        }
    }

    uasort($allTweets,function($a,$b){
        if ($a == $b){
            return 0;
        }
        return ($a['date']> $b['date']) ? -1: 1;
    });

  

    // Add user info, nb of like, nb of retweet, nb of comment on each tweet
    $allTweetsWInfos = [];

    foreach($allTweets as $t){
        array_push($allTweetsWInfos, get_tweet_infos($t)); // in php/utils.php
         
    }
    require_once('views/homeView.php');
}else{
    die("Erreur : La page recherchée n'existe pas");
}
    
