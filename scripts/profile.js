const containerProfil = document.querySelector('.container-profil-left');



window.addEventListener('load', async()=>{
    await displayForm();
})



const displayForm = async ()=>{
    const getUrlForm = await fetch('./profile_form.php');
    const responseRequest = await getUrlForm.text();
    if (containerProfil) {

        containerProfil.innerHTML = responseRequest;
      }
    const formProfil = document.querySelector('#form_profil');
     const paraForm = document.querySelector('#mess_form');
    if(formProfil){

        formProfil.addEventListener('submit',async(e)=>{
            e.preventDefault();
            // console.log("toto");
            await getInfo(formProfil,paraForm);
            //displayMessProfil(response,paraForm);
        })
    }


}


// const displayMessProfil = (dataJSON,para) =>{

//     if(dataJSON['updateDATA']){
//         para.textContent = dataJSON['updateDATA'];
//     }else if(dataJSON['updateFULLDATA']){
//         para.textContent = dataJSON['updateFULLDATA'];
//     }

// }


// displayForm();

const getInfo  = async(formData,para) =>{
    const paraForm = document.querySelector('#mess_form');

    const url = await fetch('./profile.php?other=1',{
        method:"POST",
        body : new FormData(formData)

    })

    const response = await url.json();

    if(response['updateDATA']){
        para.textContent = response['updateDATA'];
    }else if(response['updateFULLDATA']){
        para.textContent = response['updateFULLDATA'];
    }else if(response['noSub']){
        para.textContent = response['noSub'];
    }

}




