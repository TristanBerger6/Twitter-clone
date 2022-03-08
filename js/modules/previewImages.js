
export function usePreviewImages(){
    let EltInput = document.getElementsByClassName('input-img');
    let EltPreviewInput = document.getElementsByClassName('preview-input');
    let EltClosePreview = document.getElementsByClassName('close-preview');
    
    
    for (let i=0; i<EltInput.length; i++){
        EltInput[i].addEventListener('change',(event)=>{
            let idInput = event.currentTarget.id; 
            idInput = idInput.replace('input-img','');
            let objectUrl = event.target.files[0];
            for (let j = 0; j < EltPreviewInput.length; j++) {
                let idPreview = EltPreviewInput[j].id;
                idPreview = idPreview.replace('preview-input','');
                if( idPreview === idInput){
                    var src = URL.createObjectURL(objectUrl);
                    EltPreviewInput[j].src = src;
                    if(EltPreviewInput[j].classList.contains('img-tweet-preview')){
                        EltPreviewInput[j].style.display = 'block';
                        for (let k=0; k<EltClosePreview.length; k++){
                            let idClose = EltClosePreview[k].id;
                            idClose = idClose.replace('close-preview','');
                            if( idPreview === idClose ){
                                EltClosePreview[k].style.display= 'block';
                            }
                        }
    
                    }
                }
            }
        })
    }
    
    for (let i=0; i<EltClosePreview.length; i++){
        EltClosePreview[i].addEventListener('click',(event)=> {
            let idClose = event.currentTarget.id; 
            idClose = idClose.replace('close-preview','');
            EltClosePreview[i].style.display = 'none';
            for (let j = 0; j < EltPreviewInput.length; j++) {
                let idPreview = EltPreviewInput[j].id;
                idPreview = idPreview.replace('preview-input','');
                if( idPreview === idClose){
                    EltPreviewInput[j].style.display = 'none';
                    for (let k=0; k<EltInput.length; k++){
                        let idInput = EltInput[k].id;
                        idInput = idInput.replace('input-img','');
                        if( idPreview === idInput){
                            EltInput[k].value = "";
                        }
                    }
    
                }
            }
    
        })
    
    }
}






