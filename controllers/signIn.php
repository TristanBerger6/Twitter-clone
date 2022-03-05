<?php 

require_once("models/User.php");
$user = new User();


if (isset($_POST['formConnect'])) {
    $mailConnect = htmlspecialchars($_POST['mailConnect']);
    $passConnect = $_POST['passConnect'];
    if (!empty($mailConnect) AND !empty($passConnect)) {
      $passConnect = sha1($passConnect);
      $requser = $user->getMailPass($mailConnect,$passConnect);
      $userExists = $requser->rowCount();
      if ($userExists == 1) {
        $userInfo = $requser->fetch();
        $_SESSION['id'] = $userInfo['id'];
        $_SESSION['username'] = $userInfo['username'];
        $_SESSION['mail'] = $userInfo['mail'];
        header('Location: index.php?page=home');
      } else {
        $error = 'Email et/ou mot de passe est incorrect(s).';
      }
    } else {
      $error = 'Tous les champs doivent être complétés.';
    }
  }

  require_once(ROOT.'views/signinView.php');