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
            <div style="position : relative">
            <textarea name="tweet-text" class="tweet-text sr-only" id="tweet-text9" rows="8" cols="80" placeholder="Tweeter votre réponse"></textarea>
            <div class="contenteditable" id="contenteditable9" contenteditable> </div>
            <ul class="text-mentions" id="text-mentions9" style="z-index:99;position:absolute;bottom:0;left:0;transform:translateY(100%)"> </ul>
            </div>
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