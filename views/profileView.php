<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <title>twitter Clone</title>
  <meta name="description" content="Clone de Twitter">
  <script src="./js/js_ajax/postTweet.js" type="module" defer></script>
  <script src="./js/js_ajax/follow.js" type="module" defer></script>
  <script src="./js/modules/modules.js" type="module" defer></script>
  <?php if($_SESSION['id'] === $_GET['id']){ ?>
    <script src="./js/js_ajax/updateProfile.js" type="module" defer></script>
  <?php } ?>
  
 </head>


<body>

    <?php require('includes/nav.php') ?>

    <?php if($_SESSION['id'] === $_GET['id']){ ?>
    <div class="modal" id="modal2">
        <div class="modal__content">
            <span class="modalClose" id="modalClose2">close</span>
            <br/>
            <form  method="POST" action="" id="formUpdate" enctype="multipart/form-data" >
                <label for="name"> Votre Nom :</label>
                <input type="text" placeholder="Votre Nom" id="name" name="name" value="<?php if (isset($reqUser['name'])) {echo $reqUser['name'];} ?>" />
                <label for="username"> Votre Pseudo :</label>
                <input type="text" placeholder="Votre Pseudo" id="username" name="username" value="<?php if (isset($reqUser['username'])) {echo $reqUser['username'];} ?>" />
                <label for="bio"> Votre biographie :</label>
                <input type="text" placeholder="Votre biographie" id="bio" name="bio" value="<?php if (isset($reqUser['bio'])) {echo $reqUser['bio'];} ?>" />
                <div > 
                    <img class="preview-input cover-img" id="preview-input2" src='./public/img/cover/<?= $reqUser['imgcover']?>' alt="cover image preview">
                </div>
                <label for="input-img2" class="label-input"> Votre cover :</label>
                <input type="file" id="input-img2" name="cover" class="input-img" >
                <div > 
                    <img class="preview-input profile-img" id="preview-input3" src='./public/img/profile/<?= $reqUser['img']?>' alt="profile image preview">
                </div>
                <label for="input-img3" class="label-input"> Votre profil :</label>
                <input type="file" id="input-img3" name="profile" class="input-img" >
                <button type="submit" name="updateProfile" id="submitUpdateProfile" >Enregistrer</button>
                <br/>
                <div id="update-error"></div>
               
            
            </form>
        </div>
    </div>
    <?php } ?>

    <main class='homeContainer'>
        <div>
            <p><?= $reqUser['name']?></p>
            <p><?= $nbTweets ?> Tweets</p>
        </div>
        <div>
            <img src='./public/img/cover/<?= $reqUser['imgcover']?>' alt="profile image" class="cover-img"> 
            <img src='./public/img/profile/<?= $reqUser['img']?>' alt="profile image" class="profile-img"> 
            <p> <?= $reqUser['name']?> </p>
            <p> @ <?= $reqUser['username']?> </p>
            <p> <?= $reqUser['bio']?> </p>
            <?php if($_SESSION['id'] === $_GET['id']){ ?>
                <button class="modalBtn" id="modalBtn2" >Editer le profil </button>
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