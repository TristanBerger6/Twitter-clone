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
            <div> <a href="index.php?page=home"> Retour</a> </div>
            <div> Notifications </div>
        </div>
        <br/>
        <br/>
       
        <div  class='homeContainer'>
           <?php foreach($allNotifs as $notif){?>
                <?php if($notif['type'] == 'follow'){ ?>
                    <a href="index.php?page=profile&id=<?= $notif['foreign_id']?>?>">
                <?php }else{ ?>
                    <a href="index.php?page=status&id=<?= $notif['id_tweet']?><?= $notif['type']=='retweet' ? '&retweeter='.$notif['foreign_id'].'':  '' ?>">
                <?php } ?>
                    <?php if($notif['type'] === 'retweet' || $notif['type'] === 'quote') { ?>
                        <i class="fas fa-retweet"  aria-hidden="true" style='color : green'></i>
                    <?php }else if($notif['type'] === 'follow' || $notif['type'] === 'mention'){ ?>
                        <i class="fas fa-user"  aria-hidden="true" style='color : black'></i>
                    <?php }else if($notif['type'] === 'comment'){ ?>
                        <i class="far fa-comment" aria-hidden="true" style='color : black'></i>
                    <?php }else{ ?>
                        <i class="fas fa-heart" aria-hidden="true" style='color : red'></i>
                    <?php } ?>
                    <img src='./public/img/profile/<?= $notif['foreign_profile']?>' alt="profile image of <?= $notif['foreign_name'] ?>" class="profile-img">
                    <p><?= $notif['foreign_name']?></p>
                    <p><?= $notif['type'] ?></p>
                    <p><?= $notif['date']?></p>
                </a>
                <br/>

            <?php } ?>

        </div>

        
    </main>


</body>
</html>