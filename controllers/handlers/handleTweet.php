<?php 
 /**
 * receive ajax call to create new tweet.  
 */

require_once("models/UsersManager.php");
require_once("models/TweetsManager.php");
require_once("models/MentionsManager.php");

$usersManager = new UsersManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
$tweetsManager = new TweetsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
$mentionsManager = new MentionsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);


if (isset($_SESSION['id'])){
    if( isset($_GET['postTweet']) ){
    
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
                    $insTweet = $tweetsManager->newTweet($_SESSION['id'],$tweetText,$resName)->fetch();
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
                    $insTweet = $tweetsManager->newTweet($_SESSION['id'],$tweetText,"")->fetch();
                    foreach($mentionedIds as $mentionedId){
                        $insMention = $mentionsManager->setMention($_SESSION['id'],$mentionedId,$insTweet['NewID']);
                    }
                    // send response to js that is gonna reload the page
                    send_fetch_response('created');
                }
            }
        }else{
            $error = 'Le tweet ne peut pas dépasser 140 caractères <br/>';
            // send response to js that is gonna display an error
            send_fetch_response(['error'=> $error]);
        }
    }
    
}