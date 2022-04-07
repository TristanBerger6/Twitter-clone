<?php
/**
 * receive ajax call to check wether a mention match a user of the db. 
 */
 require_once("models/UsersManager.php");

 $usersManager = new UsersManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);


 if (isset($_SESSION['id'])){
     // AJAX ask to look for possible mentions
         
    $res= receive_fetch_body();
    $stringToCheck = $res['stringToCheck'].'%'; 
    if(strlen($stringToCheck)>= 2){
        $reqPossibleUsers = $usersManager->getUserUsernameStartingWith($stringToCheck)->fetchAll();
    }else{
        $reqPossibleUsers = [];
    }
    send_fetch_response($reqPossibleUsers);   
     
 }