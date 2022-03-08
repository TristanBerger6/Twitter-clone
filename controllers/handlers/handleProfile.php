<?php 

require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");

$usersManager = new UsersManager();
$followsManager = new FollowsManager();
$tweetsManager = new TweetsManager();

if (isset($_SESSION['id'])){
    // if the user whose connected udapte his profile
    if(isset($_GET['updateProfile'])){
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
            $maxSize = 10000000;
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
            $maxSize = 10000000;
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
            $error .= 'La biographie ne doit pas dépasser 140 caractères <br/>';
        }
        // check for name length 
        $name = htmlspecialchars($_POST['name']);
        $nameLength = strlen($name);
        if($nameLength <= 40){
            $updateName = true;
        }else{
            $error .= 'le nom ne doit pas dépasser 40 caractères <br/>';
        }
        // check for username length
        $username = htmlspecialchars($_POST['username']);
        $usernameLength = strlen($username);
        if($usernameLength <= 40){
            $updateUsername = true;
        }else{
            $error .= 'Le pseudo ne doit pas dépasser 40 caractères <br/>';
        }

        //if all inputs have no errors, then update what needs to be updated
        if($error == ''){
            // for the images, remove the previous image from the folder if it wasn't the default one
            if($updateCover){
                $reqCover = $usersManager->getUserCover($_SESSION['id']);
                $reqCover = $reqCover->fetch();
                if($reqCover['imgcover'] != $usersManager->defaultCover){
                    unlink($target_dirCover.$reqCover['imgcover']);
                }
                $updateCover = $usersManager->updateCover($resNameCover,$_SESSION['id']);
            }
            if($updateProfile){
                $reqProfile = $userManager->getUserProfile($_SESSION['id']);
                $reqProfile = $reqProfile->fetch();
                if($reqProfile['img'] != $usersManager->defaultProfile){
                    unlink($target_dirProfile.$reqProfile['img']);
                }
                $updateProfile = $usersManager->updateProfile($resNameProfile,$_SESSION['id']);
            }
            if($updateBio){
                $update = $usersManager->updateBio($bio,$_SESSION['id']);
            }
            if($updateName){
                $update = $usersManager->updateName($name,$_SESSION['id']);
            }
            if($updateUsername){
                $update = $usersManager->updateUsername($username,$_SESSION['id']);
            }
            // send response to js that is gonna reload the page
            send_fetch_response('updated');
            // if errors appears
        }else{
            // for images, check if a file was uploaded into the folder, if yes, remove it
            if($updateCover == true && $resErrCover == null){
                unlink($target_dirCover.$resNameCover);
            }
            if($updateProfile == true && $resErrProfile == null){
                unlink($target_dirProfile.$resNameProfile);
            }
            // send response to js that is gonna display an error
            send_fetch_response(['error'=> $error]);
          
        }
    }

    
}