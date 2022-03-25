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