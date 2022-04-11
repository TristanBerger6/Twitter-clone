/**
 * When the user searches for a word, send a get request to the explore page with the query value
 * If the user searches for a person with @.., display a suggestion div. On click, redirects to the 
 * user profile.
 */

import { postData } from "../utils/functions.js";

export function useExplore(){
    let EltInput = document.getElementById('explore-input');
    let EltSubmit = document.getElementById('explore-submit');
    let EltSuggestions = document.getElementById('explore-suggestions');
    let EltSuggestionsContainer = document.getElementById('explore-suggestions-container');

    let EltBlock = document.getElementById('explore-block');
    let EltBlockSearch = document.getElementById('explore-block-search');
    let EltBlockClose = document.getElementById('explore-block-close');

    // on enter, send Get request via url
    EltSubmit.addEventListener('click',(e)=>{
        e.preventDefault();
        let textValue = EltInput.value;
        if( textValue){
            location.replace(`explore/${textValue}`);
        }else{
            location.replace(`explore`);
        }
        
    })

    // on input, display suggestions with an ajax call to handleMention.php
    EltInput.addEventListener('input',(e)=>{
        let textValue = EltInput.value;
        let startMention = textValue.match(/^@/);
        if(startMention){
            let nbWords = startMention.input.split(' ').length;
            if(nbWords === 1){
                let stringToCheck = startMention.input.replace('@','');
                postData('index.php?handle=mention',{'stringToCheck' : stringToCheck})
                    .then(data => {
                        EltSuggestions.innerHTML = ``;
                        EltSuggestionsContainer.style.display = 'block';
                        data.data.forEach((element)=>{
                            EltSuggestions.innerHTML += `<li id_user="${element['id']}" class="mention-prop flex">
                            <div class="mention-img__container"> 
                                <img src='./public/img/profile/${element['img']}' alt="profile image" class="mention-img"> 
                            </div>
                            <div class="mention-prop__right"> 
                            <p class="mention-name fw-700">@${element['name']}</p>
                            <p class="mention-username text-light">@${element['username']}</p>
                            </div>
                            </li>`;
                        })
                        for (let k=0; k<EltSuggestions.childNodes.length; k++){
                            EltSuggestions.childNodes[k].addEventListener('click',handleClickSuggestion);
                        }
                        })
            }else{
                EltSuggestionsContainer.style.display = 'none';
            }
        }else{
            EltSuggestionsContainer.style.display = 'none';
        }
    })

    function handleClickSuggestion(e){
        location.replace(`profile/${e.currentTarget.getAttribute('id_user')}`); 
    }

    // Change style on focus and blur
    EltInput.addEventListener('focus',(e)=>{
        if(EltInput.value !== ''){
            EltBlockClose.style.display="grid";
        }
        EltBlock.style.outline="1px solid hsl(var(--clr-blue))";
        EltBlockSearch.style.fill = "hsl(var(--clr-blue))";
        EltBlockClose.style.background = "hsl(var(--clr-blue))";
    })
    EltInput.addEventListener('blur',(e)=>{
        EltBlock.style.outline="none";
        EltBlockSearch.style.fill = "hsl(var(--clr-white))";
        EltBlockClose.style.background = "hsl(var(--clr-white))";
    })
    // Close buton appears disappears when writing in the input
    EltInput.addEventListener('input',(e)=>{
        if (e.currentTarget.value == ''){
            EltBlockClose.style.display="none";
        }else{
            EltBlockClose.style.display="grid";
        }
    })
    //Reset input's value when clicking onthe close buton
    EltBlockClose.addEventListener('click',(e)=>{
        EltInput.value = "";
        EltBlockClose.style.display="none";
    })
    // Remove suggestions container on click elsewhere than suggestions
    EltSuggestionsContainer.addEventListener('click',(e)=>{
        let check = e.target.classList.contains('text-mentions-back');
        if(check){
            EltSuggestionsContainer.style.display = 'none';
        }
    })
}
