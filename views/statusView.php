<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="stylesheet" href="./public/css/style.css" /> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <script src="./js/globalPostTweet.js" type="module" defer></script>
  <script src="./js/displayTweets.js" type="module" defer></script>
  <title>twitter Clone</title>
  <meta name="description" content="Clone de Twitter">
 </head>

<body>

    <?php require('includes/nav.php') ?>
    <main class='homeContainer'>
        <div> <a href="index.php?page=home"> Retour</a> </div>
        <div> Tweet </div>
        <br/>
        <br/>
        <br/>
        <?php $i = 0;
                foreach($allAboveTweetsWInfos as $tweet){
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
                    <img id="tweet__profile<?= $i ?>" src='./public/img/profile/<?= $tweet['profile']?>' alt="profile image of <?= $tweet['name'] ?>" class="profile-img">
                </div> 
                <div style="position:relative">
                    <a href="index.php?page=profile&id=<?=$tweet['id_user']?>">
                        <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:2"></span>
                    </a>
                    <p id="tweet__name<?= $i ?>"> <?= $tweet['name'] ?></p>
                    <p id="tweet__username<?= $i ?>"> @<?= $tweet['username'] ?></p>
                </div> 
                <p id="tweet__date<?= $i ?>"> <?= $tweet['date_hour_creation'] ?></p>
                <p id="tweet__content<?= $i ?>"> <?= $tweet['content'] ?></p>
                <?php  if($tweet['img']){?>
                <img id="tweet__img<?= $i ?>" src='./public/img/tweets/<?= $tweet['img']?>' alt="tweet <?= $tweet['id']?> image" class="profile-img"> 
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
                <div class="tweet__comments modalBtn modalBtn9" commented_i="<?= $i ?>"  commented_id="<?= $tweet['id']?>"> <i class="far fa-comment" aria-hidden="true"></i><p><?= $tweet['nbComments'] ?></p></div>
                <div class="tweet__reacts__btn" id="tweet__reacts__btn<?= $i ?>" >
                    <div class="tweet__retweet" id="tweet__retweet<?= $i ?>" retweeted="<?= $tweet['retweeted']?>"  id_tweet=<?= $tweet['id']?> >
                        <i class="fas fa-retweet"  aria-hidden="true"></i>
                        <p class="tweet__retweet-nb" id="tweet__retweet-nb<?= $i ?>" ><?= $tweet['nbRetweets'] ?></p>
                    </div>
                    <div class="tweet__reacts" id="tweet__reacts<?= $i ?>"> 
                        <div class="tweet__reacts-back" style="position:fixed;width:100vw;height:100vh;top:0;left:0;z-index:-1"></div>
                        <div class="tweet__retweet-btn" id="tweet__retweet-btn<?= $i ?>"><i class="fas fa-retweet " aria-hidden="true"></i> <p><?= $tweet['retweeted'] ? 'Annuler le retweet' : 'Retweeter'?></p> </div>
                        <div quoted_i="<?= $i ?>"  quoted_id="<?= $tweet['id']?>" class="modalBtn modalBtn8"><i class="fas fa-retweet" aria-hidden="true"></i> <p>Citer le tweet</p>  </div>
                    
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
        <?php } ?>

        <br/>
        <p> COMMMMS</p>
        <br/>

            <?php 
                foreach($allCommentsWInfos as $com){
                    $i++ ?>
                <div class="tweet__container" style="position:relative">
                    <a href="index.php?page=status&id=<?=$com['id']?>">
                        <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:1"></span>
                    </a>
                    <div class="tweet">
                        <p>En réponse à <?php foreach($allAboveTweetsWInfos as $t){?>
                            <a href="index.php?page=profile&id=<?=$t['id_user']?>" style="position:relative">
                                <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:2"></span>
                                @<?= $t['username']?>
                            </a>
                            <?php } ?>
                        </p> 
                       
                        <div style="position:relative">
                            <a href="index.php?page=profile&id=<?=$com['id_user']?>">
                                <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:2"></span>
                            </a>
                            <img id="tweet__profile<?= $i?>" src='./public/img/profile/<?= $com['profile']?>' alt="profile image of <?= $com['name'] ?>" class="profile-img">
                        </div> 
                        <div style="position:relative">
                            <a href="index.php?page=profile&id=<?=$com['id_user']?>">
                                <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:2"></span>
                            </a>
                            <p id="tweet__name<?= $i?>"> <?= $com['name'] ?></p>
                            <p id="tweet__username<?= $i?>"> @<?= $com['username'] ?></p>
                        </div> 
                        <p id="tweet__date<?= $i?>"> <?= $com['date_hour_creation'] ?></p>
                        <p id="tweet__content<?= $i?>"> <?= $com['content'] ?></p>
                        <?php  if($com['img']){?>
                        <img id="tweet__img<?= $i?>" src='./public/img/tweets/<?= $com['img']?>' alt="tweet <?= $com['id']?> image" class="profile-img">     
                        <?php } ?>           
                        <div class="tweet__comments modalBtn modalBtn9" commented_i="<?= $i?>"  commented_id="<?= $com['id']?>"> <i class="far fa-comment" aria-hidden="true"></i><p><?= $com['nbComments'] ?></p></div>
                        <div class="tweet__reacts__btn" id="tweet__reacts__btn<?= $i ?>" >
                            <div class="tweet__retweet" id="tweet__retweet<?= $i ?>" retweeted="<?= $com['retweeted']?>"  id_tweet=<?= $com['id']?> >
                                <i class="fas fa-retweet"  aria-hidden="true"></i>
                                <p class="tweet__retweet-nb" id="tweet__retweet-nb<?= $i ?>" ><?= $com['nbRetweets'] ?></p>
                            </div>
                            <div class="tweet__reacts" id="tweet__reacts<?= $i ?>"> 
                                <div class="tweet__reacts-back" style="position:fixed;width:100vw;height:100vh;top:0;left:0;z-index:-1"></div>
                                <div class="tweet__retweet-btn" id="tweet__retweet-btn<?= $i ?>"><i class="fas fa-retweet " aria-hidden="true"></i> <p><?= $com['retweeted'] ? 'Annuler le retweet' : 'Retweeter'?></p> </div>
                                <div quoted_i="<?= $i?>"  quoted_id="<?= $com['id']?>" class="modalBtn modalBtn8"><i class="fas fa-retweet" aria-hidden="true"></i> <p>Citer le tweet</p>  </div>
                            
                            </div>
                        </div>
                        <div id_tweet=<?= $com['id']?> class="tweet__like" liked="<?= $com['liked']?>" > 
                            <i class="fa-heart <?= $com['liked'] ? 'fas' : 'far' ?> " aria-hidden="true"></i>
                            <p class="" ><?= $com['nbLikes'] ?></p>
                        </div>
                        <div class="tweet__opt__btn" id="tweet__opt__btn<?= $i ?>">options
                            <div class="tweet__opt" id="tweet__opt<?= $i ?>">
                                <div class="tweet__opt-back" style="position:fixed;width:100vw;height:100vh;top:0;left:0;z-index:-1"></div>
                                <?php if($com['id_user'] == $_SESSION['id']) { ?>
                                <p id_tweet=<?= $com['id']?> class="tweet__delete">supprimer</p>
                                <?php }else{
                                    if($com['followed']){ ?>
                                    <p class="tweet_abo" user_id='<?=$com['id_user'] ?>'>Se désabonner de @<?= $com['username'] ?></p>
                                    <?php }else{ ?>
                                    <p class="tweet_noabo" user_id='<?=$com['id_user']?>' username='<?php $com['username'] ?>'>Suivre @<?= $com['username'] ?></p>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
                <br/>
        
              
                
            <?php } ?> 
            <?php require('includes/modalComments.php') ?>
            <?php require('includes/modalQuotes.php') ?>  
        

    </main>


</body>
</html>