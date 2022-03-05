<?php 

require_once("models/User.php");
require_once("models/Follow.php");
require_once("models/Tweet.php");

$user = new User();
$follow = new Follow();
$tweet = new Tweet();


if (isset($_SESSION['id'])){

    if(isset($_POST['updateMail']) ){
        $mail = htmlspecialchars($_POST['mail']);
        $reqUser = $user->getUser($_SESSION['id']);
        $reqUser = $reqUser->fetch();

        if(!empty($_POST['mail'])){
            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $updateMail = $user->updateMail($mail,$reqUser['id']);
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
            $reqUser = $user->getUser($_SESSION['id']);
            $reqUser = $reqUser->fetch();
            if($reqUser['password'] == $pass){
                if($newPass == $newPass2){
                    if($newPass != $pass){
                        $updatePass = $user->updatePass($newPass,$reqUser['id']);
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

    $reqUser = $user->getUser($_SESSION['id']);
    $reqUser = $reqUser->fetch();

    require_once(ROOT.'views/settingsView.php');
}else{
    die("Erreur : La page recherchée n'existe pas");
}