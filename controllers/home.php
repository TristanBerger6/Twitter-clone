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

    // get All tweets and retweets to display from current user + the people he is following
    $allTweets = [];

    $reqUserTweets = $tweetsManager->getTweets($reqUser['id']);
    $reqUserRetweets = $retweetsManager->getUserRetweets($reqUser['id']);
 
    foreach($reqUserTweets as $t){
        $t['retweeter'] = '';
        $t['date'] = $t['date_hour_creation'];
        array_push($allTweets, $t);
    }
    foreach($reqUserRetweets as $rt){
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

        foreach($reqFollowedTweets as $t){
            $t['retweeter'] = '';
            $t['date'] = $t['date_hour_creation'];
            array_push($allTweets, $t);
        }
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
        
        $t['date_hour_creation'] = get_time_ago_fr($t['date_hour_creation']);
        $reqUserNameUsername = $usersManager->getUserNameUsername($t['id_user'])->fetch();
        $reqUserProfile = $usersManager->getUserProfile($t['id_user'])->fetch();
        $t['name'] = $reqUserNameUsername['name'];
        $t['username'] = $reqUserNameUsername['username'];
        $t['profile'] = $reqUserProfile['img'];
        $reqLikes = $likesManager->getTweetLikes($t['id']);
        $t['nbLikes'] = $reqLikes->rowCount();
        $reqRetweets = $retweetsManager->getRetweetsOfTweet($t['id']);
        $t['nbRetweets'] = $reqRetweets->rowCount();
        $reqComments = $commentsManager->getTweetComments($t['id']);
        $t['nbComments'] = $reqComments->rowCount();
        $isFollowed = $followsManager->isFollowed($_SESSION['id'],$t['id_user']);
        $t['followed']= $isFollowed->rowCount();
        $isLiked = $likesManager->isLiked($_SESSION['id'],$t['id']);
        $t['liked']= $isLiked->rowCount();
        $isRetweeted = $retweetsManager->isRetweeted($_SESSION['id'],$t['id']);
        $t['retweeted']= $isRetweeted->rowCount();
        if($t['quote']){
            $reqQuotedTweet = $tweetsManager->getTweet($t['quoted_id'])->fetch();
            $reqUserQuotedTweet = $usersManager->getUser($reqQuotedTweet['id_user'])->fetch();
            $t['quotedProfile'] = $reqUserQuotedTweet['img'];
            $t['quotedName']= $reqUserQuotedTweet['name'];
            $t['quotedUsername']= $reqUserQuotedTweet['username'];
            $t['quotedDate'] = get_time_ago_fr($reqQuotedTweet['date_hour_creation']);
            $t['quotedContent']= $reqQuotedTweet['content'];
            $t['quotedImg']= $reqQuotedTweet['img'];
        }
        array_push($allTweetsWInfos, $t);  
    }
    //var_dump($allTweetsWInfos);
    
 

    


  







    require_once(ROOT.'views/homeView.php');
}else{
    die("Erreur : La page recherchée n'existe pas");
}
    
