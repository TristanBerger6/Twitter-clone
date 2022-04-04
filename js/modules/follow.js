/**
 * On a follow or unfollow button click, send ajax call to 
 * handleFollow.php. After success, diplay the result. 
 * Doesn't reload the page
 */
import { postData } from "../utils/functions.js";

export function useFollow(){
    let EltsAbo = document.getElementsByClassName('abo');
    let EltsNoAbo = document.getElementsByClassName('noabo');

    for (let i = 0; i < EltsAbo.length; i++){
        EltsAbo[i].addEventListener('mouseenter',handleMouseEnter);
        EltsAbo[i].addEventListener('mouseleave',handleMouseLeave);
        EltsAbo[i].addEventListener('click',handleUnfollow);
    }

    for (let i = 0; i < EltsNoAbo.length; i++){
        EltsNoAbo[i].addEventListener('click',handleFollow);
    }

    function handleMouseEnter(e){
        e.currentTarget.innerHTML = 'Se désabonner';
    }
    function handleMouseLeave(e){
        e.currentTarget.innerHTML = 'Abonné';
    }
    function handleUnfollow(e){
        let id = e.currentTarget.getAttribute('user_id');
        let Elt = e.currentTarget;
        postData('index.php?handle=follow&unfollow=1',{'user_to_unfollow' : id})
        .then(data => {
            if(data.data != "error"){
                Elt.removeEventListener('mouseenter',handleMouseEnter);
                Elt.removeEventListener('mouseleave',handleMouseLeave);
                Elt.removeEventListener('click',handleUnfollow);
                Elt.addEventListener('click',handleFollow);
                Elt.innerHTML = 'Suivre';
                Elt.classList.add('basic-btn--white');
            }
        })
    }

    function handleFollow(e){
        let id = e.currentTarget.getAttribute('user_id');
        let Elt = e.currentTarget;
        postData('index.php?handle=follow&follow=1',{'user_to_follow' : id})
        .then(data => {
            if(data.data != "error"){
                Elt.addEventListener('mouseenter',handleMouseEnter);
                Elt.addEventListener('mouseleave',handleMouseLeave);
                Elt.removeEventListener('click',handleFollow);
                Elt.addEventListener('click',handleUnfollow);
                Elt.innerHTML = 'Abonné';
                Elt.classList.remove('basic-btn--white');
            }
        })
    }


    /************** Follows from tweet **********************/
    let EltsAboTweet = document.getElementsByClassName('tweet_abo');
    let EltsNoAboTweet = document.getElementsByClassName('tweet_noabo');
    EltsAboTweet = Array.prototype.slice.call( EltsAboTweet);
    EltsNoAboTweet = Array.prototype.slice.call( EltsNoAboTweet);

    for (let i = 0; i < EltsNoAboTweet.length; i++){
        EltsNoAboTweet[i].addEventListener('click',handleFollowTweet);
    }
    for (let i = 0; i < EltsAboTweet.length; i++){
        EltsAboTweet[i].addEventListener('click',handleUnfollowTweet);
    }

    function handleUnfollowTweet(e){
        let id = e.currentTarget.getAttribute('user_id');
        let username = e.currentTarget.getAttribute('username');
        let Elt = e.currentTarget;
        postData('index.php?handle=follow&unfollow=1',{'user_to_unfollow' : id})
        .then(data => {
            let toRemove = [];
            for(let i=0; i<EltsAboTweet.length;i++){
                if(EltsAboTweet[i].getAttribute('username')== username){
                    EltsAboTweet[i].removeEventListener('click',handleUnfollowTweet);
                    EltsAboTweet[i].addEventListener('click',handleFollowTweet);
                    EltsAboTweet[i].innerHTML = `Suivre @${username}`;
                    EltsAboTweet[i].classList.add('tweet_noabo');
                    EltsAboTweet[i].classList.remove('tweet_abo');
                    toRemove.push(i);
                }
            }
            for(let j=0; j<toRemove.length;j++){
                EltsNoAboTweet.push(EltsAboTweet[toRemove[j]]);
            }
            for(let j=0; j<toRemove.length;j++){
                EltsAboTweet.splice(toRemove[j],1);
            }

        })
    }

    function handleFollowTweet(e){
        let id = e.currentTarget.getAttribute('user_id');
        let username = e.currentTarget.getAttribute('username');
        let Elt = e.currentTarget;
        postData('index.php?handle=follow&follow=1',{'user_to_follow' : id})
        .then(data => {
            let toRemove = [];
            for(let i=0; i<EltsNoAboTweet.length;i++){
                if(EltsNoAboTweet[i].getAttribute('username')== username){
                    EltsNoAboTweet[i].removeEventListener('click',handleFollowTweet);
                    EltsNoAboTweet[i].addEventListener('click',handleUnfollowTweet);
                    EltsNoAboTweet[i].innerHTML = `se désabonner de @${username}`;
                    EltsNoAboTweet[i].classList.add('tweet_abo');
                    EltsNoAboTweet[i].classList.remove('tweet_noabo');
                    toRemove.push(i);
                }
            }
            for(let j=0; j<toRemove.length;j++){
                EltsAboTweet.push(EltsNoAboTweet[toRemove[j]]);
            }
            for(let j=0; j<toRemove.length;j++){
                EltsNoAboTweet.splice(toRemove[j],1);
            }
        })
    }
}
