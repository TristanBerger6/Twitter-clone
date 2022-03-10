<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <script src="./js/js_ajax/postTweet.js" type="module" defer></script>
  <script src="./js/js_ajax/deleteTweet.js" type="module" defer></script>
  <script src="./js/js_ajax/follow.js" type="module" defer></script>
  <script src="./js/js_ajax/like.js" type="module" defer></script>
  <script src="./js/js_ajax/retweet.js" type="module" defer></script>
  <script src="./js/modules/modules.js" type="module" defer></script>
  <title>twitter Clone</title>
  <meta name="description" content="Clone de Twitter">
 </head>

<body>

    <?php require('includes/nav.php') ?>
    <main class='homeContainer'>
        <div class="postTweet">
            <form action='' method="post" enctype='multipart/form-data'>
                <img src='./public/img/profile/<?= $reqUser['img']?>' alt="profile image" class="profile-img"> 
                <textarea name="tweet-text" class="tweet-text" id="tweet-text2" rows="8" cols="80" placeholder="Quoi de neuf ?"></textarea>
                <span class="count-text" id="count-text2">140</span>
                <span class="close-preview" id="close-preview2"> close preview</span>
                <img class="preview-input img-tweet-preview" id="preview-input2" src='' alt="tweet image preview">
                <label class="img-icon" for="input-img2">
                    <i class="fa fa-image" aria-hidden="true"></i>
                </label>
                <input id="input-img2" class="input-img" type="file" name="tweet-img">
                <input type="submit" name="postTweet" value="Tweeter">
                <?php if (isset($error)) {
                echo '<font color="red">' . $error . '</font>';
                } ?>
            </form>
        </div>
        <br/>
        <?php $i = 0;
              foreach($allTweetsWInfos as $tweet){
                $i++ ?>
            <div class="tweet">
                <p> <?= $tweet['name'] ?></p>
                <p> @<?= $tweet['username'] ?></p>
                <p> <?= $tweet['date_hour_creation'] ?></p>
                <p> <?= $tweet['content'] ?></p>
                <?php  if($tweet['img']){?>
                <img src='./public/img/tweets/<?= $tweet['img']?>' alt="tweet <?= $tweet['id']?> image" class="profile-img"> 
                <?php } ?>
                <p> Comments <?= $tweet['nbComments'] ?></p>
                <div class="tweet__reacts__btn" id="tweet__reacts__btn<?= $i ?>" >
                    <div class="tweet__retweet" id="tweet__retweet<?= $i ?>" retweeted="<?= $tweet['retweeted']?>"  id_tweet=<?= $tweet['id']?> >
                        <i class="fas fa-retweet"  aria-hidden="true"></i>
                        <p class="tweet__retweet-nb" id="tweet__retweet-nb<?= $i ?>" ><?= $tweet['nbRetweets'] ?></p>
                    </div>
                    <div class="tweet__reacts" id="tweet__reacts<?= $i ?>"> 
                        <div class="tweet__retweet-btn" id="tweet__retweet-btn<?= $i ?>"><i class="fas fa-retweet " aria-hidden="true"></i> <p><?= $tweet['retweeted'] ? 'Annuler le retweet' : 'Retweeter'?></p> </div>
                        <div><i class="fas fa-retweet" aria-hidden="true"></i> <p>Citer le tweet</p>  </div>
                    </div>
                </div>
                <div id_tweet=<?= $tweet['id']?> class="tweet__like" liked="<?= $tweet['liked']?>" > 
                    <i class="fa-heart <?= $tweet['liked'] ? 'fas' : 'far' ?> " aria-hidden="true"></i>
                    <p class="" ><?= $tweet['nbLikes'] ?></p>
                </div>
                <div class="tweet__opt__btn" id="tweet__opt__btn<?= $i ?>">options
                <div class="tweet__opt" id="tweet__opt<?= $i ?>">
                    <?php if($tweet['id_user'] == $_SESSION['id']) { ?>
                    <p id_tweet=<?= $tweet['id']?> class="tweet__delete">supprimer</p>
                    <?php }else{
                        if($tweet['followed']){ ?>
                        <p class="tweet_abo" user_id='<?=$tweet['id_user'] ?>'>Se désabonner de @<?= $tweet['username'] ?></p>
                        <?php }else{ ?>
                        <p class="tweet_noabo" user_id='<?=$tweet['id_user']?>' username='<?php $tweet['username'] ?>'>Suivre @<?= $tweet['username'] ?></p>
                        <?php } ?>
                    <?php } ?>

                </div>
                </div>
                <br/>
                <br/>
                <br/>
            
            </div>
        <?php } ?>
    </main>


</body>
</html>