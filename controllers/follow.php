<?php 

require_once("models/User.php");
require_once("models/Follow.php");
require_once("models/Tweet.php");

$user = new User();
$follow = new Follow();
$tweet = new Tweet();


if (isset($_SESSION['id'])){

    if (isset($_GET['unfollow'])){
        
        $res= receive_fetch_body();
        $id_to_unfollow = $res['user_to_unfollow']; 
        $reqUnfollow = $follow->unfollow($_SESSION['id'],$id_to_unfollow);
        send_fetch_response($id_to_unfollow);  
    }
    if (isset($_GET['follow'])){
        
        $res= receive_fetch_body();
        $id_to_follow = $res['user_to_follow']; 
        $reqFollow = $follow->follow($_SESSION['id'],$id_to_follow);
        send_fetch_response($id_to_follow);  
    }


    if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['type']) && $_GET['type']=='followers' || $_GET['type']=='followed'){

        $reqUser = $user->getUser($_GET['id']);
        $reqUser = $reqUser->fetch();
        $usersToDisplay = [];
       

        if($_GET['type']== 'followers'){
            $reqFollowers = $user->getUsersFollowers($reqUser['id']);
            $users = $reqFollowers;
        }
        if($_GET['type']== 'followed'){
            $reqFollowed = $user->getUsersFollowed($reqUser['id']);
            $users = $reqFollowed;
        }

        while($u = $users->fetch()){
            $isFollowed = $follow->isFollowed($_SESSION['id'],$u['user_id']);
            $isFollowed = $isFollowed->rowCount();
            $u['followed']= $isFollowed;
            array_push($usersToDisplay,$u);
        }

       

        require_once(ROOT.'views/followView.php');
    }else{
        die("Erreur : La page recherchée n'existe pas");
    }
}else{
    die("Erreur : La page recherchée n'existe pas");
}



