
export function useTweetsOpt(){
    let EltsOpt = document.getElementsByClassName('tweet__opt');
    let EltsBtnOpt = document.getElementsByClassName('tweet__opt__btn');
    let EltOpening = null;

    for(let i=0; i<EltsBtnOpt.length; i++){
        EltsBtnOpt[i].addEventListener('click', handleBtnOptClick);
    }

    function handleBtnOptClick(e){
        let btnId = e.currentTarget.id; 
        btnId = btnId.replace('tweet__opt__btn','');
        for(let i=0; i<EltsOpt.length; i++){
            let optId = EltsOpt[i].id;
            optId = optId.replace('tweet__opt','');
            if(optId == btnId){
                EltsOpt[i].style.display = "block";
                EltOpening = true ;
                
            }
        }
    }

    document.addEventListener('click', handleOptClose );
    function handleOptClose(e){
        {
            if(EltOpening){
                EltOpening = false;
            }
            else{
                let targetId = e.target.parentElement.id;
                let check = targetId.replace(/[0-9]/g, '');
                if (check !== 'tweet__opt') {
                    for (let i = 0; i < EltsOpt.length; i++) {
                        EltsOpt[i].style.display = "none"; 
                    }
                }
            }
          }

    }

}

export function useTweetsReacts(){
    let EltsReacts = document.getElementsByClassName('tweet__reacts');
    let EltsBtnReacts = document.getElementsByClassName('tweet__reacts__btn');
    let EltOpening = null;

    for(let i=0; i<EltsBtnReacts.length; i++){
        EltsBtnReacts[i].addEventListener('click', handleBtnReactsClick);
    }

    function handleBtnReactsClick(e){
        let btnId = e.currentTarget.id; 
        btnId = btnId.replace('tweet__reacts__btn','');
        for(let i=0; i<EltsReacts.length; i++){
            let reactsId = EltsReacts[i].id;
            reactsId = reactsId.replace('tweet__reacts','');
            if(reactsId == btnId){
                EltsReacts[i].style.display = "block";
                EltOpening = true ;
                
            }
        }
    }

    document.addEventListener('click', handleReactsClose );
   
    function handleReactsClose(e){
        {
            if(EltOpening){
                EltOpening = false;
            }
            else{
                let targetId = e.target.parentElement.id;
                let check = targetId.replace(/[0-9]/g, '');
                if (check !== 'tweet__reacts') {
                    for (let i = 0; i < EltsReacts.length; i++) {
                        EltsReacts[i].style.display = "none"; 
                    }
                }
            }
          }

    }

   

}