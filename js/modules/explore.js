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

    EltSubmit.addEventListener('click',(e)=>{
        e.preventDefault();
        let textValue = EltInput.value;
        location.replace(`index.php?page=explore&query=${textValue}`);
    })

    EltInput.addEventListener('input',(e)=>{
        let textValue = EltInput.value;
        let startMention = textValue.match(/^@/);
        EltSuggestions.innerHTML = ``;
        if(startMention){
            let nbWords = startMention.input.split(' ').length;
            if(nbWords === 1){
                let stringToCheck = startMention.input.replace('@','');
                postData('index.php?handle=mention',{'stringToCheck' : stringToCheck})
                    .then(data => {
                        EltSuggestions.style.display = 'block';
                        data.data.forEach((element)=>{
                            EltSuggestions.innerHTML += `<li id_user="${element['id']}" class="mention-prop">
                            <img src='./public/img/profile/${element['img']}' alt="profile image" class="profile-img mention-img"> 
                            <p class="mention-name">@${element['name']}</p>
                            <p class="mention-username">@${element['username']}</p>
                            </li>`;
                        })
                        for (let k=0; k<EltSuggestions.childNodes.length; k++){
                            EltSuggestions.childNodes[k].addEventListener('click',handleClickSuggestion);
                        }
                        })
            }else{
                EltSuggestions.style.display = 'none';
            }
        }else{
            EltSuggestions.style.display = 'none';
        }

    })

    function handleClickSuggestion(e){
        
        location.replace(`index.php?page=profile&id=${e.currentTarget.getAttribute('id_user')}`); 
        
    }
}
