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
     // AJAX ask to look for possible mentions
         
    $res= receive_fetch_body();
    $stringToCheck = $res['stringToCheck'].'%'; 
    $reqPossibleUsers = $usersManager->getUserUsernameStartingWith($stringToCheck)->fetchAll();
    send_fetch_response($reqPossibleUsers);  

         
     
     
 }