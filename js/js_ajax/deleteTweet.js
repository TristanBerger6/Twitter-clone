/**
 * delete a tweet by calling handleDelete.php. Will reload page
 *  
*/
import { postForm, postData } from "../functions.js";

/****************** Elt Query ***************************/
let EltsDeleteTweet = document.getElementsByClassName('tweet__delete');

for (let i = 0; i<EltsDeleteTweet.length; i++){
    EltsDeleteTweet[i].addEventListener('click',(e)=>{
        let idTweet = e.currentTarget.getAttribute('id_tweet');
        postData('index.php?handle=delete&tweet=1',{'id_tweet' : idTweet})
        .then(data => {
            location.replace("");
        });
    })
}