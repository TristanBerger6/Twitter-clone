/**
 *  On a like click, send ajax call to handleLike.php. After success, display the result. 
 *  Doesn't reload the page
 */


 import { postData } from "../utils/functions.js";

 export function useLike(){
    let EltsLike = document.getElementsByClassName('tweet__like');
    let EltsNbLike = document.getElementsByClassName('tweet__like-nb');

    for (let i =0; i<EltsLike.length; i++){
        EltsLike[i].addEventListener('click', handleLike);
    }

    function handleLike(e){
        let liked = e.currentTarget.getAttribute('liked');
        let idTweet = e.currentTarget.getAttribute('id_tweet');
        let EltsNbToLike = []; // contains all element Nb to like ( current tweet + all retweets)
        let EltsToLike = []; // contains all element to like ( current tweet + all retweets)
        let EltsIconsToLike = [];
        for ( let i=0; i<EltsNbLike.length; i++){
            for ( let j=0; j<EltsNbLike[i].classList.length; j++){
                if(EltsNbLike[i].classList[j].match(/\d+/)){
                    let nb = EltsNbLike[i].classList[j].replace('tweet__like-nb','');
                    if(nb == idTweet){
                        EltsNbToLike.push(EltsNbLike[i]);
                    }
                }
            }
        }
        for ( let i=0; i<EltsLike.length; i++){
            let id = EltsLike[i].getAttribute('id_tweet');
            if(id == idTweet){
                EltsToLike.push(EltsLike[i]);
                EltsIconsToLike.push(EltsLike[i].firstElementChild.firstElementChild);
            }
        }
    


        if(liked == "1"){
            postData('index.php?handle=like&unlike=1',{'id_tweet' : idTweet})
            .then(data => {
                for(let i=0; i<EltsToLike.length; i++){
                    EltsToLike[i].setAttribute('liked','0');
                    EltsToLike[i].style.color = "hsl(var(--clr-grey-light))";
                }
                for(let i=0; i<EltsIconsToLike.length; i++){
                    EltsIconsToLike[i].classList.remove('fas');
                    EltsIconsToLike[i].classList.add('far');
                }
                for(let i=0; i<EltsNbToLike.length; i++){
                    EltsNbToLike[i].innerHTML = parseInt(EltsNbToLike[i].innerHTML) - 1;
                }
            });
        }else{
            postData('index.php?handle=like&like=1',{'id_tweet' : idTweet})
            .then(data => {
                for(let i=0; i<EltsToLike.length; i++){
                    EltsToLike[i].setAttribute('liked','1');
                    EltsToLike[i].style.color = "hsl(var(--clr-pink))";
                }
                for(let i=0; i<EltsIconsToLike.length; i++){
                    EltsIconsToLike[i].classList.remove('far');
                    EltsIconsToLike[i].classList.add('fas');
                }
                for(let i=0; i<EltsNbToLike.length; i++){
                    EltsNbToLike[i].innerHTML = parseInt(EltsNbToLike[i].innerHTML) + 1;
                }
            });
        }
    }
 }
 