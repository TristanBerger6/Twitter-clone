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
  <script src="./js/follow.js" type="module" defer></script>
  <script src="./js/globalPostTweet.js" type="module" defer></script>
 </head>


<body class='connected-page'>
    <div class="connected-page__container">
        <?php require('includes/nav.php') ?>
        <main class='homeContainer'>
            <div class="page-title flex">
                <a href="javascript:history.go(-1)" class="page-title__back" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="rgb(255,255,255)" d="M447.1 256C447.1 273.7 433.7 288 416 288H109.3l105.4 105.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448s-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H416C433.7 224 447.1 238.3 447.1 256z"/></svg></a>
                <div class="follow-page-title">
                    <p class=" text-white fs-700"><?= $reqUser['name']?></p>
                    <p class="text-light">@<?= $reqUser['username']?></p>
                </div>
            </div>
            <div class="page-switch flex no-padding fs-400 text-light">
                <a class="<?= $_GET['type'] == 'followers' ? 'active':''?>" href="follow/<?=$reqUser['id'] ?>/followers"><p>Abonnés</p></a>
                <a class="<?= $_GET['type'] == 'followed' ? 'active':''?>" href="follow/<?=$reqUser['id'] ?>/followed"><p>Abonnements</p></a>
            </div>
            <div>
                <?php foreach($usersToDisplay as $u){?>
                    <div class="follow__container" style="position:relative">
                        <a href="profile/<?=$u['user_id']?>">
                            <span class="follow__container__link" style="position:absolute;width:100%;height:100%;top:0;left:0;z-index:1"></span>
                        </a>
                        <div class="follow flex">
                            <a href='profile/<?= $u['user_id']?>'>
                                <div class="tweet-profile__container">
                                    <img src='./public/img/profile/<?= $u['img']?>' alt='<?=$u['name']?> profile image' class="tweet-profile"> 
                                </div>
                            </a>
                            <div class="follow__right">
                                <div class="follow__right__header flex">
                                    <div class="follow__right__header__names">
                                        <a style="position : relative;"class="fw-700" style="" href='profile/<?= $u['user_id']?>'> <?= $u['name']?> </a>
                                        <p class="text-light">@<?= $u['username']?></p>
                                    </div>
                                    <?php if($u['followed']){?>
                                    <p style="z-index:2" class="abo fw-700 basic-btn" user_id='<?= $u['user_id']?>'>Abonné</p>
                                    <?php }else if($u['user_id'] == $_SESSION['id']){ ?>
                                    <?php }else{ ?>
                                        <p style="z-index:2" class="noabo fw-700 basic-btn basic-btn--white" user_id='<?= $u['user_id']?>'>Suivre</p>
                                    <?php } ?>
                                </div>
                                <p><?= $u['bio']?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </main>
    </div>
</body>
</html>