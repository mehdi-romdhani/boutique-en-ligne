window.addEventListener('DOMContentLoaded',()=>{
    
    const formShipping = document.querySelector('#form_shipping');
    const paraForm = document.querySelector('#mess_form');

    //Event 
    formShipping.addEventListener('submit',(e)=>{
        e.preventDefault();
        insertINFO(formShipping);
        console.log('test');
    })

     const insertINFO = async (formData) =>{
        const getUrl = await fetch('./shipping.php?ship=1',{
            method:"POST",
            body : new FormData(formData)
        });

        const response = await getUrl.json();

        if(response['infoShippinFalse']){
            paraForm.textContent = response['infoShippinFalse'];
        }else if(response['infoShippin']){
            paraForm.textContent = response['infoShippin'];
        }
        console.log(response);
     }
})
