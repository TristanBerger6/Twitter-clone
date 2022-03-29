/**
 *  Add a preview image for inputs when posting a tweet.
 *  
 */
export function usePreviewImages(){
    // Each of the elements with the following class also have an id with the same name + a number.
    // (ex id=input-img1 id=preview-input1 ..) to find the elements belonging to the same entity.
    let EltInput = document.getElementsByClassName('input-img');
    let EltPreviewInput = document.getElementsByClassName('preview-input');
    let EltClosePreview = document.getElementsByClassName('close-preview');
    
    
    for (let i=0; i<EltInput.length; i++){ // foreach Input element
        EltInput[i].addEventListener('change',(event)=>{
            let idInput = event.currentTarget.id.replace('input-img',''); // find the id (2 for input-img2)
            let objectUrl = event.target.files[0];
            for (let j = 0; j < EltPreviewInput.length; j++) { // look for the corresponding element preview
                let idPreview = EltPreviewInput[j].id.replace('preview-input','');
                if( idPreview === idInput){ // found the corresponding one
                    var src = URL.createObjectURL(objectUrl);
                    EltPreviewInput[j].src = src;
                    if(EltPreviewInput[j].classList.contains('img-tweet-preview')){
                        EltPreviewInput[j].style.display = 'grid';
                        for (let k=0; k<EltClosePreview.length; k++){ // look for the corresonding close preview
                            let idClose = EltClosePreview[k].id.replace('close-preview','');
                            if( idPreview === idClose ){ // found the corresponding one
                                EltClosePreview[k].style.display= 'grid';
                            }
                        }
    
                    }
                }
            }
        })
    }
    
    // reverse process to close th preview
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






