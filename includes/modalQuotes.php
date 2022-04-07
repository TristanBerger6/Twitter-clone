<div class="modal modal8 no-padding" > 
    <div class="modal__content">
    <span class="modalClose modalClose8 modal__close" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="rgb(255,255,255)" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"/></svg></span>
        <div class="modal-quote">
            <form action='' method="post" id="formQuoteTweet"  enctype='multipart/form-data' class="post-tweet flex">
                <div class="tweet-profile__container">
                    <img src='./public/img/profile/<?= $reqUser['img']?>' alt="profile image" class="tweet-profile"> 
                </div>
                <div class="post-tweet__right">
                    <div class="post-tweet__right__top">
                        <div style="position : relative">
                            <textarea name="tweet-text" class="tweet-text sr-only" id="tweet-text8" rows="8" cols="80" placeholder="Ajouter un commentaire"></textarea>
                            <div class="contenteditable" id="contenteditable8" contenteditable data-placeholder="Ajouter un commentaire"> </div>
                            <div class="text-mentions__container">
                                <ul class="text-mentions" id="text-mentions8" style="z-index:99;position:absolute;bottom:0;left:0;transform:translateY(100%);"></ul>
                                <div class="text-mentions-back" style="position:fixed;width:100vw;height:100vh;top:0;left:0;z-index:1"></div>
                        </div>
                        </div>
                        <div class="preview">
                            <div class="close-preview" id="close-preview8"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="rgb(255,255,255)" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"/></svg></div>
                            <img class="preview-input img-tweet-preview" id="preview-input8" src='' alt="tweet image preview">
                        </div>
                        <div class="quoted" id="quotedTweet">
                            <div class="quoted__container">
                                <div class="quoted__top flex">
                                    <div class="quoted-profile__container">
                                        <img src='' alt="" class="quoted-profile" id="quotedTweet__profile"> 
                                    </div>
                                    <div class="quoted__top__names flex">
                                    <p class="fw-700"id="quotedTweet__name"> </p>
                                    <p class="text-light" id="quotedTweet__username"> </p>
                                    </div>
                                    <p class="text-light quoted__top__date" id="quotedTweet__date"> </p>
                                </div>
                                <p class="tweet__content" id="quotedTweet__content"> </p>
                                <img src='' alt="" class="tweet-img" id="quotedTweet__img"> 
                            </div>
                        </div>
                    </div>
                    
                    <div class="post-tweet__right__bot post-botom">
                        <label class="img-icon text-blue" for="input-img8">
                            <i class="fa fa-image" aria-hidden="true"></i>
                        </label>
                        <input id="input-img8" class="input-img" type="file" name="tweet-img">
                        <span class="count-text text-blue" id="count-text8">140</span>
                        <input type="text" class="sr-only" aria-hidden="true" name="quoted_id" id="quotedTweet__id" value="">
                        <input class="tweet-btn bg-blue text-white fw-700" type="submit" name="quoteTweet" value="Tweeter" id="quoteTweet">
                    </div>
                    <div class="error" id="quoteTweet-error"></div>
                </div>
            </form>
        </div>
    </div>
</div>