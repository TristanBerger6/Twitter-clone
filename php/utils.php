<?php

require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");
require_once("models/LikesManager.php");
require_once("models/RetweetsManager.php");



function get_tweet_infos($t){
    global $HOST,$DB_NAME,$USERNAME,$PASSWORD;
    $tweetsManager = new TweetsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
    $usersManager = new UsersManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
    $followsManager = new FollowsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
    $likesManager = new LikesManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
    $retweetsManager = new RetweetsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
   

    $mentionedUsernames = get_mentions_from_string( $t['content'], true);
    foreach($mentionedUsernames as $mentionUsername){
        $withoutAt = str_replace('@','',$mentionUsername);
        $reqId = $usersManager->getUserFromUsername($withoutAt)->fetch()['id'];
        if($reqId){
            $replace= " <a href='index.php?page=profile&id=".$reqId."' style='position:relative'><span style='position:absolute;width:100%;height:100%;top:0;left:0,z-index:2'></span> ".$mentionUsername." </a> ";
            if(strpos($t['content'],'id='.$reqId.'"') == false){
                $t['content']= preg_replace('/\s'.$mentionUsername.'\s/', $replace, $t['content']);
                $t['content']= preg_replace('/^'.$mentionUsername.'\s/', $replace, $t['content']);
                $t['content']= preg_replace('/\s'.$mentionUsername.'$/', $replace, $t['content']);
                $t['content']= preg_replace('/^'.$mentionUsername.'$/', $replace, $t['content']);
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
        $mentionedUsernames = get_mentions_from_string( $reqQuotedTweet['content'], true);
        foreach($mentionedUsernames as $mentionUsername){
            $withoutAt = str_replace('@','',$mentionUsername);
            $reqId = $usersManager->getUserFromUsername($withoutAt)->fetch()['id'];
            if($reqId){
                $replace= " <a href='index.php?page=profile&id=".$reqId."' style='position:relative'><span style='position:absolute;width:100%;height:100%;top:0;left:0,z-index:2'></span> ".$mentionUsername." </a> ";
                if(strpos($reqQuotedTweet['content'],$reqId) == false){
                    $reqQuotedTweet['content']= preg_replace('/\s'.$mentionUsername.'\s/', $replace, $reqQuotedTweet['content']);
                    $reqQuotedTweet['content']= preg_replace('/^'.$mentionUsername.'\s/', $replace, $reqQuotedTweet['content']);
                    $reqQuotedTweet['content']= preg_replace('/\s'.$mentionUsername.'$/', $replace, $reqQuotedTweet['content']);
                    $reqQuotedTweet['content']= preg_replace('/^'.$mentionUsername.'$/', $replace, $reqQuotedTweet['content']);
                }
            
            }
        } 
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
    return $t; 
}