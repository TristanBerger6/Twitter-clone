<?php 
/**
 * receive ajax call to delete a tweet. 
 */
require_once("models/TweetsManager.php");

$tweetsManager = new TweetsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);

if (isset($_SESSION['id'])){

    if(isset($_GET['tweet']) ){
        $res= receive_fetch_body();
        $idTweet = $res['id_tweet']; 
        $reqDelete = $tweetsManager->deleteTweet($idTweet);
        send_fetch_response($idTweet);  
    }



}