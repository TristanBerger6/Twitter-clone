
export function useModal(){
    let modals = document.getElementsByClassName('modal');
    let modalsBtn = document.getElementsByClassName('modalBtn');
    let modalsClose = document.getElementsByClassName('modalClose');
    
    
    for (let i = 0; i < modalsBtn.length; i++) {
        modalsBtn[i].addEventListener('click',(e)=>{
            let idBtn = e.currentTarget.id;
            idBtn = idBtn.replace('modalBtn','');
            for (let i = 0; i < modals.length; i++) {
                let idModal = modals[i].id;
                idModal = idModal.replace('modal','');
                if( idBtn === idModal){
                    modals[i].style.display = "block";
                }
            }
        })
        modalsClose[i].addEventListener('click',(e)=>{
            let idClose = e.currentTarget.id;
            idClose = idClose.replace('modalClose','');
            for (let i = 0; i < modals.length; i++) {
                let idModal = modals[i].id;
                idModal = idModal.replace('modal','');
                if( idClose === idModal){
                    modals[i].style.display = "none";
                }
            }
        })
    }
    
    document.addEventListener('click',(e) => {
        let targetId = e.target.id;
        let check = targetId.replace(/[0-9]/g, '');
        if (check === 'modal') {
            for (let i = 0; i < modals.length; i++) {
                modals[i].style.display = "none"; 
            }
        }
      });
}





 

