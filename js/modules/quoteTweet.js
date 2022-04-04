/**
 *  Handle quote from button in each tweet. quoting will reload the page unless an error is detected by handleQuote.php. In that case
 *  an error will appear in the modal without reloading the page.
 *  Note that there is only 1 modal handling quotes for all the tweets. It will be updated with the right informations thanks to this file.
 *  
*/
import { postForm, postData } from "../utils/functions.js";

export function useQuoteTweet(){
    /****************** Elt Query ***************************/
    let modalClose = document.getElementsByClassName('modalClose8')[0];

    // Elt of the tweet we are going to post
    let EltSubmit = document.getElementById('quoteTweet');
    let EltPreviewImg = document.getElementById('preview-input8');
    let EltInputImg = document.getElementById('input-img8');
    let EltText = document.getElementById('tweet-text8');
    let EltContenteditable = document.getElementById('contenteditable8');
    let EltForm = document.getElementById('formQuoteTweet');
    let EltError = document.getElementById('quoteTweet-error');
    let EltCount =document.getElementById('count-text8');
    let EltClosePreview = document.getElementById('close-preview8')

    //Elt needed from the original tweet to be able to display them in the modal
    let EltTweetProfile = null;
    let EltTweetName = null;
    let EltTweetUsername = null;
    let EltTweetDate = null;
    let EltTweetContent = null;
    let EltTweetImg = null;

    //Elt displaying the original tweet
    let EltQuotedProfile = document.getElementById("quotedTweet__profile");
    let EltQuotedName = document.getElementById("quotedTweet__name");
    let EltQuotedUsername = document.getElementById("quotedTweet__username");
    let EltQuotedDate = document.getElementById("quotedTweet__date");
    let EltQuotedContent = document.getElementById("quotedTweet__content");
    let EltQuotedImg = document.getElementById("quotedTweet__img");
    let EltQuotedId = document.getElementById("quotedTweet__id");

    // display the original tweet in the quoted one
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
                location.reload();
            }else{
                EltError.innerHTML = res.data.error;
            }
        })
    });


    modalClose.addEventListener('click',(e)=>{
        EltInputImg.value="";
        EltText.value = "";
        EltPreviewImg.style.display = 'none';
        EltContenteditable.innerHTML = "";
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
            EltContenteditable.innerHTML = "";
            EltError.innerHTML = "";
            EltCount.innerHTML = '140';
            EltClosePreview.style.display = 'none';
        }
    });

}

