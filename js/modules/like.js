/**
 *  On a like click, send ajax call to handleLike.php. After success, display the result. 
 *  Doesn't reload the page
 */


 import { postData } from "../utils/functions.js";

 export function useLike(){
    let EltsLike = document.getElementsByClassName('tweet__like');
    let EltsNbLike = document.getElementsByClassName('tweet__like-nb')

    for (let i =0; i<EltsLike.length; i++){
        EltsLike[i].addEventListener('click', handleLike);
    }

    function handleLike(e){
        let Elt = e.currentTarget;
        let liked = e.currentTarget.getAttribute('liked');
        let idTweet = e.currentTarget.getAttribute('id_tweet');
        let EltIcon = e.currentTarget.firstElementChild.firstElementChild;
        let EltNb = null;
        for ( let i=0; i<EltsNbLike.length; i++){
            let idEltNb = EltsNbLike[i].id.replace('tweet__like-nb','');
            if(idEltNb == idTweet){
                EltNb = EltsNbLike[i];
            }
        }
    


        if(liked == "1"){
            postData('index.php?handle=like&unlike=1',{'id_tweet' : idTweet})
            .then(data => {
                
                Elt.setAttribute('liked','0');
                Elt.style.color = "hsl(var(--clr-grey-light))";
                EltIcon.classList.remove('fas');
                EltIcon.classList.add('far');
                EltNb.innerHTML = parseInt(EltNb.innerHTML) - 1;

            });
        }else{
            postData('index.php?handle=like&like=1',{'id_tweet' : idTweet})
            .then(data => {
            
                Elt.setAttribute('liked','1');
                Elt.style.color = "hsl(var(--clr-pink))";
                EltIcon.classList.remove('far');
                EltIcon.classList.add('fas');
                EltNb.innerHTML = parseInt(EltNb.innerHTML) + 1;
            });
        }
    }
 }
 