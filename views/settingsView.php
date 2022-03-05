<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  
  <title>twitter Clone</title>
  <meta name="description" content="Clone de Twitter">
 </head>


<body>

    <?php require('includes/nav.php') ?>

    <main class='homeContainer'>
        <div>
        <form  method="POST" action="" enctype="multipart/form-data" >
            <div> Changez d'adresse mail</div>
            <div> Votre adresse email actuelle est <?= $reqUser['mail'] ?>. Par quelle adresse voulez-vous la remplacer ? Votre adresse email n'apparaît pas dans votre profil public sur Twitter</div>
            <label for="mail"> </label>
            <input type="text" placeholder="Adresse email" id="mail" name="mail" value="<?php if(isset($mail)){ echo $mail;}?>"/>
            <button type="submit" name="updateMail" id="sumbitUpdateMail">Enregistrer</button>
            <br/>
            <?php if (isset($error)) {
            echo '<font color="red">' . $error . '</font>';
            } ?>      
        </form>
        <br/>
        <br/>
        <br/>
        <form  method="POST" action="" enctype="multipart/form-data" >
            <div> Changez de mot de passe</div>
            <label for="pass"> </label>
            <input type="password" placeholder="Mot de passe actuel" id="pass" name="pass" required/>
            <label for="newPass"> </label>
            <input type="password" placeholder="Nouveau mot de passe" id="newPass" name="newPass" required/>
            <label for="newPass2"> </label>
            <input type="password" placeholder="Confirmer le mot de passe" id="newPass2" name="newPass2" required/>
            <button type="submit" name="updatePass" id="sumbitUpdatePass">Enregistrer</button>
            <br/>
            <?php if (isset($errorPass)) {
            echo '<font color="red">' . $errorPass . '</font>';
            } ?>      
        </form>
        </div>

        
    </main>


</body>
</html>