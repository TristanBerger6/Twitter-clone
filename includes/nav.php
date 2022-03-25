<div class='nav'>
    <a href='index.php?page=home'> Accueil </a>
    <a href='index.php?page=explore'> Explore </a>
    <a href='index.php?page=notifs'> Notifications </a>
    <?php echo "<a href='index.php?page=profile&id=".$_SESSION['id']."'> Profil </a>" ?>
    <a href='index.php?page=settings'> Paramètres </a>
    <a href='index.php?page=logout'> Déconnexion </a>
    <button class="modalBtn modalBtn1"  >Tweeter </button>
</div>

<div class="modal modal1" >
        <div class="modal__content">
            <span class="modalClose modalClose1" >close</span>
            <br/>
            <div class="postTweet">
            <form action='' method="post" id="formPostTweet"  enctype='multipart/form-data'>
                <img src='./public/img/profile/<?= $reqUser['img']?>' alt="profile image" class="profile-img"> 
                <div style="position : relative">
                <textarea name="tweet-text" class="tweet-text sr-only" id="tweet-text1" rows="8" cols="80" placeholder="Quoi de neuf ?"></textarea>
                <div class="contenteditable" id="contenteditable1" contenteditable> </div>
                <ul class="text-mentions" id="text-mentions1" style="z-index:99;position:absolute;bottom:0;left:0;transform:translateY(100%)"> </ul>
                </div>
                <span class="count-text" id="count-text1">140</span>
                <span class="close-preview" id="close-preview1"> close preview</span>
                <img class="preview-input img-tweet-preview" id="preview-input1" src='' alt="tweet image preview">
                <label class="img-icon" for="input-img1">
                    <i class="fa fa-image" aria-hidden="true"></i>
                </label>
                <input id="input-img1" class="input-img" type="file" name="tweet-img">
                <input type="submit" name="postTweet" value="Tweeter" id="postTweet">
                <br/>
                <div id="postTweet-error"></div>
            </form>
        </div>
        </div>
    </div>

