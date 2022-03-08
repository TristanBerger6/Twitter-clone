/**
 *  On a follow or unfollow button click, send ajax call to handleFollow.php. After success, display the result. 
 *  Doesn't reload the page
 */


import { postData } from "../functions.js";

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