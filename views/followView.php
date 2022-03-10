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
 </head>


<body>

    <?php require('includes/nav.php') ?>

    <main class='homeContainer'>
        <div>
            <p><?= $reqUser['name']?></p>
            <p>@ <?= $reqUser['username']?></p>
        </div>
        <div>
            <?php echo '<a href="index.php?page=follow&id='.$_SESSION['id'].'&type=followers">Abonnés</a>' ?>
            <?php echo '<a href="index.php?page=follow&id='.$_SESSION['id'].'&type=followed">Abonnements</a>' ?>
        </div>
        <div>
            <?php foreach($usersToDisplay as $u){?>
                <div>
                    <a href='index.php?page=profile&id=<?= $u['user_id']?>'><img src='./public/img/profile/<?= $u['img']?>' alt='<?=$u['name']?> profile image' class="profile-img"> </a>
                    <p><a href='index.php?page=profile&id=<?= $u['user_id']?>'> <?= $u['name']?> </a></p>
                    <p>@<?= $u['username']?></p>
                    <p><?= $u['bio']?></p>
                    <?php if($u['followed']){?>
                    <p class="abo" user_id='<?= $u['user_id']?>'>Abonné</p>
                    <?php }else{ ?>
                    <p class="noabo" user_id='<?= $u['user_id']?>'>Suivre</p>
                    <?php } ?>

                    <br/>
                </div>
            <?php } ?>

        </div>

        
    </main>


</body>
</html>