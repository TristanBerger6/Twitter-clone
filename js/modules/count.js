export function useCount(){
    let EltCountText = document.getElementsByClassName('count-text');
    let EltText = document.getElementsByClassName('tweet-text');
    let EltMentions = document.getElementsByClassName('text-mentions');
    
    for(let i=0; i<EltText.length; i++){
        EltText[i].addEventListener('input',(e)=>{
            let idText = e.currentTarget.id; 
            let valueText = e.currentTarget.value;
            idText = idText.replace('tweet-text','');
            for(let j=0; j<EltCountText.length; j++){
                let idCount = EltCountText[j].id; 
                idCount = idCount.replace('count-text','');
                if(idText === idCount){
                    EltCountText[j].innerHTML = (140-valueText.length).toString();
                }
            }
            for(let j=0; j<EltMentions.length; j++){
                let idMentions = EltMentions[j].id; 
                idMentions = idMentions.replace('text-mentions','');
                if(idText === idCount){
                    EltMentions[j].innerHTML = (140-valueText.length).toString();
                }
            }
    
        })
    }
}



