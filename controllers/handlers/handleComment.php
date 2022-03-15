<?php 

require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");
require_once("models/MentionsManager.php");

$usersManager = new UsersManager();
$followsManager = new FollowsManager();
$tweetsManager = new TweetsManager();
$mentionsManager = new MentionsManager();


if (isset($_SESSION['id'])){
    // if the user whose connected want to post a tweet
    if( isset($_GET['commentTweet']) ){
    
        // check tweet length
        $commentedId = $_POST['commented_id'];
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
                    $insComment = $tweetsManager->newComment($_SESSION['id'],$tweetText,$resName,$commentedId)->fetch();
                    foreach($mentionedIds as $mentionedId){
                        $insMention = $mentionsManager->setMention($_SESSION['id'],$mentionedId,$insTweet['NewID']);
                    }
                    // send response to js that is gonna reload the page
                    send_fetch_response('created');
                }else{
                   // send response to js that is gonna display an error
                    send_fetch_response(['error'=> $resErr]);
                }
            }else{
                if($tweetTextLength !=0){
                    $insTweet = $tweetsManager->newComment($_SESSION['id'],$tweetText,"",$commentedId)->fetch();
                    foreach($mentionedIds as $mentionedId){
                        $insMention = $mentionsManager->setMention($_SESSION['id'],$mentionedId,$insTweet['NewID']);
                    }
                    // send response to js that is gonna reload the page
                    send_fetch_response('created');
                }
            }
        }else{
            $error = 'La réponse ne peut pas dépasser 140 caractères <br/>';
            // send response to js that is gonna display an error
            send_fetch_response(['error'=> $error]);
        }
    }
    
}