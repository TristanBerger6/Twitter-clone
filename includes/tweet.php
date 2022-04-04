<div class="tweet__container" style="position:relative">
    <a href="status/<?=$tweet['id']?><?= $tweet['retweeter'] ? '/'.$tweet["retweeter_id"] : ''?>">
        <span class="tweet__link" style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:1"></span>
    </a>
    <div class="tweet">
        <?php if($tweet['retweeter']){  ?>
            <div style="position:relative" class="tweet__retweet text-light">
                <a href="profile/<?=$tweet['retweeter_id']?>">
                    <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:2"></span>
                </a>
                <p><i class="fas fa-retweet" aria-hidden="true"></i><?= $tweet['retweeter']?></p> 
            </div>
        <?php } ?>
        <div class="flex">
            <div style="position:relative" class="tweet__left">
                <a href="profile/<?=$tweet['id_user']?>">
                    <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:2"></span>
                </a>
                <div class="tweet-profile__container">
                    <img id="tweet__profile<?= $i?>" src='./public/img/profile/<?= $tweet['profile']?>' alt="profile image of <?= $tweet['name'] ?>" class="tweet-profile">
                </div>
            </div> 
            <div class="tweet__right">
                <div class="tweet__right__header flex">
                    <div class="flex">
                            <div class="flex tweet__right__header__names">
                                <a style="position:relative;z-index2" href="profile/<?=$tweet['id_user']?>"><p id="tweet__name<?= $i?>" class="fw-700"> <?= $tweet['name'] ?></p></a>
                                <a style="position:relative;z-index2" href="profile/<?=$tweet['id_user']?>"><p id="tweet__username<?= $i?>" class="text-light"> @<?= $tweet['username']." ·" ?></p></a>
                            </div>
                        <p id="tweet__date<?= $i?>" class="text-light tweet__right__header__date"> <?= $tweet['date_hour_creation'] ?></p>
                    </div>
                    <div class="tweet__opt__btn tweet__right__header__opt" id="tweet__opt__btn<?= $i ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="hsl(210, 4.2%, 46.3%)" d="M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z"/></svg>
                        <div class="tweet__opt" id="tweet__opt<?= $i ?>">
                            <div class="tweet__opt-back" style="position:fixed;width:100vw;height:100vh;top:0;left:0;z-index:-1"></div>
                            <?php if($tweet['id_user'] == $_SESSION['id']) { ?>
                            <p id_tweet=<?= $tweet['id']?> class="tweet__delete">Supprimer</p>
                            <?php }else{
                                if($tweet['followed']){ ?>
                                <p class="tweet_abo" user_id='<?=$tweet['id_user'] ?>' username='<?= $tweet['username'] ?>'>Se désabonner de @<?= $tweet['username'] ?></p>
                                <?php }else{ ?>
                                <p class="tweet_noabo" user_id='<?=$tweet['id_user']?>' username='<?= $tweet['username'] ?>'>Suivre @<?= $tweet['username'] ?></p>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php if($tweet['responseTo']){  ?>
                    <p class="text-light tweet__response-to">En réponse à <?php foreach($tweet['responseTo'] as $response){?>
                        <a href="profile/<?=$response['id']?>" style="position:relative">
                            <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:2"></span>
                            @<?= $response['username']?>
                        </a>
                        <?php } ?>
                    </p> 
                <?php } ?>
                <p id="tweet__content<?= $i?>" class="tweet__content"> <?= $tweet['content'] ?></p>
                <?php  if($tweet['img']){?>
                <img id="tweet__img<?= $i?>" src='./public/img/tweets/<?= $tweet['img']?>' alt="tweet <?= $tweet['id']?> image" class="tweet-img"> 
                <?php } 
                if($tweet['quote']){?>
                <div class="quoted" style="position:relative">
                            <div class="quoted__container">
                                <a href="status/<?=$tweet['quotedId']?>">
                                    <span class="quoted__link" style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:2"></span>
                                </a>
                                <div class="quoted__top flex">
                                    <div class="quoted-profile__container">
                                        <img id="quoted__profile<?= $i?>" src='./public/img/profile/<?= $tweet['quotedProfile']?>'  alt="profile image of <?= $tweet['quotedName'] ?>" class="quoted-profile" > 
                                    </div>
                                    <div class="quoted__top__names flex">
                                        <p id="quoted__name<?= $i?>" class="fw-700"> <?= $tweet['quotedName'] ?></p>
                                        <p id="quoted__username<?= $i?>" class="text-light"> @<?= $tweet['quotedUsername'].' ·' ?></p>
                                    </div>
                                    <p id="quoted__date<?= $i?>" class="text-light quoted__top__date"> <?= $tweet['quotedDate'] ?> </p>
                                </div>
                                <?php if($tweet['quotedResponseTo']){  ?>
                                    <p class="text-light tweet__response-to">En réponse à <?php foreach($tweet['quotedResponseTo'] as $response){?>
                                        <a href="profile/<?=$response['id']?>" style="position:relative">
                                            <span style="position:absolute;width:100%;height:100%;top:0;left:0,z-index:2"></span>
                                            @<?= $response['username']?>
                                        </a>
                                        <?php } ?>
                                    </p> 
                                <?php } ?>
                                <p id="quoted__content<?= $i?>" class="tweet__content"> <?= $tweet['quotedContent'] ?></p>
                                <?php  if($tweet['quotedImg']){?>
                                <img id="quoted__img<?= $i?>" src='./public/img/tweets/<?= $tweet['quotedImg']?>' alt="tweet <?= $tweet['id']?> quoted image " class="tweet-img" > 
                                <?php } ?>
                            </div>
                </div>
                <?php } ?>
                <div class="tweet__right__bot flex">
                    <div class="tweet__comments modalBtn modalBtn9 flex text-light" commented_i="<?= $i?>"  commented_id="<?= $tweet['id']?>"> 
                        <div><i class="far fa-comment" aria-hidden="true"></i></div>
                        <p><?= $tweet['nbComments'] ?></p>
                    </div>
                    <div class="tweet__reacts__btn" id="tweet__reacts__btn<?= $i ?>" >
                        <div class="tweet__retweet flex text-light" id="tweet__retweet<?= $i ?>" retweeted="<?= $tweet['retweeted']?>"  id_tweet=<?= $tweet['id']?> >
                            <div><i class="fas fa-retweet"  aria-hidden="true"></i></div>
                            <p class="tweet__retweet-nb" id="tweet__retweet-nb<?= $i ?>" ><?= $tweet['nbRetweets'] ?></p>
                        </div>
                        <div class="tweet__reacts" id="tweet__reacts<?= $i ?>"> 
                            <div class="tweet__reacts-back" style="position:fixed;width:100vw;height:100vh;top:0;left:0;z-index:-1"></div>
                            <div class="tweet__reacts__content">
                                <div class="tweet__retweet-btn flex" id="tweet__retweet-btn<?= $i ?>"><i class="fas fa-retweet " aria-hidden="true"></i> <p><?= $tweet['retweeted'] ? 'Annuler le retweet' : 'Retweeter'?></p> </div>
                                <div quoted_i="<?= $i?>"  quoted_id="<?= $tweet['id']?>" class="modalBtn modalBtn8 flex"><i class="fa-solid fa-pen" aria-hidden="true"></i> <p>Citer le tweet</p>  </div>
                            </div>
                        </div>
                    </div>
                    <div id_tweet=<?= $tweet['id']?> class="tweet__like flex text-light" liked="<?= $tweet['liked']?>" > 
                        <div><i class="fa-heart <?= $tweet['liked'] ? 'fas' : 'far' ?> " aria-hidden="true"></i></div>
                        <p class="tweet__like-nb" id="tweet__like-nb<?=$tweet['id'] ?>"><?= $tweet['nbLikes'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>