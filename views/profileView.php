<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  
  <title>twitter Clone</title>
  <meta name="description" content="Clone de Twitter">
  <script src="./js/modal.js" defer></script>
 </head>


<body>

    <?php require('includes/nav.php') ?>
    <div class="modal" id="modal1">
        <div class="modal__content">
            <span class="modalClose" id="modalClose1">close</span>
            <br/>
            <form  method="POST" action="" enctype="multipart/form-data" >
                <label for="bio"> Votre biographie :</label>
                <input type="text" placeholder="Votre biographie" id="bio" name="bio" value="<?php if (isset($reqUser['bio'])) {echo $reqUser['bio'];} ?>" />
                <input type="file" id="cover" name="cover" >
                <button type="submit" name="updateProfile" id="sumbitUpdateProfile">Enregistrer</button>
                <br/>
                <?php if (isset($error)) {
                echo '<font color="red">' . $error . '</font>';
                } ?>
            
            </form>
        </div>
    </div>

    <main class='homeContainer'>
        <div>
            <p><?= $reqUser['name']?></p>
            <p><?= $nbTweets ?> Tweets</p>
        </div>
        <div>
            <img src='./public/img/<?= $reqUser['imgcover']?>' alt="profile image" class="coverImg"> 
            <img src='./public/img/<?= $reqUser['img']?>' alt="profile image" class="profileImg"> 
            <p> <?= $reqUser['name']?> </p>
            <p> @ <?= $reqUser['username']?> </p>
            <p> <?= $reqUser['bio']?> </p>
            <button class="modalBtn" id="modalBtn1">Configurer le profil </button>
        </div>
        <div>
            <p> <?= $nbFollowing ?> abonnements  </p>
            <p> <?= $nbFollowers ?> abonnées</p>
            <p> A rejoint Twitter en <?= $reqUser['date_hour_creation']?> </p>
        </div>

        
    </main>


</body>
</html>