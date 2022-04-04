/**
 * Update the profile will reload the page unless an error is detected by handleProfile.php. In that case
 * an error will appear in the modal without reloading the page.
*/
import { postForm } from "../utils/functions.js";

export function useUpdateProfile(){

    /****************** Elt Query ***************************/
    let modal = document.getElementsByClassName('modal6')[0];
    let modalBtn = document.getElementsByClassName('modalBtn6')[0];
    let modalClose = document.getElementsByClassName('modalClose6')[0];

    let EltSubmit = document.getElementById('submitUpdateProfile');
    let EltPreviewProfile = document.getElementById('preview-input7');
    let EltPreviewCover = document.getElementById('preview-input6');
    let EltInputProfile = document.getElementById('input-img7');
    let EltInputCover = document.getElementById('input-img6');
    let EltBio = document.getElementById('bio');
    let EltUsername = document.getElementById('username');
    let EltName = document.getElementById('name');
    let EltForm = document.getElementById('formUpdate');
    let EltError = document.getElementById('update-error');

    /*** variables to save the value of all the inputs *******/ 
    let savePreviewProfile = null;
    let savePreviewCover = null;
    let saveBio = null;
    let saveUsername = null;
    let saveName = null;


    /****************** Event Listeners ***************************/

    // When opening the modal, save the current values of all the inputs
    modalBtn.addEventListener('click',()=>{
        savePreviewProfile = EltPreviewProfile.src;
        savePreviewCover = EltPreviewCover.src;
        saveBio = EltBio.value;
        saveUsername = EltUsername.value;
        saveName = EltName.value;
    });


    // On submit, ajax to profile.php, display error if needed, close modal otherwise
    EltSubmit.addEventListener('click',(e)=>{
        e.preventDefault();
        let formdata = new FormData(EltForm);
        postForm(`index.php?handle=profile&updateProfile=1`,formdata)
        .then(res => {
            if(res.data == 'updated'){
                location.reload();
            }else{
                EltError.innerHTML = res.data.error;
            }
        })
    });


    // when closing the modal, reset all the value of the profile with the saved ones
    modalClose.addEventListener('click',(e)=>{
        EltPreviewProfile.src = savePreviewProfile;
        EltPreviewCover.src = savePreviewCover;
        EltInputProfile.value="";
        EltInputCover.value="";
        EltBio.value = saveBio;
        EltUsername.value = saveUsername;
        EltName.value = saveName;
        EltError.innerHTML = "";
    });

    document.addEventListener('click',(e) => {
        let check = null;
        let targetClassList = e.target.classList;
            for(let i=0; i<targetClassList.length; i++){
                if(targetClassList[i].match(/\d+/)){
                    check = targetClassList[i].replace(/[0-9]/g, '');
                }
            }
        if (check === 'modal') {
            EltPreviewProfile.src = savePreviewProfile;
            EltPreviewCover.src = savePreviewCover;
            EltInputProfile.value="";
            EltInputCover.value="";
            EltBio.value = saveBio;
            EltUsername.value = saveUsername;
            EltName.value = saveName;
            EltError.innerHTML = "";
        }
    });
}




