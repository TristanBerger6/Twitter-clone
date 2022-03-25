<div class="modal modal8" > 
    <div class="modal__content">
    <span class="modalClose modalClose8" >close</span>
    <br/>
        <div class="postTweet">
            <form action='' method="post" id="formQuoteTweet"  enctype='multipart/form-data'>
            <img src='./public/img/profile/<?= $reqUser['img']?>' alt="profile image" class="profile-img"> 
            <div style="position : relative">
            <textarea name="tweet-text" class="tweet-text sr-only" id="tweet-text8" rows="8" cols="80" placeholder="Tweeter votre réponse"></textarea>
            <div class="contenteditable" id="contenteditable8" contenteditable> </div>
            <ul class="text-mentions" id="text-mentions8" style="z-index:99;position:absolute;bottom:0;left:0;transform:translateY(100%)"> </ul>
            </div>
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