<?php 

require_once("models/UsersManager.php");
$usersManager = new UsersManager();




if (isset($_POST['signinform'])) {
    $name = htmlspecialchars($_POST['name']);
    $username = htmlspecialchars($_POST['username']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $pass = sha1($_POST['pass']);
    $pass2 = sha1($_POST['pass2']);
    if (
      !empty($_POST['name']) and
      !empty($_POST['username']) and
      !empty($_POST['mail']) and
      !empty($_POST['mail2']) and
      !empty($_POST['pass']) and
      !empty($_POST['pass2'])
    ) {
      $woSpace = str_replace(' ','',$username);
      if($woSpace == $username){
        $usernamelength = strlen($username);
        $namelength = strlen($name);
        if ($usernamelength <= 40 && $namelength <= 40) {
          if ($mail == $mail2) {
            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
              $reqMail = $usersManager->getMail($mail);
              $reqUsername = $usersManager->getUsername($username);
              $mailExists = $reqMail->rowCount();
              $usernameExists = $reqUsername->rowCount();
              if ($mailExists == 0) {
                if ($usernameExists == 0) {
                  if ($pass == $pass2) {
                    $insertuser = $usersManager->setAll($name,$username,$mail,$pass);
                    $error =
                      "Votre compte a bien été créé. <a href=\"index.php?page=signin\">Me connecter</a>";
                  } else {
                    $error = 'Les mots de passes ne correspondent pas.';
                  }
                } else {
                  $error = 'Pseudo déjà utilisé.';
                }
              } else {
                $error = 'Adresse email déjà utilisée.';
              }
            } else {
              $error = "Adresse email non valide.";
            }
          } else {
            $error = 'Les adresses email ne correspondent pas !';
          }
        } else {
          $error = 'Le nom et le pseudo ne doivent pas dépasser 40 caractères !';
        }
          
      }else{
          $error ='Le pseudo ne doit pas contenir d\'espaces <br/>';
      }  
    } else {
      $error = 'Tous les champs doivent être complétés.';
    }
  }



    require_once(ROOT.'views/signupView.php');
