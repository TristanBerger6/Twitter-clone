
export function useTweetsOpt(){
    let EltsOpt = document.getElementsByClassName('tweet__opt');
    let EltsBtnOpt = document.getElementsByClassName('tweet__opt__btn');
    let opened = false;

    for(let i=0; i<EltsBtnOpt.length; i++){
        EltsBtnOpt[i].addEventListener('click', handleBtnOptClick);
    }

    function handleBtnOptClick(e){
        let btnId = e.currentTarget.id; 
        btnId = btnId.replace('tweet__opt__btn','');
        let check = e.target.classList.contains('tweet__opt-back');
        if(check){
            handleCloseOpts(e);
            opened = false;
        }else{
            if(opened){
                handleCloseOpts(e);
                opened = false;
            }else{
                for(let i=0; i<EltsOpt.length; i++){
                    let optId = EltsOpt[i].id;
                    optId = optId.replace('tweet__opt','');
                    if(optId == btnId){
                        EltsOpt[i].style.display = "block";
                        opened = true ;
                        
                    }
                }
            }
        }
    }
    
    function handleCloseOpts(e){
        e.preventDefault();
        for (let i = 0; i < EltsOpt.length; i++) {
            EltsOpt[i].style.display = "none"; 
        }
    }

}

export function useTweetsReacts(){
    let EltsReacts = document.getElementsByClassName('tweet__reacts');
    let EltsBtnReacts = document.getElementsByClassName('tweet__reacts__btn');
    let opened = false;


    for(let i=0; i<EltsBtnReacts.length; i++){
        EltsBtnReacts[i].addEventListener('click', handleBtnReactsClick);
    }

    function handleBtnReactsClick(e){
        let btnId = e.currentTarget.id; 
        btnId = btnId.replace('tweet__reacts__btn','');
        let check = e.target.classList.contains('tweet__reacts-back');
        if(check == 'tweet__reacts-back'){
            handleCloseReacts(e);
            opened = false;
        }else{
            if(opened){
                handleCloseReacts(e);
                opened = false;
            }else{
                for(let i=0; i<EltsReacts.length; i++){
                    let reactsId = EltsReacts[i].id;
                    reactsId = reactsId.replace('tweet__reacts','');
                    if(reactsId == btnId){
                        EltsReacts[i].style.display = "block"; 
                        opened = true;    
                    }
                }
            }
        }
    }

    function handleCloseReacts(e){
        e.preventDefault();
        for (let i = 0; i < EltsReacts.length; i++) {
            EltsReacts[i].style.display = "none"; 
        }
    }
}