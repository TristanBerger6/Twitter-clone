<!DOCTYPE html>
<html lang="fr">
<head>
  <base href=<?= $baseURI?>>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <title>twitter Clone</title>
  <meta name="description" content="Clone de Twitter">
  <script src="./js/globalPostTweet.js" type="module" defer></script>
  <script src="./js/displayTweets.js" type="module" defer></script>
  <?php if($_SESSION['id'] === $_GET['id']){ ?>
    <script src="./js/updateProfile.js" type="module" defer></script>
  <?php } ?>
  
 </head>


<body class='connected-page'>
    <div class="connected-page__container">
        <?php require('includes/nav.php') ?>
        <?php if($_SESSION['id'] === $_GET['id']){ ?>
        <div class="modal modal6 profile-modal" >
            <div class="modal__content">
                <form  method="POST" action="" id="formUpdate" enctype="multipart/form-data" >
                    <div class="profile-modal__header flex">
                        <span class="modalClose modalClose6 modal__close" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="rgb(255,255,255)" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"/></svg></span>
                        <button class="basic-btn basic-btn--white fw-700" type="submit" name="updateProfile" id="submitUpdateProfile" >Enregistrer</button>
                    </div>
                    <div class="profile-modal__cover"> 
                        <img class="preview-input" id="preview-input6" src='./public/img/cover/<?= $reqUser['imgcover']?>' alt="cover image preview">
                        <label for="input-img6" class="profile-modal__label"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="rgb(255,255,255)" d="M194.6 32H317.4C338.1 32 356.4 45.22 362.9 64.82L373.3 96H448C483.3 96 512 124.7 512 160V416C512 451.3 483.3 480 448 480H64C28.65 480 0 451.3 0 416V160C0 124.7 28.65 96 64 96H138.7L149.1 64.82C155.6 45.22 173.9 32 194.6 32H194.6zM256 384C309 384 352 341 352 288C352 234.1 309 192 256 192C202.1 192 160 234.1 160 288C160 341 202.1 384 256 384z"/></svg></label>
                        <input type="file" id="input-img6" name="cover" class="input-img" >
                    </div>
                    <div class="profile-modal__profile"> 
                        <img class="preview-input" id="preview-input7" src='./public/img/profile/<?= $reqUser['img']?>' alt="profile image preview">
                        <label for="input-img7" class="profile-modal__label"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="rgb(255,255,255)" d="M194.6 32H317.4C338.1 32 356.4 45.22 362.9 64.82L373.3 96H448C483.3 96 512 124.7 512 160V416C512 451.3 483.3 480 448 480H64C28.65 480 0 451.3 0 416V160C0 124.7 28.65 96 64 96H138.7L149.1 64.82C155.6 45.22 173.9 32 194.6 32H194.6zM256 384C309 384 352 341 352 288C352 234.1 309 192 256 192C202.1 192 160 234.1 160 288C160 341 202.1 384 256 384z"/></svg></label>
                        <input type="file" id="input-img7" name="profile" class="input-img" >
                    </div>
                    <div class="profile-modal__inputs flex"> 
                        <input type="text" placeholder="Votre Nom" id="name" name="name" value="<?php if (isset($reqUser['name'])) {echo $reqUser['name'];} ?>" />
                        <input type="text" placeholder="Votre Pseudo" id="username" name="username" value="<?php if (isset($reqUser['username'])) {echo $reqUser['username'];} ?>" />
                        <textarea class="bio" type="text" placeholder="Votre biographie" id="bio" name="bio"><?php if (isset($reqUser['bio'])) {echo $reqUser['bio'];} ?></textarea>
                    </div>
                    <div class="error" id="update-error"></div>
                </form>
            </div>
        </div>
        <?php } ?>

        <main class='homeContainer'>
            <div class="page-title flex">
                <a href="javascript:history.go(-1)" class="page-title__back" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="rgb(255,255,255)" d="M447.1 256C447.1 273.7 433.7 288 416 288H109.3l105.4 105.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448s-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H416C433.7 224 447.1 238.3 447.1 256z"/></svg></a>
                <a href=""><h1 class="fs-700"><?= $reqUser['name']?></h1></a>
            </div>
            <div class="profile">
                <div class="profile__cover">
                    <img src='./public/img/cover/<?= $reqUser['imgcover']?>' alt="profile image"> 
                </div>
                <div class="profile__profile flex">
                    <div class="profile__profile__img">
                        <img src='./public/img/profile/<?= $reqUser['img']?>' alt="profile image"> 
                    </div>
                    <?php if($_SESSION['id'] === $_GET['id']){ ?>
                        <button class="modalBtn modalBtn6 basic-btn"  ><p class="fw-700">Editer le profil</p> </button>
                    <?php }else{ ?>
                        <?php if($isFollowed){?>
                        <p class="abo fw-700 basic-btn" user_id='<?= $reqUser['id']?>'>Abonné</p>
                        <?php }else{ ?>
                        <p class="noabo fw-700 basic-btn basic-btn--white" user_id='<?= $reqUser['id']?>'>Suivre</p>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="profile__core">
                    <div class="profile__core__name">
                        <p class="fs-600 fw-700"> <?= $reqUser['name']?> </p>
                        <p class="text-light"> @ <?= $reqUser['username']?> </p>
                    </div>
                    <p class="profile__core__bio"> <?= $reqUser['bio']?> </p>
                    <p class="text-light"> A rejoint Twitter en <?= $reqUser['date_hour_creation']?> </p>
                    <div class="profile__core__abos flex">
                        <p> <?php echo '<a class="text-light" href="follow/'.$reqUser['id'].'/followed">'?> <span class="text-white"><?= $nbFollowed ?></span> abonnements </a> </p>
                        <p> <?php echo '<a class="text-light" href="follow/'.$reqUser['id'].'/followers">'?> <span class="text-white"><?= $nbFollowers ?></span> abonnées </a></p>
                    </div>
                    
                </div>
            </div>
            <div class="page-switch flex no-padding fs-400 text-light">
                <a class="text-light <?= empty($_GET['type']) ? 'active':''?>" href='profile/<?=$reqUser['id'] ?>'><p>tweets</p></a>
                <a class="text-light <?= $_GET['type'] == 'with_replies' ? 'active':''?>" href='profile/<?=$reqUser['id'] ?>/with_replies'><p>Tweets et réponses</p></a>
                <a class="text-light <?= $_GET['type'] == 'medias' ? 'active':''?>" href='profile/<?=$reqUser['id'] ?>/medias'><p>Médias</p></a>
                <a class="text-light <?= $_GET['type'] == 'likes' ? 'active':''?>" href='profile/<?=$reqUser['id'] ?>/likes'><p>J'aime</p></a>
            </div>
            <?php $i = 0;
                foreach($allTweetsWInfos as $tweet){
                    $i++;
                    require('includes/tweet.php');
                } 
                require('includes/modalComments.php');
                require('includes/modalQuotes.php');
            ?>  
        </main>
    </div>
</body>
</html>