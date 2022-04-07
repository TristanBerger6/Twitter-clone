<?php
/**
 * receive ajax call to get users that liked the status
 */
 require_once("models/UsersManager.php");
 require_once("models/LikesManager.php");
 require_once("models/RetweetsManager.php");

 $usersManager = new UsersManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
 $likesManager = new LikesManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
 $retweetsManager = new RetweetsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);


 if (isset($_SESSION['id'])){
     // AJAX ask to look for possible mentions

     if(isset($_GET['type']) && $_GET['type'] == 'likes'){
        $res= receive_fetch_body();
        $idTweet = $res['id_tweet']; 
        $reqLikes = $likesManager->getTweetLikes($idTweet);
        $usersToDisplay = [];
        foreach($reqLikes as $like){
            $idUserLiking = $like['id_user'];
            if( !isset($usersToDisplay[$idUserLiking])){
                $reqUserToDisplay = $usersManager->getUser($idUserLiking)->fetch();
                $usersToDisplay[$idUserLiking] = $reqUserToDisplay;
            }
        }
        
     }
     if(isset($_GET['type']) && $_GET['type'] == 'rt'){
        $res= receive_fetch_body();
        $idTweet = $res['id_tweet']; 
        $reqRt = $retweetsManager->getRetweetsOfTweet($idTweet);
        $usersToDisplay = [];
        foreach($reqRt as $rt){
            $idUserRt = $rt['id_user'];
            if( !isset($usersToDisplay[$idUserRt])){
                $reqUserToDisplay = $usersManager->getUser($idUserRt)->fetch();
                $usersToDisplay[$idUserRt] = $reqUserToDisplay;
            }
        }
     }
     $toSend= [];
     foreach($usersToDisplay as $u){
         array_push($toSend, $u);
     }
     send_fetch_response($toSend); 
         
    
     
 }