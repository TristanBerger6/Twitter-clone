<?php 

$db = new PDO('mysql:host=localhost:3307;dbname=twitter_clone;charset=utf8', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


try{
if (isset($_POST['forminscription'])) {
    $name = htmlspecialchars($_POST['name']);
    $username = htmlspecialchars($_POST['username']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp = sha1($_POST['mdp']);
    $mdp2 = sha1($_POST['mdp2']);
    if (
      !empty($_POST['name']) and
      !empty($_POST['username']) and
      !empty($_POST['mail']) and
      !empty($_POST['mail2']) and
      !empty($_POST['mdp']) and
      !empty($_POST['mdp2'])
    ) {
      $usernamelength = strlen($username);
      $namelength = strlen($name);
      if ($usernamelength <= 40 && $namelength <= 40) {
        if ($mail == $mail2) {
          if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $reqmail = $db->prepare('SELECT * FROM users WHERE email = ?');
            $reqpseudo = $db->prepare('SELECT * FROM users WHERE username = ?');
            $reqmail->execute([$mail]);
            $reqpseudo->execute([$username]);
            $mailexist = $reqmail->rowCount();
            $pseudoexist = $reqpseudo->rowCount();
            if ($mailexist == 0) {
              if ($pseudoexist == 0) {
                if ($mdp == $mdp2) {
                  $insertuser = $db->prepare(
                    'INSERT INTO users(name,username, email, password, img, imgcover, bio, date_hour_creation) VALUES(?,?,?,?,"","","",NOW())'
                  );

                  $insertuser->execute([$name,$username,$mail,$mdp]); 
                  $erreur =
                    "Votre compte a bien été créé ! <a href=\"index.php?page=signin\">Me connecter</a>";
                } else {
                  $erreur = 'Vos mots de passes ne correspondent pas !';
                }
              } else {
                $erreur = 'Pseudo déjà utilisé !';
              }
            } else {
              $erreur = 'Adresse mail déjà utilisée !';
            }
          } else {
            $erreur = "Votre adresse mail n'est pas valide !";
          }
        } else {
          $erreur = 'Vos adresses mail ne correspondent pas !';
        }
      } else {
        $erreur = 'Votre nom et votre pseudo ne doivent pas dépasser 40 caractères !';
      }
    } else {
      $erreur = 'Tous les champs doivent être complétés !';
    }
  }
}catch(PDOException $e){
    echo $e->getMessage();
}

    require_once(ROOT.'views/signupView.php');
