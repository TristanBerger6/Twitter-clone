/**
 *  Display people how liked the status tweet
 */
 import { postData } from "../utils/functions.js";

 export function useTweetInfos(){
    let EltBtnLike = document.getElementById('like-infos-btn');
    let EltModalLike = document.getElementById('modal-likes-infos');
    let EltBtnRt = document.getElementById('rt-infos-btn');
    let EltModalRt = document.getElementById('modal-rt-infos');

    EltBtnLike.addEventListener('click',(e)=>{
        let idTweet = e.currentTarget.getAttribute('id_tweet');
        postData('index.php?handle=tweetinfos&type=likes',{'id_tweet' : idTweet})
        .then(data => {
            EltModalLike.innerHTML = "";
            let arrayUsers = data.data;
            arrayUsers.forEach(user => {
                EltModalLike.innerHTML += `
                <div class="modal-infos__container" style="position:relative">
                    <a href="profile/${user['id']}">
                        <span class="modal-infos__container__link" style="position:absolute;width:100%;height:100%;top:0;left:0;z-index:1"></span>
                    </a>
                    <div class="modal-infos flex">
                        <div class="tweet-profile__container">
                            <img src='./public/img/profile/${user['img']}' alt='${user['img']} profile image' class="tweet-profile"> 
                        </div>
                        <div class="modal-infos__right">
                            <p class="fw-700"> ${user['name']} </p>
                            <p class="text-light">@${user['username']}</p>
                        </div>
                    </div>
                </div>`;
                
            });
        });
    });
    EltBtnRt.addEventListener('click',(e)=>{
        let idTweet = e.currentTarget.getAttribute('id_tweet');
        postData('index.php?handle=tweetinfos&type=rt',{'id_tweet' : idTweet})
        .then(data => {
            EltModalRt.innerHTML = "";
            let arrayUsers = data.data;
            arrayUsers.forEach(user => {
                EltModalRt.innerHTML += `
                <div class="modal-infos__container" style="position:relative">
                    <a href="profile/${user['id']}">
                        <span class="modal-infos__container__link" style="position:absolute;width:100%;height:100%;top:0;left:0;z-index:1"></span>
                    </a>
                    <div class="modal-infos flex">
                        <div class="tweet-profile__container">
                            <img src='./public/img/profile/${user['img']}' alt='${user['img']} profile image' class="tweet-profile"> 
                        </div>
                        <div class="modal-infos__right">
                            <p class="fw-700"> ${user['name']} </p>
                            <p class="text-light">@${user['username']}</p>
                        </div>
                    </div>
                </div>`;
                
            });
        });
    });

 }
 