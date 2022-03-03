<?php 

require_once("models/User.php");
require_once("models/Follow.php");
require_once("models/Tweet.php");

$user = new User();
$follow = new Follow();
$tweet = new Tweet();


if (isset($_SESSION['id'])){
    if (isset($_GET['id']) && !empty($_GET['id'])){
        if ($_SESSION['id'] === $_GET['id']){

            // if the user whose connected udapte his profile
            if(isset($_POST['name'])){
                $error='';
                $updateProfile = false;
                $updateCover = false;
                $updateBio = false;
                $updateUsername = false;
                $updateName = false;

                // check file and try to upload it into the target folder
                if(isset($_FILES['cover']) && !empty($_FILES['cover']['name'])){
                    $updateCover = true;
                    $target_dirCover = './public/img/cover/';
                    $cover = $_FILES['cover'];
                    $maxSize = 1000000;
                    [$resErrCover, $resNameCover] = image_check_upload($target_dirCover,$cover,$maxSize); 
                    if($resErrCover != null){
                        $error .= $resErrCover;   
                    }
                }
                // check file and try to upload it into the target folder
                if(isset($_FILES['profile']) && !empty($_FILES['profile']['name'])){
                    $updateProfile = true;
                    $target_dirProfile = './public/img/profile/';
                    $profile = $_FILES['profile'];
                    $maxSize = 1000000;
                    [$resErrProfile, $resNameProfile] = image_check_upload($target_dirProfile,$profile,$maxSize); 
                    if($resErrProfile != null){
                        if(!isset($resErrCover)){
                            $error .= $resErrProfile;
                        }
                    }
                }
                // check for bio length 
                $bio = htmlspecialchars($_POST['bio']);
                $bioLength = strlen($bio);
                if($bioLength <= 140){
                    $updateBio = true;
                }else{
                    $error .= 'Votre biographie ne doit pas dépasser 140 caractères <br/>';
                }
                // check for name length 
                $name = htmlspecialchars($_POST['name']);
                $nameLength = strlen($name);
                if($nameLength <= 40){
                    $updateName = true;
                }else{
                    $error .= 'Votre Nom ne doit pas dépasser 40 caractères <br/>';
                }
                // check for username length
                $username = htmlspecialchars($_POST['username']);
                $usernameLength = strlen($username);
                if($usernameLength <= 40){
                    $updateUsername = true;
                }else{
                    $error .= 'Votre Pseudo ne doit pas dépasser 40 caractères <br/>';
                }

                //if all inputs have no errors, then update what needs to be updated
                if($error == ''){
                    // for the images, remove the previous image from the folder if it wasn't the default one
                    if($updateCover){
                        $reqCover = $user->getUserCover($_SESSION['id']);
                        $reqCover = $reqCover->fetch();
                        if($reqCover['imgcover'] != $user->defaultCover){
                            unlink($target_dirCover.$reqCover['imgcover']);
                        }
                        $updateCover = $user->updateCover($resNameCover,$_SESSION['id']);
                    }
                    if($updateProfile){
                        $reqProfile = $user->getUserProfile($_SESSION['id']);
                        $reqProfile = $reqProfile->fetch();
                        if($reqProfile['img'] != $user->defaultProfile){
                            unlink($target_dirProfile.$reqProfile['img']);
                        }
                        $updateProfile = $user->updateProfile($resNameProfile,$_SESSION['id']);
                    }
                    if($updateBio){
                        $update = $user->updateBio($bio,$_SESSION['id']);
                    }
                    if($updateName){
                        $update = $user->updateName($name,$_SESSION['id']);
                    }
                    if($updateUsername){
                        $update = $user->updateUsername($username,$_SESSION['id']);
                    }
                    // if errors appears
                }else{
                    // for images, check if a file was uploaded into the folder, if yes, remove it
                    if($updateCover == true && $resErrCover == null){
                        unlink($target_dirCover.$resNameCover);
                    }
                    if($updateProfile == true && $resErrProfile == null){
                        unlink($target_dirProfile.$resNameProfile);
                    }
                    // js to show the modal with the errors displayed
                    $error .= '<script> 
                    document.getElementById("modal1").style.display = "block";
                    </script>';
                }
            }
        }

        $reqUser = $user->getUser($_GET['id']);
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
}else{
    header('Location: index.php');
}
    