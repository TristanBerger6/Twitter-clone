<?php
 /**
 * receive ajax call to like or unlike a tweet. 
 */
 
 require_once("models/LikesManager.php");
 
 $likesManager = new LikesManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
 
 if (isset($_SESSION['id'])){
     if (isset($_GET['unlike'])){
             
         $res= receive_fetch_body();
         $idTweet = $res['id_tweet']; 
         $isLiked = $likesManager->isLiked($_SESSION['id'], $idTweet)->rowCount();
         if( $isLiked == 0){
            $reqUnlike = $likesManager->unlikeTweet($_SESSION['id'],$idTweet);
         } 
         send_fetch_response($idTweet); 
     }
     if (isset($_GET['like'])){
        $res= receive_fetch_body();
        $idTweet = $res['id_tweet']; 
        $isLiked = $likesManager->isLiked($_SESSION['id'], $idTweet)->rowCount();
        if( $isLiked == 0){
            $reqLike = $likesManager->likeTweet($_SESSION['id'],$idTweet);
        }
        send_fetch_response($idTweet); 
     }
 }