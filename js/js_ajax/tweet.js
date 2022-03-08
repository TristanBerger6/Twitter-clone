/**
 * posting a tweet will reload the page unless an error is detected by handleTweet.php. In that case
 *  an error will appear in the modal without reloading the page.
*/
import { postForm, postData } from "../functions.js";


/****************** Elt Query ***************************/
let modal = document.getElementById('modal1');
let modalBtn = document.getElementById('modalBtn1');
let modalClose = document.getElementById('modalClose1');

let EltSubmit = document.getElementById('postTweet');
let EltPreviewImg = document.getElementById('preview-input1');
let EltInputImg = document.getElementById('input-img1');
let EltText = document.getElementById('tweet-text1');
let EltForm = document.getElementById('formPostTweet');
let EltError = document.getElementById('postTweet-error');
let EltCount =document.getElementById('count-text1');
let EltClosePreview = document.getElementById('close-preview1')




/****************** Event Listeners ***************************/


// On submit, ajax to profile.php, display error if needed, close modal otherwise
EltSubmit.addEventListener('click',(e)=>{
    e.preventDefault();
    let formdata = new FormData(EltForm);
    postForm(`index.php?handle=tweet&postTweet=1`,formdata)
    .then(res => {
        if(res.data == 'created'){
            location.replace("");
        }else{
            EltError.innerHTML = res.data.error;
        }
    })
});


// when closing the modal, reset all the value of the profile with the saved ones
modalClose.addEventListener('click',(e)=>{
    EltInputImg.value="";
    EltText.value = "";
    EltPreviewImg.style.display = 'none';
    EltError.innerHTML = "";
    EltCount.innerHTML = '140';
    EltClosePreview.style.display = 'none';
});

document.addEventListener('click',(e) => {
    let targetId = e.target.id;
    let check = targetId.replace(/[0-9]/g, '');
    if (check === 'modal') {
        EltInputImg.value="";
        EltPreviewImg.style.display = 'none';
        EltText.value = "";
        EltError.innerHTML = "";
        EltCount.innerHTML = '140';
        EltClosePreview.style.display = 'none';
    }
});


