/**
 *  On a retweet click, send ajax call to handleRetweet.php. After success, display the result. 
 *  Doesn't reload the page
 */

 import { postData } from "../utils/functions.js";

 export function useRetweet(){
    // Each of the elements with the following classes also have an id with the same name + a number.
    // (ex id=tweet__retweet-btn1 id=tweet__retweet ..) to find the elements belonging to the same entity.
    let EltsRetweetBtn = document.getElementsByClassName('tweet__retweet-btn');
    let EltsRetweet = document.getElementsByClassName('tweet__retweet')
    let EltsNb = document.getElementsByClassName('tweet__retweet-nb');


    for (let i =0; i<EltsRetweetBtn.length; i++){
        EltsRetweetBtn[i].addEventListener('click', handleRetweet);
    }

    function handleRetweet(e){
        let EltRetweetBtn = e.currentTarget;
        let EltRetweet = null;
        let EltNb = null;
        let idEltRetweetBtn = e.currentTarget.id.replace('tweet__retweet-btn','');
        for (let i =0; i<EltsRetweet.length; i++){ // look for the correpsonding Retweet element and save it
        let idEltRetweet = EltsRetweet[i].id.replace('tweet__retweet','');
            if(idEltRetweet == idEltRetweetBtn){
                    EltRetweet = EltsRetweet[i];
                } 
        }
        for (let i =0; i<EltsNb.length; i++){ // look for the corresponding nb element and save it
            let idEltNb = EltsNb[i].id.replace('tweet__retweet-nb','');
            if(idEltNb == idEltRetweetBtn){
                EltNb = EltsNb[i];
            }
        }

        let retweeted = EltRetweet.getAttribute('retweeted');
        let idTweet = EltRetweet.getAttribute('id_tweet');

        // it is also necessary to change the values of the original tweet
        let idOriginalRetweet = null;
        let originalRetweet = null;
        let originalRetweetBtn = null;
        let originalNb = null;
        for(let i=0; i<EltsRetweet.length; i++ ){ // get the orignial retweet + its number
            let idEltRetweet = EltsRetweet[i].id.replace('tweet__retweet','');
            if(EltsRetweet[i].getAttribute('id_tweet') == idTweet && idEltRetweet != idEltRetweetBtn ){
                originalRetweet = EltsRetweet[i];
                idOriginalRetweet = originalRetweet.id.replace('tweet__retweet','');
            }
        }
        for (let i =0; i<EltsRetweetBtn.length; i++){ // get the original retweet btn + the number of tweet
            let idEltRetweetBtn = EltsRetweetBtn[i].id.replace('tweet__retweet-btn','');
            if(idOriginalRetweet == idEltRetweetBtn){
                originalRetweetBtn = EltsRetweetBtn[i];
                } 
            }
            for (let i =0; i<EltsNb.length; i++){
            let idEltNb = EltsNb[i].id.replace('tweet__retweet-nb','');
            if(idEltNb == idOriginalRetweet){
                originalNb = EltsNb[i];
            } 
        }

        if(retweeted == "1"){
            postData('index.php?handle=retweet&unretweet=1',{'id_tweet' : idTweet})
            .then(data => { // remove retweet from the retweeted tweet
                EltRetweet.setAttribute('retweeted','0');
                EltRetweetBtn.lastElementChild.innerHTML="Retweeter";
                EltRetweet.style.color = "hsl(var(--clr-grey-light))";
                EltNb.innerHTML = parseInt(EltNb.innerHTML) - 1;

                if(idOriginalRetweet !== null){ // remove retweet from the original tweet
                    originalRetweet.setAttribute('retweeted','0');
                    originalRetweetBtn.lastElementChild.innerHTML="Retweeter";
                    originalRetweet.style.color = "hsl(var(--clr-grey-light))";
                    originalNb.innerHTML = parseInt(originalNb.innerHTML) - 1;
                }
            
            

            });
        }else{
            postData('index.php?handle=retweet&retweet=1',{'id_tweet' : idTweet})
            .then(data => {// add retweet to the retweeted tweet
            
                EltRetweet.setAttribute('retweeted','1');
                EltRetweetBtn.lastElementChild.innerHTML="Annuler le retweet";
                EltRetweet.style.color = "hsl(var(--clr-green))";  
                EltNb.innerHTML = parseInt(EltNb.innerHTML) + 1;

                if(idOriginalRetweet !== null){// add retweet to the original tweet
                    originalRetweet.setAttribute('retweeted','1');
                    originalRetweetBtn.lastElementChild.innerHTML="Annuler le retweet";
                    originalRetweet.style.color = "hsl(var(--clr-green))";
                    originalNb.innerHTML = parseInt(originalNb.innerHTML) + 1;
                }
        
            });
        }
    }
 }


 