<?php 

require_once("models/User.php");
require_once("models/Follow.php");
require_once("models/Tweet.php");

$user = new User();
$follow = new Follow();
$tweet = new Tweet();


if (isset($_SESSION['id'])){

   
    if(isset($_POST['updateProfile'])){
        $bio = htmlspecialchars($_POST['bio']);
        $bioLength = strlen($bio);
        
        $cover = $_FILES['cover'];
        var_dump($cover);
      

        if($bioLength <= 140){
            $updateBio = $user->updateBio($bio,$_SESSION['id']);
        }else{
            $error = '<script> 
                document.getElementById("modal1").style.display = "block";
             </script>
             Votre biographie ne doit pas dépasser 140 caractères';
        }
    }

    $reqUser = $user->getUser($_SESSION['id']);
    $reqUser = $reqUser->fetch();
    $month = utf8_encode(strftime('%B', strtotime($reqUser['date_hour_creation'])));
    $year = strftime('%Y', strtotime($reqUser['date_hour_creation']));
    $reqUser['date_hour_creation'] = $month. ' ' . $year;

    $reqTweets = $tweet->getTweets($reqUser['id']);
    $reqFollowers = $follow->getFollowers($reqUser['id']);
    $reqFollowing = $follow->getFollowing($reqUser['id']);

    $nbFollowers = $reqFollowers->rowCount();
    $nbFollowing = $reqFollowing->rowCount(); 
    $nbTweets = $reqTweets->rowCount();

    require_once(ROOT.'views/profileView.php');
}else{
    header('Location: index.php');
}
    