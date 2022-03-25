<?php 

require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");
require_once("models/RetweetsManager.php");
require_once("models/LikesManager.php");
require_once("models/MentionsManager.php");

$usersManager = new UsersManager();
$followsManager = new FollowsManager();
$tweetsManager = new TweetsManager();
$retweetsManager = new RetweetsManager();
$likesManager = new LikesManager();
$mentionsManager = new MentionsManager();

if (isset($_SESSION['id'])){
    $reqUser = $usersManager->getUser($_SESSION['id']);
    $reqUser = $reqUser->fetch();
    $reqMyTweets = $tweetsManager->getTweets($_SESSION['id']);

    $allNotifs = [];

    
    foreach($reqMyTweets as $t){
        // get all the retweets of this tweet
        $retweetsOfTweet = $retweetsManager->getRetweetsOfTweet($t['id']);
        foreach($retweetsOfTweet as $rt){
            if($rt['id_user'] !== $_SESSION['id']){
                $tmp = null;
                $tmp['type'] = 'retweet';
                $tmp['foreign_name'] = $usersManager->getUser($rt['id_user'])->fetch()['name'];
                $tmp['foreign_profile'] = $usersManager->getUser($rt['id_user'])->fetch()['img'];
                $tmp['foreign_id'] = $rt['id_user'];
                $tmp['id_tweet'] = $t['id'];
                $tmp['date'] = $rt['date_hour_creation'];
                array_push($allNotifs, $tmp);
            }
        }

         // get all the quotes of this tweet
        $quotedFromTweet = $tweetsManager->getQuotedFromTweet($t['id']);
        foreach($quotedFromTweet as $q){
            if($q['id_user'] !== $_SESSION['id']){
                $tmp = null;
                $tmp['type'] = 'quote';
                $tmp['foreign_name'] = $usersManager->getUser($q['id_user'])->fetch()['name'];
                $tmp['foreign_profile'] = $usersManager->getUser($q['id_user'])->fetch()['img'];
                $tmp['foreign_id'] = $q['id_user'];
                $tmp['id_tweet'] = $q['id'];
                $tmp['date'] = $q['date_hour_creation'];
                array_push($allNotifs, $tmp);
            }
        }

        // get all the comments of this tweet
        $commentOfTweet = $tweetsManager->getCommentsOfTweet($t['id']);
        foreach($commentOfTweet as $c){
            if($c['id_user'] !== $_SESSION['id']){
                $tmp = null;
                $tmp['type'] = 'comment';
                $tmp['foreign_name'] = $usersManager->getUser($c['id_user'])->fetch()['name'];
                $tmp['foreign_profile'] = $usersManager->getUser($c['id_user'])->fetch()['img'];
                $tmp['foreign_id'] = $c['id_user'];
                $tmp['id_tweet'] = $c['id'];
                $tmp['date'] = $c['date_hour_creation'];
                array_push($allNotifs, $tmp);
            }
        }

        // get all the likes of this tweet
        $reqLikes = $likesManager->getUserTweetLikes($_SESSION['id']);
        foreach($reqLikes as $like){
            if($like['id_user'] !== $_SESSION['id']){
                $tmp = null;
                $tmp['type'] = 'like';
                $tmp['foreign_name'] = $usersManager->getUser($like['id_user'])->fetch()['name'];
                $tmp['foreign_profile'] = $usersManager->getUser($like['id_user'])->fetch()['img'];
                $tmp['foreign_id'] = $like['id_user'];
                $tmp['id_tweet'] = $like['id_tweet'];
                $tmp['date'] = $like['date_hour_creation'];
                array_push($allNotifs, $tmp);
            }
        }
    }

    // get all the mentions of the user
    $reqMentions = $mentionsManager->getUserMentions($_SESSION['id']);
    foreach($reqMentions as $mention){
        if($mention['mentionfrom_id'] !== $_SESSION['id']){
            $tmp = null;
            $tmp['type'] = 'mention';
            $tmp['foreign_name'] = $usersManager->getUser($mention['mentionfrom_id'])->fetch()['name'];
            $tmp['foreign_profile'] = $usersManager->getUser($mention['mentionfrom_id'])->fetch()['img'];
            $tmp['foreign_id'] = $mention['mentionfrom_id'];
            $tmp['id_tweet'] = $mention['id_tweet'];
            $tmp['date'] = $mention['date_hour_creation'];
            array_push($allNotifs, $tmp);
        }
    }

    // get all the follows of the user
    $reqFollows = $followsManager->getFollowers($_SESSION['id']);
    foreach($reqFollows as $follow){
        if($follow['id_follower'] !== $_SESSION['id']){
            $tmp = null;
            $tmp['type'] = 'follow';
            $tmp['foreign_name'] = $usersManager->getUser($follow['id_follower'])->fetch()['name'];
            $tmp['foreign_profile'] = $usersManager->getUser($follow['id_follower'])->fetch()['img'];
            $tmp['foreign_id'] = $follow['id_follower'];
            $tmp['id_tweet'] = "";
            $tmp['date'] = $follow['date_hour_creation'];
            array_push($allNotifs, $tmp);
        }
    }

    // sort by date
    uasort($allNotifs,function($a,$b){
        if ($a == $b){
            return 0;
        }
        return ($a['date']> $b['date']) ? -1: 1;
    });

    foreach($allNotifs as $key => $t){
        $allNotifs[$key]['date'] = get_time_ago_fr($t['date']);
    }
    
    





  

    

    

    require_once(ROOT.'views/notifsView.php');

}else{
    die("Erreur : La page recherchée n'existe pas");
}



