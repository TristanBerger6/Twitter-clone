<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <script src="./js/js_ajax/postTweet.js" type="module" defer></script>
  <script src="./js/js_ajax/postComment.js" type="module" defer></script>
  <script src="./js/js_ajax/quoteTweet.js" type="module" defer></script>
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
                <div style="position : relative">
                <textarea name="tweet-text" class="tweet-text sr-only" id="tweet-text2" rows="8" cols="80" placeholder="Quoi de neuf ?"></textarea>
                <div class="contenteditable" id="contenteditable2" contenteditable> </div>
                <ul class="text-mentions" id="text-mentions2" style="z-index:99;position:absolute;bottom:0;left:0;transform:translateY(100%)"> </ul>
                </div>
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
            <div class="tweet__container" style="position:relative">
                <a href="index.php?page=status&id=<?=$tweet['id']?><?= $tweet['retweeter'] ? '&retweeter='.$tweet["retweeter_id"] : ''?>">
                    <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:1"></span>
                 </a>
                <div class="tweet">
                    <?php if($tweet['retweeter']){  ?>
                        <div style="position:relative">
                            <a href="index.php?page=profile&id=<?=$tweet['retweeter_id']?>">
                                <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:2"></span>
                            </a>
                            <p><i class="fas fa-retweet" aria-hidden="true"></i><?= $tweet['retweeter']?></p> 
                        </div>
                    <?php } ?>
                    <?php if($tweet['responseTo']){  ?>
                        <p>En réponse à <?php foreach($tweet['responseTo'] as $response){?>
                            <a href="index.php?page=profile&id=<?=$response['id']?>" style="position:relative">
                                <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:2"></span>
                                @<?= $response['username']?>
                            </a>
                            <?php } ?>
                        </p> 
                    <?php } ?>
                    <div style="position:relative">
                        <a href="index.php?page=profile&id=<?=$tweet['id_user']?>">
                            <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:2"></span>
                        </a>
                        <img id="tweet__profile<?= $i?>" src='./public/img/profile/<?= $tweet['profile']?>' alt="profile image of <?= $tweet['name'] ?>" class="profile-img">
                    </div> 
                    <div style="position:relative">
                        <a href="index.php?page=profile&id=<?=$tweet['id_user']?>">
                            <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:2"></span>
                        </a>
                        <p id="tweet__name<?= $i?>"> <?= $tweet['name'] ?></p>
                        <p id="tweet__username<?= $i?>"> @<?= $tweet['username'] ?></p>
                    </div> 
                    <p id="tweet__date<?= $i?>"> <?= $tweet['date_hour_creation'] ?></p>
                    <p id="tweet__content<?= $i?>"> <?= $tweet['content'] ?></p>
                    <?php  if($tweet['img']){?>
                    <img id="tweet__img<?= $i?>" src='./public/img/tweets/<?= $tweet['img']?>' alt="tweet <?= $tweet['id']?> image" class="profile-img"> 
                    <?php } 
                    if($tweet['quote']){?>
                    <div class="tweet" style="position:relative">
                                <?php if($tweet['quotedResponseTo']){  ?>
                                    <p>En réponse à <?php foreach($tweet['quotedResponseTo'] as $response){?>
                                        <a href="index.php?page=profile&id=<?=$response['id']?>" style="position:relative">
                                            <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:2"></span>
                                            @<?= $response['username']?>
                                        </a>
                                        <?php } ?>
                                    </p> 
                                <?php } ?>
                                <a href="index.php?page=status&id=<?=$tweet['quotedId']?>">
                                    <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:2"></span>
                                </a>
                                <img src='./public/img/profile/<?= $tweet['quotedProfile']?>'  alt="profile image of <?= $tweet['quotedName'] ?>" class="profile-img" > 
                                <p > <?= $tweet['quotedName'] ?></p>
                                <p > @<?= $tweet['quotedUsername'] ?></p>
                                <p > <?= $tweet['quotedDate'] ?> </p>
                                <p > <?= $tweet['quotedContent'] ?></p>
                                <?php  if($tweet['quotedImg']){?>
                                <img src='./public/img/tweets/<?= $tweet['quotedImg']?>' alt="tweet <?= $tweet['id']?> quoted image " class="profile-img" > 
                                <?php } ?>
                    </div>
                    <?php } ?>
                    <div class="tweet__comments modalBtn modalBtn9" commented_i="<?= $i?>"  commented_id="<?= $tweet['id']?>"> <i class="far fa-comment" aria-hidden="true"></i><p><?= $tweet['nbComments'] ?></p></div>
                    <div class="tweet__reacts__btn" id="tweet__reacts__btn<?= $i ?>" >
                        <div class="tweet__retweet" id="tweet__retweet<?= $i ?>" retweeted="<?= $tweet['retweeted']?>"  id_tweet=<?= $tweet['id']?> >
                            <i class="fas fa-retweet"  aria-hidden="true"></i>
                            <p class="tweet__retweet-nb" id="tweet__retweet-nb<?= $i ?>" ><?= $tweet['nbRetweets'] ?></p>
                        </div>
                        <div class="tweet__reacts" id="tweet__reacts<?= $i ?>"> 
                            <div class="tweet__reacts-back" style="position:fixed;width:100vw;height:100vh;top:0;left:0;z-index:-1"></div>
                            <div class="tweet__retweet-btn" id="tweet__retweet-btn<?= $i ?>"><i class="fas fa-retweet " aria-hidden="true"></i> <p><?= $tweet['retweeted'] ? 'Annuler le retweet' : 'Retweeter'?></p> </div>
                            <div quoted_i="<?= $i?>"  quoted_id="<?= $tweet['id']?>" class="modalBtn modalBtn8"><i class="fas fa-retweet" aria-hidden="true"></i> <p>Citer le tweet</p>  </div>
                        
                        </div>
                    </div>
                    <div id_tweet=<?= $tweet['id']?> class="tweet__like" liked="<?= $tweet['liked']?>" > 
                        <i class="fa-heart <?= $tweet['liked'] ? 'fas' : 'far' ?> " aria-hidden="true"></i>
                        <p class="" ><?= $tweet['nbLikes'] ?></p>
                    </div>
                    <div class="tweet__opt__btn" id="tweet__opt__btn<?= $i ?>">options
                        <div class="tweet__opt" id="tweet__opt<?= $i ?>">
                            <div class="tweet__opt-back" style="position:fixed;width:100vw;height:100vh;top:0;left:0;z-index:-1"></div>
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
                </div>
            </div>
            <br/>
            <br/>
            <br/>
            
        <?php } ?>
        <div class="modal modal8" > 
            <div class="modal__content">
                <span class="modalClose modalClose8" >close</span>
                <br/>
                <div class="postTweet">
                    <form action='' method="post" id="formQuoteTweet"  enctype='multipart/form-data'>
                    <img src='./public/img/profile/<?= $reqUser['img']?>' alt="profile image" class="profile-img"> 
                    <textarea name="tweet-text" class="tweet-text" id="tweet-text8" rows="8" cols="80" placeholder="Quoi de neuf ?"></textarea>
                    <div class="tweet" id="quotedTweet">
                        <img src='' alt="" class="profile-img" id="quotedTweet__profile"> 
                        <p id="quotedTweet__name"> </p>
                        <p id="quotedTweet__username"> </p>
                        <p id="quotedTweet__date"> </p>
                        <p id="quotedTweet__content"> </p>
                        <img src='' alt="" class="profile-img" id="quotedTweet__img"> 
                    </div>
                    <span class="count-text" id="count-text8">140</span>
                    <span class="close-preview" id="close-preview8"> close preview</span>
                    <img class="preview-input img-tweet-preview" id="preview-input8" src='' alt="tweet image preview">
                    <label class="img-icon" for="input-img8">
                        <i class="fa fa-image" aria-hidden="true"></i>
                    </label>
                    <input id="input-img8" class="input-img" type="file" name="tweet-img">
                    <input type="text" class="sr-only" aria-hidden="true" name="quoted_id" id="quotedTweet__id" value="">
                    <input type="submit" name="quoteTweet" value="Tweeter" id="quoteTweet">
                    <br/>
                    <div id="quoteTweet-error"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal modal9" > 
            <div class="modal__content">
                <span class="modalClose modalClose9" >close</span>
                <br/>
                <div class="postTweet">
                    <form action='' method="post" id="formPostComment"  enctype='multipart/form-data'>
                    <div class="tweet" id="commentedTweet">
                        <img src='' alt="" class="profile-img" id="commentedTweet__profile"> 
                        <p id="commentedTweet__name"> </p>
                        <p id="commentedTweet__username"> </p>
                        <p id="commentedTweet__date"> </p>
                        <p id="commentedTweet__content"> </p>
                        <img src='' alt="" class="profile-img" id="commentedTweet__img"> 
                    </div>
                    <img src='./public/img/profile/<?= $reqUser['img']?>' alt="profile image" class="profile-img"> 
                    <textarea name="tweet-text" class="tweet-text" id="tweet-text9" rows="8" cols="80" placeholder="Tweeter votre réponse"></textarea>
                    <span class="count-text" id="count-text9">140</span>
                    <span class="close-preview" id="close-preview9"> close preview</span>
                    <img class="preview-input img-tweet-preview" id="preview-input9" src='' alt="tweet image preview">
                    <label class="img-icon" for="input-img9">
                        <i class="fa fa-image" aria-hidden="true"></i>
                    </label>
                    <input id="input-img9" class="input-img" type="file" name="tweet-img">
                    <input type="text" class="sr-only" aria-hidden="true" name="commented_id" id="commentedTweet__id" value="">
                    <input type="submit" name="postComment" value="Répondre" id="postComment">
                    <br/>
                    <div id="postComment-error"></div>
                    </form>
                </div>
            </div>
        </div>

        

    </main>


</body>
</html>