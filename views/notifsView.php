<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <title>twitter Clone</title>
  <meta name="description" content="Clone de Twitter">
  <script src="./js/globalPostTweet.js" type="module" defer></script>

 </head>


<body class='connected-page'>
    <div class="connected-page__container">
        <?php require('includes/nav.php') ?>
        <main class='homeContainer'>
            <div class="page-title flex">
                <a href="javascript:history.go(-1)" class="page-title__back" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="rgb(255,255,255)" d="M447.1 256C447.1 273.7 433.7 288 416 288H109.3l105.4 105.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448s-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H416C433.7 224 447.1 238.3 447.1 256z"/></svg></a>
                <p class="fw-700 fs-700">Notifications</p>     
            </div>
            <?php foreach($allNotifs as $notif){?>
                <?php if($notif['type'] == 'follow'){ ?>
                    <a class="notif flex" href="index.php?page=profile&id=<?= $notif['foreign_id']?>?>">
                <?php }else{ ?>
                    <a class="notif flex" href="index.php?page=status&id=<?= $notif['id_tweet']?><?= $notif['type']=='retweet' ? '&retweeter='.$notif['foreign_id'].'':  '' ?>">
                <?php } ?>
                    <div class="notif__icon">
                        <?php if($notif['type'] === 'retweet' || $notif['type'] === 'quote') { ?>
                            <i class="fas fa-retweet"  aria-hidden="true" style='color : hsl(var(--clr-green))'></i>
                        <?php }else if($notif['type'] === 'follow' || $notif['type'] === 'mention'){ ?>
                            <i class="fas fa-user"  aria-hidden="true" style='color : hsl(var(--clr-grey-light))'></i>
                        <?php }else if($notif['type'] === 'comment'){ ?>
                            <i class="far fa-comment" aria-hidden="true" style='color : hsl(var(--clr-grey-light))'></i>
                        <?php }else{ ?>
                            <i class="fas fa-heart" aria-hidden="true" style='color : hsl(var(--clr-pink))'></i>
                        <?php } ?>
                    </div>
                    <div class="notif__right">
                        <div class="notif__right__top tweet-profile__container">
                            <img src='./public/img/profile/<?= $notif['foreign_profile']?>' alt="profile image of <?= $notif['foreign_name'] ?>" class="tweet-profile">
                        </div>
                        <p class="notif__right__bot text-light" >
                            <span class="fw-700 text-white"><?= $notif['foreign_name'].' '?></span>
                            <?= $notif['display'] ?> <?= $notif['date']?>
                        </p>
                       
                    </div>
                </a>
            <?php } ?>
        </main>
    </div>
</body>
</html>