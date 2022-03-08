<?php 

require_once("models/UsersManager.php");
require_once("models/FollowsManager.php");
require_once("models/TweetsManager.php");

$usersManager = new UsersManager();
$followsManager = new FollowsManager();
$tweetsManager = new TweetsManager();


if (isset($_SESSION['id'])){

    if(isset($_POST['updateMail']) ){
        $mail = htmlspecialchars($_POST['mail']);
        $reqUser = $usersManager->getUser($_SESSION['id']);
        $reqUser = $reqUser->fetch();

        if(!empty($_POST['mail'])){
            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $updateMail = $usersManager->updateMail($mail,$reqUser['id']);
                $error = 'Votre adresse email à bien été modifiée.';
            }else{
                $error = ' Adresse email non valide.';
            }
        }else{
            $error = 'Tous les champs doivent être complétés.';
        }
    }
    if(isset($_POST['updatePass']) ){
        $pass = sha1($_POST['pass']);
        $newPass = sha1($_POST['newPass']);
        $newPass2 = sha1($_POST['newPass2']);

        if(!empty($_POST['pass']) && !empty($_POST['pass']) && !empty($_POST['pass'])){
            $reqUser = $usersManager->getUser($_SESSION['id']);
            $reqUser = $reqUser->fetch();
            if($reqUser['password'] == $pass){
                if($newPass == $newPass2){
                    if($newPass != $pass){
                        $updatePass = $usersManager->updatePass($newPass,$reqUser['id']);
                        $errorPass = 'Votre mot de passe à bien été modifié.';

                    }else{
                        $errorPass = 'Le nouveau mot de passe ne peut pas être le même que le mot de passe existant.'; 
                    }
                }else{
                    $errorPass = 'Les mots de passes ne correspondent pas.';
                }
            }else{
                $errorPass = 'Le mot de passe actuel que vous avez saisi est incorrect';
            }
        }else{
            $errorPass = 'Tous les champs doivent être complétés.';
        }
    }

    $reqUser = $usersManager->getUser($_SESSION['id']);
    $reqUser = $reqUser->fetch();

    require_once(ROOT.'views/settingsView.php');
}else{
    die("Erreur : La page recherchée n'existe pas");
}