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
                    $reqOriginalTweet['retweeter'] = 'Vous avez retweeté';
                    $reqOriginalTweet['retweeter_id'] = $_SESSION['id'];
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
                    $reqOriginalTweet['retweeter'] = 'Vous avez retweeté';
                    $reqOriginalTweet['retweeter_id'] = $_SESSION['id'];
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

            require_once(ROOT.'views/profileView.php');
        }else{
            die("Erreur : La page recherchée n'existe pas");
        }
    }else{
        die("Erreur : La page recherchée n'existe pas");
    }
}else{
    die("Erreur : La page recherchée n'existe pas");
}
    