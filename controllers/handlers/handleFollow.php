 <?php
 
require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");

$usersManager = new UsersManager();
$followsManager = new FollowsManager();
$tweetsManager = new TweetsManager();

if (isset($_SESSION['id'])){
    // AJAX ask for follow or unfollow 
    if (isset($_GET['unfollow'])){
            
        $res= receive_fetch_body();
        $id_to_unfollow = $res['user_to_unfollow']; 
        $reqUnfollow = $followsManager->unfollow($_SESSION['id'],$id_to_unfollow);
        send_fetch_response($id_to_unfollow);  
    }
    if (isset($_GET['follow'])){
        
        $res= receive_fetch_body();
        $id_to_follow = $res['user_to_follow']; 
        $reqFollow = $followsManager->follow($_SESSION['id'],$id_to_follow);
        send_fetch_response($id_to_follow);  
    }
}