<!DOCTYPE html>
<html lang="fr">
<head>
  <base href=<?= $baseURI ?>>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <script src="./js/globalPostTweet.js" type="module" defer></script>
  
  
  <title>twitter Clone</title>
  <meta name="description" content="Clone de Twitter">
 </head>


<body class='connected-page'>
    <div class="connected-page__container">
        <?php require('includes/nav.php') ?>
        <main class='homeContainer'>
            <div class="page-title flex">
                <a href="javascript:history.go(-1)" class="page-title__back" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="rgb(255,255,255)" d="M447.1 256C447.1 273.7 433.7 288 416 288H109.3l105.4 105.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448s-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H416C433.7 224 447.1 238.3 447.1 256z"/></svg></a>
                <p class="fw-700 fs-700">Paramètres</p>     
            </div>
           
            <form  class="settings settings-mail flex" method="POST" action="" enctype="multipart/form-data" >
                <h2 class="fs-600"> Changez d'adresse mail</h2>
                <div> Votre adresse email actuelle est <?= $reqUser['mail'] ?>. Par quelle adresse voulez-vous la remplacer ? Votre adresse email n'apparaît pas dans votre profil public sur Twitter</div>
                <label class="sr-only" for="mail"> Adresse email </label>
                <input type="text" placeholder="Adresse email" id="mail" name="mail" value="<?php if(isset($mail)){ echo $mail;}?>"/>
                <button class="basic-btn fw-700" type="submit" name="updateMail" id="sumbitUpdateMail">Enregistrer</button>
                <?php if (isset($error)) {
                echo '<div class="success">' . $error . '</div>';
                } ?>      
            </form>
            <form  class="settings settings-pass flex" method="POST" action="" enctype="multipart/form-data" >
                <h2 class="fs-600"> Changez de mot de passe</h2>
                <label class="sr-only" for="pass"> mot de passe</label>
                <input type="password" placeholder="Mot de passe actuel" id="pass" name="pass" required/>
                <label class="sr-only" for="newPass"> nouveau mot de passe</label>
                <input type="password" placeholder="Nouveau mot de passe" id="newPass" name="newPass" required/>
                <label class="sr-only" for="newPass2"> nouveau mot de passe répétition</label>
                <input type="password" placeholder="Confirmer le mot de passe" id="newPass2" name="newPass2" required/>
                <button class="basic-btn fw-700" type="submit" name="updatePass" id="sumbitUpdatePass">Enregistrer</button>
                <?php if (isset($errorPass)) {
                echo '<div class="success">' . $errorPass . '</div>';
                } ?>      
            </form>
            
        </main>
    </div>
</body>
</html>