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
    for (let i =0; i<EltsRetweetBtn.length; i++){
       let idEltNb = EltsNb[i].id.replace('tweet__retweet-nb','');
       let idEltRetweet = EltsRetweet[i].id.replace('tweet__retweet','');
       if(idEltNb == idEltRetweetBtn){
           EltNb = EltsNb[i];
       } 
       if(idEltRetweet == idEltRetweetBtn){
            EltRetweet = EltsRetweet[i];
        } 
    }

    let retweeted = EltRetweet.getAttribute('retweeted');
    let idTweet = EltRetweet.getAttribute('id_tweet');

     if(retweeted == "1"){
        postData('index.php?handle=retweet&unretweet=1',{'id_tweet' : idTweet})
        .then(data => {

            EltRetweet.setAttribute('retweeted','0');
            EltRetweetBtn.lastElementChild.innerHTML="Retweeter";
            EltRetweet.style.color = "black";
            EltNb.innerHTML = parseInt(EltNb.innerHTML) - 1;

        });
     }else{
        postData('index.php?handle=retweet&retweet=1',{'id_tweet' : idTweet})
        .then(data => {
         
            EltRetweet.setAttribute('retweeted','1');
            EltRetweetBtn.lastElementChild.innerHTML="Annuler le retweet";
            EltRetweet.style.color = "green";  
            EltNb.innerHTML = parseInt(EltNb.innerHTML) + 1;
        });
     }
 }