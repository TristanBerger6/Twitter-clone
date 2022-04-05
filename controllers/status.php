<?php 

require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");
require_once("models/LikesManager.php");
require_once("models/RetweetsManager.php");


$usersManager = new UsersManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
$followsManager = new FollowsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
$tweetsManager = new TweetsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
$likesManager = new LikesManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
$retweetsManager = new RetweetsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);



if (isset($_SESSION['id'])){
    $reqUser = $usersManager->getUser($_SESSION['id']);
    $reqUser = $reqUser->fetch();
    if (isset($_GET['id']) && !empty($_GET['id'])){
       

        /******* Get the tweet of the status ****************************/
        $tweet = $tweetsManager->getTweet($_GET['id'])->fetch();
        //if this tweet exists
        if($tweet){
            if(isset($_GET['retweeter']) && !empty($_GET['retweeter'])){
                $reqRetweets = $retweetsManager->getUserRetweets($_GET['retweeter']);
                foreach($reqRetweets as $rt){
                    if($rt['id_original_tweet'] == $_GET['id']){
                        $tweet['retweeter_id'] = $_GET['retweeter'];
                        $name = $usersManager->getUser($_GET['retweeter'])->fetch()['name'];
                        if($_GET['retweeter']== $_SESSION['id']){
                            $tweet['retweeter'] = 'Vous avez retweeté';
                        }else{
                            $tweet['retweeter'] = $name.' a retweeté';
                        }
                    }
                }
            }
         
    
            /*********Get also the tweets this tweet is responding to ***************/
            $allAboveTweetsWInfos = [];
            $allAboveTweets = [$tweet];
            $currentTweet = $tweet;
    
            $isComment = $tweetsManager->getTweet($currentTweet['id'])->fetch()['comment'];
         
            while($isComment){
                $reqAboveTweet = $tweetsManager->getTweet($currentTweet['commentof_id'])->fetch();
                array_unshift($allAboveTweets, $reqAboveTweet);
                $currentTweet = $reqAboveTweet;
                $isComment = $tweetsManager->getTweet($currentTweet['id'])->fetch()['comment'];  
            }
    
            foreach($allAboveTweets as $key=>$t){
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
                // if the tweet of the status is quoted, add quoted infos
                if($t['quote']){
                    $reqQuotedTweet = $tweetsManager->getTweet($t['quoted_id'])->fetch();
                    $mentionedUsernames = get_mentions_from_string( $reqQuotedTweet['content'], true);
                    foreach($mentionedUsernames as $mentionUsername){
                        $withoutAt = str_replace('@','',$mentionUsername);
                        $reqId = $usersManager->getUserFromUsername($withoutAt)->fetch()['id'];
                        if($reqId){
                            $replace= " <a href='index.php?page=profile&id=".$reqId."' style='position:relative'><span style='position:absolute;width:100%;height:100%;top:0;left:0,z-index:2'></span> ".$mentionUsername." </a> ";
                            if(strpos($reqQuotedTweet['content'],'id='.$reqId.'"') == false){
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
                    // if the quoted tweet of the status tweet is a com, then find who does it respond to 
                    if($reqQuotedTweet['comment']){
                        $t['quotedResponseTo'] = [];
                        $allAboveQuotedTweets = [];
                        $currentTweet = $reqQuotedTweet;
            
                        $isComment = $tweetsManager->getTweet($reqQuotedTweet['id'])->fetch()['comment'];
                    
                        while($isComment){
                            $reqAboveTweet = $tweetsManager->getTweet($currentTweet['commentof_id'])->fetch();
                            array_unshift($allAboveQuotedTweets, $reqAboveTweet);
                            $currentTweet = $reqAboveTweet;
                            $isComment = $tweetsManager->getTweet($currentTweet['id'])->fetch()['comment'];  
                        }
                        foreach($allAboveQuotedTweets as $prev){
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
                }
                // if the status tweet is a comment, get the infos about who does it responds to
                if($t['comment']){
                    $t['responseTo'] = [];
                    for($i=$key-1 ; $i>=0; $i--){
                        $reqUserNameUsername = $usersManager->getUserNameUsername($allAboveTweets[$i]['id_user'])->fetch();
                        $usernames = [];
                        foreach($t['responseTo'] as $o){
                            array_push($usernames,$o['username']);
                        }
                        if ( !in_array($reqUserNameUsername['username'],$usernames)){
                            array_push($t['responseTo'],[ 'username' => $reqUserNameUsername['username'], 'id'=>$allAboveTweets[$i]['id_user'] ]);
                        }
                    }
                    
                }
                array_push($allAboveTweetsWInfos, $t); 
            }
    
            
            
    
    
            /******* Get all the comments and their infos ****************************/
            $allCommentsWInfos = [];
    
            $reqComments = $tweetsManager->getTweetComments($tweet['id']);
    
    
            foreach($reqComments as $t){
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
                array_push($allCommentsWInfos, $t); 
            } 
            uasort($allCommentsWInfos,function($a,$b){
                if ($a == $b){
                    return 0;
                }
                return ($a['date_hour_creation']< $b['date_hour_creation']) ? -1: 1;
            });

            require_once('views/statusView.php');
        }else{
            header('Location: '.$baseURI.'home');
        }
    }else{
        die("Erreur : La page recherchée n'existe pas");
    }
}else{
    die("Erreur : La page recherchée n'existe pas");
}
    