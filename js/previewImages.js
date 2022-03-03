let EltCoverInput = document.getElementById('cover');
let EltProfileInput = document.getElementById('profile');

EltCoverInput.addEventListener('change',(event)=>{
    let EltPreviewCover = document.getElementById('cover-preview');
    var src = URL.createObjectURL(event.target.files[0]);
    console.log(event.target.files[0].size)
    if(event.target.files[0].size > 1000000){
        
    }
    EltPreviewCover.src = src;
 
})

EltProfileInput.addEventListener('change',(event)=>{
    let EltPreviewProfile = document.getElementById('profile-preview');
    var src = URL.createObjectURL(event.target.files[0]);
    EltPreviewProfile.src = src;
 
})