<?php 

require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");


$usersManager = new UsersManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);
$followsManager = new FollowsManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);




if (isset($_SESSION['id'])){

    if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['type']) && $_GET['type']=='followers' || $_GET['type']=='followed'){

        $reqUser = $usersManager->getUser($_GET['id']);
        $reqUser = $reqUser->fetch();
        $usersToDisplay = [];
       

        if($_GET['type']== 'followers'){
            $reqFollowers = $usersManager->getUsersFollowers($reqUser['id']);
            $users = $reqFollowers;
        }
        if($_GET['type']== 'followed'){
            $reqFollowed = $usersManager->getUsersFollowed($reqUser['id']);
            $users = $reqFollowed;
        }

        while($u = $users->fetch()){
            $isFollowed = $followsManager->isFollowed($_SESSION['id'],$u['user_id']);
            $isFollowed = $isFollowed->rowCount();
            $u['followed']= $isFollowed;
            array_push($usersToDisplay,$u);
        }
        require_once('views/followView.php');
    }else{
        die("Erreur : La page recherchée n'existe pas");
    }
}else{
    die("Erreur : La page recherchée n'existe pas");
}



