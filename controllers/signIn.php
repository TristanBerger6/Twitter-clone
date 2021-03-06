<?php 

require_once("models/UsersManager.php");
$usersManager = new UsersManager($HOST,$DB_NAME,$USERNAME,$PASSWORD);


if (isset($_POST['formConnect'])) {
    $mailConnect = htmlspecialchars($_POST['mailConnect']);
    $passConnect = $_POST['passConnect'];
    if (!empty($mailConnect) AND !empty($passConnect)) {
      $passConnect = sha1($passConnect);
      $requser = $usersManager->getMailPass($mailConnect,$passConnect);
      $userExists = $requser->rowCount();
      if ($userExists == 1) {
        $userInfo = $requser->fetch();
        $_SESSION['id'] = $userInfo['id'];
        $_SESSION['username'] = $userInfo['username'];
        $_SESSION['mail'] = $userInfo['mail'];
        header('Location: '.$baseURI.'home');
      } else {
        $error = 'Email et/ou mot de passe incorrect(s).';
      }
    } else {
      $error = 'Tous les champs doivent être complétés.';
    }
  }
  if (isset($_POST['visitor'])) {
    $mailConnect = htmlspecialchars('user@user.com');
    $passConnect = '0000';
    if (!empty($mailConnect) AND !empty($passConnect)) {
      $passConnect = sha1($passConnect);
      $requser = $usersManager->getMailPass($mailConnect,$passConnect);
      $userExists = $requser->rowCount();
      if ($userExists == 1) {
        $userInfo = $requser->fetch();
        $_SESSION['id'] = $userInfo['id'];
        $_SESSION['username'] = $userInfo['username'];
        $_SESSION['mail'] = $userInfo['mail'];
        header('Location: '.$baseURI.'home');
      } else {
        $error = 'Email et/ou mot de passe incorrect(s).';
      }
    } else {
      $error = 'Tous les champs doivent être complétés.';
    }
  }

  require_once('views/signinView.php');