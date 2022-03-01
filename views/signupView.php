<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  
  <title>twitter Clone</title>
  <meta name="description" content="Clone de Twitter">
 </head>

<body >

    <a href='index.php'> Retour </a>

    <form method="POST" action="" class="signCard">
        <label for="name"> Nom :</label>
        <input type="text" placeholder="Votre nom" id="name" name="name" value="<?php if (
                       isset($name)
                     ) {
                       echo $name;
                     } ?>" />
        <label for="username">Pseudo :</label>
        <input type="text" placeholder="Votre pseudo" id="username" name="username" value="<?php if (
                       isset($username)
                     ) {
                       echo $username;
                     } ?>" />
        <label for="mail">Mail :</label>
        <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if (
                       isset($mail)
                     ) {
                       echo $mail;
                     } ?>" />
        <label for="mail2">Confirmation du mail :</label>
        <input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if (
                       isset($mail2)
                     ) {
                       echo $mail2;
        } ?>" />
         <label for="pass">Mot de passe :</label>
         <input type="password" placeholder="Votre mot de passe" id="pass" name="pass" />
         <label for="pass2">Confirmation du mot de passe :</label>
         <input type="password" placeholder="Confirmez votre mot de passe" id="pass2" name="pass2" />
         <input type="submit" name="signinform" value="Je m'inscris" />
         <?php if (isset($error)) {
           echo '<font color="red">' . $error . '</font>';
        } ?>

        <br/>
        <p>Déjà un compte ? <a href='index.php?page=signin'> Connectez-vous </a></p>
    
    </form>
 



</body>
</html>