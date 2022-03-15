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
        $mentionedUsernames = get_mentions_from_string( $t['content'], true);
        foreach($mentionedUsernames as $mentionUsername){
            $withoutAt = str_replace('@','',$mentionUsername);
            $reqId = $usersManager->getUserFromUsername($withoutAt)->fetch()['id'];
            if($reqId){
                $replace= " <a href='index.php?page=profile&id=".$reqId."' style='position:relative'><span style='position:absolute;width:100%;height:100%;top:0;left:0,z-index:2'></span> ".$mentionUsername." </a> ";
                if(strpos($t['content'],$reqId) == false){
                    $t['content']= preg_replace('/\s'.$mentionUsername.'+/', $replace, $t['content']);
                    $t['content']= preg_replace('/^'.$mentionUsername.'+/', $replace, $t['content']);
                }
               
            }
        } 
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
        $reqComments = $tweetsManager->getTweetComments($t['id']);
        $t['nbComments'] = $reqComments->rowCount();
        $isFollowed = $followsManager->isFollowed($_SESSION['id'],$t['id_user']);
        $t['followed']= $isFollowed->rowCount();
        $isLiked = $likesManager->isLiked($_SESSION['id'],$t['id']);
        $t['liked']= $isLiked->rowCount();
        $isRetweeted = $retweetsManager->isRetweeted($_SESSION['id'],$t['id']);
        $t['retweeted']= $isRetweeted->rowCount();
        // if the tweet is a quote, get quoted infos
        if($t['quote']){
            $reqQuotedTweet = $tweetsManager->getTweet($t['quoted_id'])->fetch();
            $reqUserQuotedTweet = $usersManager->getUser($reqQuotedTweet['id_user'])->fetch();
            $t['quotedProfile'] = $reqUserQuotedTweet['img'];
            $t['quotedName']= $reqUserQuotedTweet['name'];
            $t['quotedUsername']= $reqUserQuotedTweet['username'];
            $t['quotedDate'] = get_time_ago_fr($reqQuotedTweet['date_hour_creation']);
            $t['quotedContent']= $reqQuotedTweet['content'];
            $t['quotedImg']= $reqQuotedTweet['img'];
            $t['quotedId']= $reqQuotedTweet['id'];
            // if the quoted tweet is a comment, then find who does it respond to 
            if($reqQuotedTweet['comment']){
                $t['quotedResponseTo'] = [];
                $allAboveTweets = [];
                $currentTweet = $reqQuotedTweet;
    
                $isComment = $tweetsManager->getTweet($reqQuotedTweet['id'])->fetch()['comment'];
            
                while($isComment){
                    $reqAboveTweet = $tweetsManager->getTweet($currentTweet['commentof_id'])->fetch();
                    array_unshift($allAboveTweets, $reqAboveTweet);
                    $currentTweet = $reqAboveTweet;
                    $isComment = $tweetsManager->getTweet($currentTweet['id'])->fetch()['comment'];  
                }
                foreach($allAboveTweets as $prev){
                    $reqUsername = $usersManager->getUserNameUsername($prev['id_user'])->fetch()['username'];
                    $usernames = [];
                    foreach($t['quotedResponseTo'] as $o){
                        array_push($usernames,$o['username']);
                    }
                    if ( !in_array($reqUsername,$usernames)){
                        array_push($t['quotedResponseTo'],[ 'username' => $reqUsername, 'id'=>$prev['id_user'] ]);
                    }
                }
                
            }
        // if the tweet itself is a comment (a retweet), then find who does it respond to 
        }else if($t['comment']){
            $t['responseTo'] = [];
            $allAboveTweets = [];
            $currentTweet = $t;

            $isComment = $tweetsManager->getTweet($t['id'])->fetch()['comment'];
        
            while($isComment){
                $reqAboveTweet = $tweetsManager->getTweet($currentTweet['commentof_id'])->fetch();
                array_unshift($allAboveTweets, $reqAboveTweet);
                $currentTweet = $reqAboveTweet;
                $isComment = $tweetsManager->getTweet($currentTweet['id'])->fetch()['comment'];  
            }
            foreach($allAboveTweets as $prev){
                $reqUsername = $usersManager->getUserNameUsername($prev['id_user'])->fetch()['username'];
                $usernames = [];
                foreach($t['responseTo'] as $o){
                    array_push($usernames,$o['username']);
                }
                if ( !in_array($reqUsername,$usernames)){
                    array_push($t['responseTo'],[ 'username' => $reqUsername, 'id'=>$prev['id_user'] ]);
                }
            }
            
        }
        array_push($allTweetsWInfos, $t); 
         
    }


  



    require_once(ROOT.'views/homeView.php');
}else{
    die("Erreur : La page recherchée n'existe pas");
}
    
