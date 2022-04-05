<?php
 /**
 * receive ajax call to retweet a tweet. 
 */

 require_once("models/RetweetsManager.php");
 
 $retweetsManager = new RetweetsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
 
 if (isset($_SESSION['id'])){
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