/**
 *  Handle quote from button in each tweet. quoting will reload the page unless an error is detected by handleQuote.php. In that case
 *  an error will appear in the modal without reloading the page.
 *  
*/
import { postForm, postData } from "../functions.js";


/****************** Elt Query ***************************/
let modalClose = document.getElementsByClassName('modalClose2')[0];

// Elt of the tweet itself
let EltSubmit = document.getElementById('quoteTweet');
let EltPreviewImg = document.getElementById('preview-input3');
let EltInputImg = document.getElementById('input-img3');
let EltText = document.getElementById('tweet-text3');
let EltForm = document.getElementById('formQuoteTweet');
let EltError = document.getElementById('quoteTweet-error');
let EltCount =document.getElementById('count-text3');
let EltClosePreview = document.getElementById('close-preview3')

//Elt to get from the quoted tweet
let EltTweetProfile = null;
let EltTweetName = null;
let EltTweetUsername = null;
let EltTweetDate = null;
let EltTweetContent = null;
let EltTweetImg = null;

//Elt to display from the quoted tweet in the new tweet
let EltQuotedProfile = document.getElementById("quotedTweet__profile");
let EltQuotedName = document.getElementById("quotedTweet__name");
let EltQuotedUsername = document.getElementById("quotedTweet__username");
let EltQuotedDate = document.getElementById("quotedTweet__date");
let EltQuotedContent = document.getElementById("quotedTweet__content");
let EltQuotedImg = document.getElementById("quotedTweet__img");
let EltQuotedId = document.getElementById("quotedTweet__id");

// display the proper tweet in the quoted one
let EltsModalBtn = document.getElementsByClassName('modalBtn');

for(let i =0; i<EltsModalBtn.length; i++){
    EltsModalBtn[i].addEventListener('click',(e)=>{
        let iQuoted = e.currentTarget.getAttribute('quoted_i');
        EltQuotedId.value = e.currentTarget.getAttribute('quoted_id');
        EltTweetProfile = document.getElementById(`tweet__profile${iQuoted}`);
        EltTweetName = document.getElementById(`tweet__name${iQuoted}`);
        EltTweetUsername = document.getElementById(`tweet__username${iQuoted}`);
        EltTweetDate = document.getElementById(`tweet__date${iQuoted}`);
        EltTweetContent = document.getElementById(`tweet__content${iQuoted}`);
        EltTweetImg = document.getElementById(`tweet__img${iQuoted}`);
        EltQuotedProfile.src = EltTweetProfile.src;
        EltQuotedName.innerHTML = EltTweetName.innerHTML;
        EltQuotedUsername.innerHTML = EltTweetUsername.innerHTML;
        EltQuotedDate.innerHTML = EltTweetDate.innerHTML;
        EltQuotedContent.innerHTML = EltTweetContent.innerHTML;
        if(EltTweetImg){
            EltQuotedImg.src = EltTweetImg.src;
        }else{
            EltQuotedImg.style.display = 'none';
        }

    })
}




/****************** Event Listeners ***************************/


// On submit, ajax to handleQuote.php, display error if needed, close modal otherwise
EltSubmit.addEventListener('click',(e)=>{
    e.preventDefault();
    let formdata = new FormData(EltForm);
    for (var value of formdata.values()) {
        console.log(value);
     }
    postForm(`index.php?handle=quote&quoteTweet=1`,formdata)
    .then(res => {
        if(res.data == 'created'){
            location.replace("");
        }else{
            EltError.innerHTML = res.data.error;
        }
    })
});


modalClose.addEventListener('click',(e)=>{
    EltInputImg.value="";
    EltText.value = "";
    EltPreviewImg.style.display = 'none';
    EltError.innerHTML = "";
    EltCount.innerHTML = '140';
    EltClosePreview.style.display = 'none';
});

document.addEventListener('click',(e) => {
    let check = null;
    let targetClassList = e.target.classList;
        for(let i=0; i<targetClassList.length; i++){
            if(targetClassList[i].match(/\d+/)){
                check = targetClassList[i].replace(/[0-9]/g, '');
            }
        }
    if (check === 'modal') {
        EltInputImg.value="";
        EltPreviewImg.style.display = 'none';
        EltText.value = "";
        EltError.innerHTML = "";
        EltCount.innerHTML = '140';
        EltClosePreview.style.display = 'none';
    }
});


