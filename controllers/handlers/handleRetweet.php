<?php
 

 require_once("models/RetweetsManager.php");
 
 $retweetsManager = new RetweetsManager();
 
 if (isset($_SESSION['id'])){
     // AJAX ask for follow or unfollow 
     if (isset($_GET['unretweet'])){
             
         $res= receive_fetch_body();
         $idTweet = $res['id_tweet']; 
         $reqUnretweet = $retweetsManager->unretweet($_SESSION['id'],$idTweet);
         send_fetch_response($idTweet);  
     }
     if (isset($_GET['retweet'])){
        $res= receive_fetch_body();
        $idTweet = $res['id_tweet']; 
        $reqRetweet = $retweetsManager->retweet($_SESSION['id'],$idTweet);
        send_fetch_response($idTweet); 
     }
 }