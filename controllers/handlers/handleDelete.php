<?php 

require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");

$usersManager = new UsersManager();
$followsManager = new FollowsManager();
$tweetsManager = new TweetsManager();

if (isset($_SESSION['id'])){

    if(isset($_GET['tweet']) ){
        $res= receive_fetch_body();
        $idTweet = $res['id_tweet']; 
        $reqDelete = $tweetsManager->deleteTweet($idTweet);
        send_fetch_response($idTweet);  
    }



}