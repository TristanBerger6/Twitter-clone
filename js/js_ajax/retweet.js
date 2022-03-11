/**
 *  On a retweet click, send ajax call to handleRetweet.php. After success, display the result. 
 *  Doesn't reload the page
 */


 import { postData } from "../functions.js";

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
    for (let i =0; i<EltsRetweet.length; i++){
       let idEltRetweet = EltsRetweet[i].id.replace('tweet__retweet','');
       if(idEltRetweet == idEltRetweetBtn){
            EltRetweet = EltsRetweet[i];
        } 
    }
    for (let i =0; i<EltsNb.length; i++){
        let idEltNb = EltsNb[i].id.replace('tweet__retweet-nb','');
        if(idEltNb == idEltRetweetBtn){
            EltNb = EltsNb[i];
        }
    }

    let retweeted = EltRetweet.getAttribute('retweeted');
    let idTweet = EltRetweet.getAttribute('id_tweet');

    let idOriginalRetweet = null;
    let originalRetweet = null;
    let originalRetweetBtn = null;
    let originalNb = null;
    for(let i=0; i<EltsRetweet.length; i++ ){
        let idEltRetweet = EltsRetweet[i].id.replace('tweet__retweet','');
        if(EltsRetweet[i].getAttribute('id_tweet') == idTweet && idEltRetweet != idEltRetweetBtn ){
            originalRetweet = EltsRetweet[i];
            idOriginalRetweet = originalRetweet.id.replace('tweet__retweet','');
            console.log(idOriginalRetweet);
        }
    }
    for (let i =0; i<EltsRetweetBtn.length; i++){
        let idEltRetweetBtn = EltsRetweetBtn[i].id.replace('tweet__retweet-btn','');
        if(idOriginalRetweet == idEltRetweetBtn){
            originalRetweetBtn = EltsRetweetBtn[i];
            console.log(idEltRetweetBtn);
            } 
        }
        for (let i =0; i<EltsNb.length; i++){
        let idEltNb = EltsNb[i].id.replace('tweet__retweet-nb','');
        if(idEltNb == idOriginalRetweet){
            originalNb = EltsNb[i];
            console.log(idEltNb);
        } 
    }

     if(retweeted == "1"){
        postData('index.php?handle=retweet&unretweet=1',{'id_tweet' : idTweet})
        .then(data => {
            EltRetweet.setAttribute('retweeted','0');
            EltRetweetBtn.lastElementChild.innerHTML="Retweeter";
            EltRetweet.style.color = "black";
            EltNb.innerHTML = parseInt(EltNb.innerHTML) - 1;

            if(idOriginalRetweet !== null){
                originalRetweet.setAttribute('retweeted','0');
                originalRetweetBtn.lastElementChild.innerHTML="Retweeter";
                originalRetweet.style.color = "black";
                originalNb.innerHTML = parseInt(originalNb.innerHTML) - 1;
            }
           
          

        });
     }else{
        postData('index.php?handle=retweet&retweet=1',{'id_tweet' : idTweet})
        .then(data => {
         
            EltRetweet.setAttribute('retweeted','1');
            EltRetweetBtn.lastElementChild.innerHTML="Annuler le retweet";
            EltRetweet.style.color = "green";  
            EltNb.innerHTML = parseInt(EltNb.innerHTML) + 1;

            if(idOriginalRetweet !== null){
                originalRetweet.setAttribute('retweeted','1');
                originalRetweetBtn.lastElementChild.innerHTML="Annuler le retweet";
                originalRetweet.style.color = "green";
                originalNb.innerHTML = parseInt(originalNb.innerHTML) + 1;
            }
    
        });
     }
 }