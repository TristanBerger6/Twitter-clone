// Work as follow : all modalBtn2 opens modal2 and modalClose2.
export function useModal(){
    let modals = document.getElementsByClassName('modal');
    let modalsBtn = document.getElementsByClassName('modalBtn');
    let modalsClose = document.getElementsByClassName('modalClose');

    let EltsModals = new Array();
    let EltsModalsClose = new Array();
    //for all the elts with class modal
    for( let i=0; i<modals.length; i++){
        // look for another class modalX with X a number among all elements with modal class,
        // if found,  fill the array EltModals[X]=theElement
        for ( let j=0; j<modals[i].classList.length; j++){
            if(modals[i].classList[j].match(/\d+/)){
                let nb = modals[i].classList[j].replace('modal','');
                EltsModals[nb] = modals[i];
            }
        }
        // look for another class modalCloseX with X a number among all elements with modalClose class,
        // if found, fill the array EltModalsClose[X]=theElement
        for ( let j=0; j<modalsClose[i].classList.length; j++){
            if(modalsClose[i].classList[j].match(/\d+/)){
                let nb = modalsClose[i].classList[j].replace('modalClose','');
                EltsModalsClose[nb] = modalsClose[i];
            }
        }
    }

    
    // foreach button to open the modal, look for the number to open and open it
    for (let i = 0; i < modalsBtn.length; i++) {
        let nb = null;
        for ( let j=0; j<modalsBtn[i].classList.length; j++){
            if(modalsBtn[i].classList[j].match(/\d+/)){
                nb = modalsBtn[i].classList[j].replace('modalBtn','');
            }
        }
        modalsBtn[i].addEventListener('click',(e)=>{ 
            EltsModals[nb].style.display = "block";
        });
    }

    // for all the EltsModalsClose, add event to remove the modal
    for (let i = 0; i < EltsModalsClose.length; i++) {
        // EltsModalsClose[X]=element. ex : modal1 modal8 and modal9 exists. modal[2] will get an error
        if(EltsModalsClose[i]){
            EltsModalsClose[i].addEventListener('click',(e)=>{
                EltsModals[i].style.display = "none";       
            });
        }
    }
    
    document.addEventListener('click',(e) => {
        let check = null;
        let targetClassList = e.target.classList;
        for(let i=0; i<targetClassList.length; i++){
            if(targetClassList[i].match(/\d+/)){
                check = targetClassList[i].replace(/[0-9]/g, '');
            }
        }
        if (check === 'modal') {
            for (let i = 0; i < modals.length; i++) {
                modals[i].style.display = "none"; 
            }
        }
      });
}





 

