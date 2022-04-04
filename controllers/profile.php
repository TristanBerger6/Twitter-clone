<?php 
 
require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");
require_once("models/LikesManager.php");
require_once("models/RetweetsManager.php");


$tweetsManager = new TweetsManager();
$usersManager = new UsersManager();
$followsManager = new FollowsManager();
$likesManager = new LikesManager();
$retweetsManager = new RetweetsManager();



if (isset($_SESSION['id'])){
    if (isset($_GET['id']) && !empty($_GET['id'])){
        $reqUser = $usersManager->getUser($_GET['id']);
        $reqUser = $reqUser->fetch();
        // if a user exists at this id
        if($reqUser){
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

            /************************************
            * allTweets will contain all the tweets to display according to the section we're in
            * It will also specify wether a tweet is a reweet or not 
            ************************************/
            $allTweets=[];  

            if(isset($_GET['type']) && $_GET['type']=="with_replies"){
                $reqUserTweets = $tweetsManager->getTweets($reqUser['id']);
                $reqUserRetweets = $retweetsManager->getUserRetweets($reqUser['id']);
            
                foreach($reqUserTweets as $t){
                    // get tweet of the user, including comments
                        $t['retweeter'] = '';
                        $t['date'] = $t['date_hour_creation'];
                        array_push($allTweets, $t);
                }
                foreach($reqUserRetweets as $rt){
                    // gets all the retweets of the user
                    $reqOriginalTweet = $tweetsManager->getTweet($rt['id_original_tweet'])->fetch();
                    if($_GET['id']== $_SESSION['id']){
                        $reqOriginalTweet['retweeter'] = 'Vous avez retweeté';
                        $reqOriginalTweet['retweeter_id'] = $SESSION['id'];
                    }else{
                        $reqOriginalTweet['retweeter'] = $reqUser['name'].' a retweeté';
                        $reqOriginalTweet['retweeter_id'] = $_GET['id'];
                    }
                    $reqOriginalTweet['date'] = $rt['date_hour_creation'];
                    array_push($allTweets, $reqOriginalTweet);
                }
            }else if(isset($_GET['type']) && $_GET['type']=="medias"){
                $reqUserTweets = $tweetsManager->getTweets($reqUser['id']);
                foreach($reqUserTweets as $t){
                    if($t['img']){
                        $t['retweeter'] = '';
                        $t['date'] = $t['date_hour_creation'];
                        array_push($allTweets, $t);
                    }
                }

            }else if(isset($_GET['type']) && $_GET['type']=="likes"){
                $reqUserLikes = $likesManager->getUserLikes($reqUser['id']);
                foreach($reqUserLikes as $t){
                    $reqTweetLiked = $tweetsManager->getTweet($t['id_tweet'])->fetch();
                    $reqTweetLiked['retweeter'] = '';
                    $reqTweetLiked['date'] = $reqTweetLiked['date_hour_creation'];
                    array_push($allTweets, $reqTweetLiked);
                }
            }else{ // default page, user tweets displayed
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
                    if($_GET['id']== $_SESSION['id']){
                        $reqOriginalTweet['retweeter'] = 'Vous avez retweeté';
                        $reqOriginalTweet['retweeter_id'] = $_SESSION['id'];
                    }else{
                        $reqOriginalTweet['retweeter'] = $reqUser['name'].' a retweeté';
                        $reqOriginalTweet['retweeter_id'] = $_GET['id'];
                    }
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
        
            /************************************
            * allTweetsWInfos will contain all the infos according to the nature of 
            * the tweet (comment,quote, quote of a comment)
            ************************************/
            $allTweetsWInfos = [];

            foreach($allTweets as $t){
                array_push($allTweetsWInfos, get_tweet_infos($t)); // in php/utils.php
            }

            require_once('views/profileView.php');
        }else{
            die("Erreur : La page recherchée n'existe pas");
        }
    }else{
        die("Erreur : La page recherchée n'existe pas");
    }
}else{
    die("Erreur : La page recherchée n'existe pas");
}
    