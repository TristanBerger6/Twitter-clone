/**
 *  Handle comment from button in each tweet. commenting will reload the page unless an error is detected by handleQuote.php. In that case
 *  an error will appear in the modal without reloading the page.
 *  Note that there is only 1 modal handling comments for all the tweets. It will be updated with the right informations thanks to this file.
 *  
 */
import { postForm, postData } from "../utils/functions.js";

export function usePostComment(){
    /****************** Elt Query ***************************/
    let modalClose = document.getElementsByClassName('modalClose9')[0];

    // Elt of the tweet we are going to post
    let EltSubmit = document.getElementById('postComment');
    let EltPreviewImg = document.getElementById('preview-input9');
    let EltInputImg = document.getElementById('input-img9');
    let EltText = document.getElementById('tweet-text9');
    let EltContenteditable = document.getElementById('contenteditable9');
    let EltForm = document.getElementById('formPostComment');
    let EltError = document.getElementById('postComment-error');
    let EltCount =document.getElementById('count-text9');
    let EltClosePreview = document.getElementById('close-preview9')

    //Elt needed from the original tweet to be able to display them in the modal
    let EltTweetProfile = null;
    let EltTweetName = null;
    let EltTweetUsername = null;
    let EltTweetDate = null;
    let EltTweetContent = null;
    let EltTweetImg = null;

    //Elt displaying the original tweet
    let EltCommentedProfile = document.getElementById("commentedTweet__profile");
    let EltCommentedName = document.getElementById("commentedTweet__name");
    let EltCommentedUsername = document.getElementById("commentedTweet__username");
    let EltCommentedDate = document.getElementById("commentedTweet__date");
    let EltCommentedContent = document.getElementById("commentedTweet__content");
    let EltCommentedImg = document.getElementById("commentedTweet__img");
    let EltCommentedId = document.getElementById("commentedTweet__id");

    // same thing is the commented tweet is a quote, we need to get the quoted tweet
    //Elt needed from the quoted tweet to be able to display them in the modal
    let EltQuotedProfile = null;
    let EltQuotedName = null;
    let EltQuotedUsername = null;
    let EltQuotedDate = null;
    let EltQuotedContent = null;
    let EltQuotedImg = null;

    //Elt displaying the quoted tweet
    let EltCommentedQuotedProfile = document.getElementById("commentedQuotedTweet__profile");
    let EltCommentedQuotedName = document.getElementById("commentedQuotedTweet__name");
    let EltCommentedQuotedUsername = document.getElementById("commentedQuotedTweet__username");
    let EltCommentedQuotedDate = document.getElementById("commentedQuotedTweet__date");
    let EltCommentedQuotedContent = document.getElementById("commentedQuotedTweet__content");
    let EltCommentedQuotedImg = document.getElementById("commentedQuotedTweet__img");
    let EltCommentedQuotedDiv = document.getElementById("commentedQuotedTweet__div");

    // display the original tweet in the commented one
    let EltsModalBtn = document.getElementsByClassName('modalBtn');

    for(let i =0; i<EltsModalBtn.length; i++){
        EltsModalBtn[i].addEventListener('click',(e)=>{
            let iCommented = e.currentTarget.getAttribute('commented_i');
            EltCommentedId.value = e.currentTarget.getAttribute('commented_id');
            EltTweetProfile = document.getElementById(`tweet__profile${iCommented}`);
            EltTweetName = document.getElementById(`tweet__name${iCommented}`);
            EltTweetUsername = document.getElementById(`tweet__username${iCommented}`);
            EltTweetDate = document.getElementById(`tweet__date${iCommented}`);
            EltTweetContent = document.getElementById(`tweet__content${iCommented}`);
            EltTweetImg = document.getElementById(`tweet__img${iCommented}`);
            EltCommentedProfile.src = EltTweetProfile.src;
            EltCommentedName.innerHTML = EltTweetName.innerHTML;
            EltCommentedUsername.innerHTML = EltTweetUsername.innerHTML;
            EltCommentedDate.innerHTML = EltTweetDate.innerHTML;
            EltCommentedContent.innerHTML = EltTweetContent.innerHTML;

            EltQuotedProfile = document.getElementById(`quoted__profile${iCommented}`);
            if(EltQuotedProfile){
                EltCommentedQuotedDiv.style.display='block';
                EltQuotedName = document.getElementById(`quoted__name${iCommented}`);
                EltQuotedUsername = document.getElementById(`quoted__username${iCommented}`);
                EltQuotedDate = document.getElementById(`quoted__date${iCommented}`);
                EltQuotedContent = document.getElementById(`quoted__content${iCommented}`);
                EltQuotedImg = document.getElementById(`quoted__img${iCommented}`);
                EltCommentedQuotedProfile.src = EltQuotedProfile.src;
                EltCommentedQuotedName.innerHTML = EltQuotedName.innerHTML;
                EltCommentedQuotedUsername.innerHTML = EltQuotedUsername.innerHTML;
                EltCommentedQuotedDate.innerHTML = EltQuotedDate.innerHTML;
                EltCommentedQuotedContent.innerHTML = EltQuotedContent.innerHTML;
    
                if(EltQuotedImg){
                    EltCommentedQuotedImg.src = EltQuotedImg.src;
                }else{
                    EltCommentedQuotedImg.style.display = 'none';
                }
            }else{
                EltCommentedQuotedDiv.style.display='none';
            }
           
            

            if(EltTweetImg){
                EltCommentedImg.src = EltTweetImg.src;
            }else{
                EltCommentedImg.style.display = 'none';
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
        postForm(`index.php?handle=comment&commentTweet=1`,formdata)
        .then(res => {
            if(res.data == 'created'){
                location.replace(`status/${EltCommentedId.value}`);
            
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
        EltContenteditable.innerHTML = "";
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




