/**
 * Delete a tweet when pressing the delete button by sending an ajax call
 * to handleDelete.php. Will reload page
 */

import { postForm, postData } from "../utils/functions.js";


export function useDeleteTweet(){
    let EltsDeleteTweet = document.getElementsByClassName('tweet__delete');

    for (let i = 0; i<EltsDeleteTweet.length; i++){
        EltsDeleteTweet[i].addEventListener('click',(e)=>{
            let idTweet = e.currentTarget.getAttribute('id_tweet');
            postData('index.php?handle=delete&tweet=1',{'id_tweet' : idTweet})
            .then(data => {
                window.location.href = window.location.href;
            });
        })
    }
}

