/**
 * Open and close modals. ex : all modalBtn2 opens modal2 and modalClose2.
 */
export function useModal(){
    // Each of the elements with the following classes also have a class with the same name + a number
    // (ex class='modal1 modal' class='modalBtn1 modalBtn' ..) to find the elements belonging to the same entity.
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
        // modals.length == modalsClose.length
        // look for another class modalCloseX with X a number among all elements with modalClose class,
        // if found, fill the array EltModalsClose[X]=theElement
        for ( let j=0; j<modalsClose[i].classList.length; j++){
            if(modalsClose[i].classList[j].match(/\d+/)){
                let nb = modalsClose[i].classList[j].replace('modalClose','');
                EltsModalsClose[nb] = modalsClose[i];
            }
        }
    }

    
    // foreach button opening a modal, look for the number to open and add an event listener to open the correpsonding modal
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
    
    // modal close
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




 

