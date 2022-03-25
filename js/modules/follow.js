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
            console.log(data);
            Elt.removeEventListener('mouseenter',handleMouseEnter);
            Elt.removeEventListener('mouseleave',handleMouseLeave);
            Elt.removeEventListener('click',handleUnfollow);
            Elt.addEventListener('click',handleFollow);
            Elt.innerHTML = 'Suivre';
            Elt.classList.add('noabo');
            Elt.classList.remove('abo');
        })
    }

    function handleFollow(e){
        let id = e.currentTarget.getAttribute('user_id');
        let Elt = e.currentTarget;
        postData('index.php?handle=follow&follow=1',{'user_to_follow' : id})
        .then(data => {
            console.log(data);
            Elt.addEventListener('mouseenter',handleMouseEnter);
            Elt.addEventListener('mouseleave',handleMouseLeave);
            Elt.removeEventListener('click',handleFollow);
            Elt.addEventListener('click',handleUnfollow);
            Elt.innerHTML = 'Abonné';
            Elt.classList.add('abo');
            Elt.classList.remove('noabo');
        })
    }


    /************** Follows from tweet **********************/
    let EltsAboTweet = document.getElementsByClassName('tweet_abo');
    let EltsNoAboTweet = document.getElementsByClassName('tweet_noabo');

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
            Elt.removeEventListener('click',handleUnfollowTweet);
            Elt.addEventListener('click',handleFollowTweet);
            Elt.innerHTML = `Suivre @${username}`;
            Elt.classList.add('tweet_noabo');
            Elt.classList.remove('tweet_abo');
        })
    }

    function handleFollowTweet(e){
        let id = e.currentTarget.getAttribute('user_id');
        let username = e.currentTarget.getAttribute('username');
        let Elt = e.currentTarget;
        postData('index.php?handle=follow&follow=1',{'user_to_follow' : id})
        .then(data => {
            Elt.removeEventListener('click',handleFollowTweet);
            Elt.addEventListener('click',handleUnfollowTweet);
            Elt.innerHTML = `se désabonner de @${username}`;
            Elt.classList.add('tweet_abo');
            Elt.classList.remove('tweet_noabo');
        })
    }
}
