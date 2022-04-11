/**
 * Implements a counter on the number of characters of the tweet
 * Also implements the coloring of mentions ( words starting with @) and
 * a div with mention suggestions appears when writing a mention
 * No line breaks available
 * 
 */
import { postData } from "../utils/functions.js";

export function useTextTweet(){
    // Each of the elements with the following classes also have an id with the same name + a number.
    // (ex id=count-text1 id=tweet-text1 ..) to find the elements belonging to the same entity.
    let EltCountText = document.getElementsByClassName('count-text');
    let EltText = document.getElementsByClassName('tweet-text');
    let EltMentions = document.getElementsByClassName('text-mentions');
    let EltMentionsContainer = document.getElementsByClassName('text-mentions__container');
    let EltContenteditable = document.getElementsByClassName('contenteditable');

    
    // contenteditable contains the text inside its div, than we pass it to the textarea ( EltText ) via its value to send it with an ajax call
    for(let i=0; i<EltContenteditable.length; i++){
        EltContenteditable[i].addEventListener('input',(e)=>{
            let EltCond = e.currentTarget;
            var re = new RegExp(String.fromCharCode(160), "g"); // remove &nbsp; when 2 @ follows each other. ex : @admin @admin
            let valueText = EltCond.textContent.replace(re, " ");
            let idEditable = EltCond.id.replace('contenteditable','');
    
            for(let s=0; s<EltText.length; s++){ // look for the corresponding textarea
                let idText = EltText[s].id.replace('tweet-text','');
                if(idEditable === idText){ // found the textarea
                    EltText[s].value = valueText; // set the value
                    for(let j=0; j<EltCountText.length; j++){ // look for the corresponding Count element
                        let idCount = EltCountText[j].id.replace('count-text','');
                        if(idEditable === idCount){ // found the count element
                            EltCountText[j].innerHTML = (140-valueText.length).toString();
                        }
                    }
                    for(let l=0; l<EltMentions.length; l++){  // look for the corresponding mention element
                        let idMentions = EltMentions[l].id.replace('text-mentions','');
                        if(idEditable === idMentions){ // found the corresponding mentions element
                            let lastWord = valueText.split(' ').pop();
                            let isMention = lastWord.match(/^@/);
                            if(isMention){ // found some mentions @.. at the end of the text
                                let stringToCheck = isMention.input.replace('@','');
                                // check that it's not just 'sometext @ sometext'
                                if(stringToCheck){
                                    postData('index.php?handle=mention',{'stringToCheck' : stringToCheck})
                                    .then(data => {
                                        EltMentions[l].innerHTML = ``; // reset the mentions element
                                        EltMentionsContainer[l].style.display = 'block';
                                        data.data.forEach((element)=>{
                                            EltMentions[l].innerHTML += `<li class="mention-prop flex">
                                            <div class="mention-img__container"> 
                                                <img src='./public/img/profile/${element['img']}' alt="profile image" class="mention-img"> 
                                            </div>
                                            <div class="mention-prop__right"> 
                                            <p class="mention-name fw-700">${element['name']}</p>
                                            <p class="mention-username text-light">@${element['username']}</p>
                                            </div>
                                            </li>`;
                                            for (let k=0; k<EltMentions[l].childNodes.length; k++){
                                                EltMentions[l].childNodes[k].addEventListener('click',handleClickMention(i,l,s));
                                            }
                                        })
                                        })
                                }
                            }else{
                                EltMentionsContainer[l].style.display = 'none';
                            }
                            
                        }
                    }
                }   
            }
            color_mention(EltCond);
          
            
        })
    }

    function handleClickMention(i,l,s){
        return function(event){
            let username = event.currentTarget.getElementsByClassName('mention-username')[0].innerHTML;
            EltContenteditable[i].innerHTML = EltContenteditable[i].innerHTML.split(" ").slice(0, -1).join(" ");
            EltContenteditable[i].innerHTML +=  username ;
            EltText[s].value = EltContenteditable[i].innerText;
            EltMentionsContainer[l].style.display = 'none';
            EltContenteditable[i].dispatchEvent(new Event('input', {bubbles:true}));
            color_mention(EltContenteditable[i]);
           
        }
    }


   
    function color_mention(EltCond){

       // Loop through words
        let str = EltCond.innerText.replace('\n',''); // no line break
        // without the replace, when we write a single letter and delete it right after, 
        // a /n is left.
                
        let chunks = str
        .split(new RegExp(`(@[a-z0-9]*)`, 'i'));
        chunks = chunks.filter(chunk => chunk != "");
        let regex = new RegExp('^@');
        let markup = chunks.reduce((acc, chunk) => {
        acc += regex.test(chunk) ?
        `<span class="mentions">${chunk}</span>` :
        `<span class='other'>${chunk}</span>`;
        return acc
        }, '');  
        

        EltCond.innerHTML = markup;// chunks are like "hello " "@admin" " how are you "
        // but spaces are turned into &nbsp; with innerHTML
      

        // Set cursor postion to end of text
        let child = EltCond.children;
        let range = document.createRange();
        let sel = window.getSelection();
        if(child.length){
            range.setStart(child[child.length-1], 1);
            range.collapse(true);
            sel.removeAllRanges();
            sel.addRange(range);
        }
        EltCond.focus();
    }

    //disable enter because line breaks not available. If not disabled, the counting of words becomes false
    document.addEventListener('keypress',(e)=>{
        if(e.key === "Enter" && document.activeElement.classList.contains('contenteditable')){
            e.preventDefault();
        }
    })

    //placeholder for contenteditable at load page
    for(let i=0; i<EltContenteditable.length; i++){
        let placeholder = EltContenteditable[i].getAttribute('data-placeholder');
        EltContenteditable[i].innerHTML = ''&&(EltContenteditable[i].innerHTML = placeholder);
    }
    // remove mentions container when clicking elsewhere than a mention 
    for (let i =0; i<EltMentionsContainer.length; i++){
        EltMentionsContainer[i].addEventListener('click',(e)=>{
            let check = e.target.classList.contains('text-mentions-back');
            if(check){
                for (let j=0;j<EltMentionsContainer.length; j++){
                    EltMentionsContainer[j].style.display ='none';
                }
            }
        })
    }
   
}


/*
/ Tests to implements line break, not working yet
      // Loop through words
        let str =  EltCond.innerText; // get online text ( with /n included in innerText)
        let lines = [];
        let lineChunk = str // split into different lines
        .split(new RegExp(`\n`,'i'));
        lineChunk.forEach(line =>{
            let chunks = line
            .split(new RegExp(`(@[a-z0-9]*)`, 'i'));
        chunks.forEach((chunk,index) =>{ // need a space on each line for the range to be offset = 1
            chunk == '' ? chunks[index] = ' ' : chunks[index]=chunk;
        })
        let regex = new RegExp('^@');
        let markup = chunks.reduce((acc, chunk) => {
            acc += regex.test(chunk) ?
            `<span class="mentions">${chunk}</span>` :
            `<span class='other'>${chunk}</span>`
            return acc
        }, '');  
        lines.push(markup);   
        })


        EltCond.innerHTML = lines.join('<br />');
        
        // Set cursor postion to end of text
        let child = EltCond.children;
        let lastChild = EltCond.lastChild;
        let range = document.createRange();
        let sel = window.getSelection();
        range.setStart(child[child.length-1], 1);
        range.collapse(true);
        sel.removeAllRanges();
        sel.addRange(range);
        EltCond.focus();
*/

 