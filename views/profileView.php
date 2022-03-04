<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  
  <title>twitter Clone</title>
  <meta name="description" content="Clone de Twitter">
  <script src="./js/modal.js" defer></script>
  <script src="./js/previewImages.js" defer></script>
  <script src="./js/follow.js" type="module" defer></script>
 </head>


<body>

    <?php require('includes/nav.php') ?>
    <div class="modal" id="modal1">
        <div class="modal__content">
            <span class="modalClose" id="modalClose1">close</span>
            <br/>
            <form  method="POST" action="" enctype="multipart/form-data" >
                <label for="name"> Votre Nom :</label>
                <input type="text" placeholder="Votre Nom" id="name" name="name" value="<?php if (isset($reqUser['name'])) {echo $reqUser['name'];} ?>" />
                <label for="username"> Votre Pseudo :</label>
                <input type="text" placeholder="Votre Pseudo" id="username" name="username" value="<?php if (isset($reqUser['username'])) {echo $reqUser['username'];} ?>" />
                <label for="bio"> Votre biographie :</label>
                <input type="text" placeholder="Votre biographie" id="bio" name="bio" value="<?php if (isset($reqUser['bio'])) {echo $reqUser['bio'];} ?>" />
                <div > 
                    <img id="cover-preview" src='./public/img/cover/<?= $reqUser['imgcover']?>' alt="cover image preview">
                </div>
                <label for="cover" class="labelInput"> Votre cover :</label>
                <input type="file" id="cover" name="cover" class="imgInput" >
                <div > 
                    <img id="profile-preview" src='./public/img/profile/<?= $reqUser['img']?>' alt="profile image preview">
                </div>
                <label for="profile" class="labelInput"> Votre profil :</label>
                <input type="file" id="profile" name="profile" class="imgInput" >
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
            <img src='./public/img/cover/<?= $reqUser['imgcover']?>' alt="profile image" class="coverImg"> 
            <img src='./public/img/profile/<?= $reqUser['img']?>' alt="profile image" class="profileImg"> 
            <p> <?= $reqUser['name']?> </p>
            <p> @ <?= $reqUser['username']?> </p>
            <p> <?= $reqUser['bio']?> </p>
            <?php if($_SESSION['id'] === $_GET['id']){ ?>
                <button class="modalBtn" id="modalBtn1">Configurer le profil </button>
            <?php }else{ ?>
                <?php if($isFollowed){?>
                <p class="abo" user_id='<?= $reqUser['id']?>'>Abonné</p>
                <?php }else{ ?>
                <p class="noabo" user_id='<?= $reqUser['id']?>'>Suivre</p>
                <?php } ?>
            <?php } ?>
        </div>
        <div>
            <p> <?php echo '<a href="index.php?page=follow&id='.$reqUser['id'].'&type=followed">'?> <?= $nbFollowed ?> abonnements </a> </p>
            <p> <?php echo '<a href="index.php?page=follow&id='.$reqUser['id'].'&type=followers">'?> <?= $nbFollowers ?> abonnées </a></p>
            <p> A rejoint Twitter en <?= $reqUser['date_hour_creation']?> </p>
        </div>

        
    </main>


</body>
</html>