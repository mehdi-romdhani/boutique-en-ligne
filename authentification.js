//*********************** FUNCTIONS ***********************//

const fetchForm = async (lequel) => {

    const response = await fetch('back_authentification.php?' + lequel + '=1');
    const form = await response.text();

    return form;

}

const displayForm = (form) => {

    divForm.innerHTML = "";
    divForm.innerHTML = form;

}

const whenSubmit = async (form, lequel, e) => {

    e.preventDefault();
    const formData = new FormData(form);

    const response = await fetch('back_authentification.php?' + lequel + '=1', { method: "POST", body: formData });
    const dataJSON = await response.json();

    if(lequel === 'signup') {
        displayErrorsSignup(dataJSON);
    }

    if(lequel === 'signin') {
        displayErrorsSignin(dataJSON);
    }

}

const displayErrorsSignup = async(dataJSON) => {

    const errorLoginDiv = document.getElementById('errorLogin');
    errorLoginDiv.innerHTML = "";

    const errorPassDiv = document.getElementById('errorPass');
    errorPassDiv.innerHTML = "";

    const errorEmailDiv = document.getElementById('errorEmail');
    errorEmailDiv.innerHTML = "";

    if(dataJSON['errorLogin']) {
        const paraErrorLogin = document.createElement("p");
        paraErrorLogin.textContent = dataJSON['errorLogin'];
        paraErrorLogin.className = 'error';
        errorLoginDiv.appendChild(paraErrorLogin);
    }
    if(dataJSON['errorLoginExist']) {
        const paraErrorLoginExist = document.createElement("p");
        paraErrorLoginExist.textContent = dataJSON['errorLoginExist'];
        paraErrorLoginExist.className = 'error';
        errorLoginDiv.appendChild(paraErrorLoginExist);
    }
    if(dataJSON['errorEmail']) {
        const paraErrorEmail = document.createElement("p");
        paraErrorEmail.textContent = dataJSON['errorEmail'];
        paraErrorEmail.className = 'error';
        errorEmailDiv.appendChild(paraErrorEmail);
    }
    if(dataJSON['errorPassMatch']) {
        const paraErrorPassMatch = document.createElement("p");
        paraErrorPassMatch.textContent = dataJSON['errorPassMatch'];
        paraErrorPassMatch.className = 'error';
        errorPassDiv.appendChild(paraErrorPassMatch);
    }
    if(dataJSON['errorPassLong']) {
        const paraErrorPassLong = document.createElement("p");
        paraErrorPassLong.textContent = dataJSON['errorPassLong'];
        paraErrorPassLong.className = 'error';
        errorPassDiv.appendChild(paraErrorPassLong);
    }
    if(dataJSON['errorRegDb']) {
        const paraErrorRegDb = document.createElement("p");
        paraErrorRegDb.textContent = dataJSON['errorRegDb'];
        paraErrorRegDb.className = 'error';
        errorPassDiv.appendChild(paraErrorRegDb);
    }
    if(dataJSON['okReg']) {

        form = await fetchForm('connexion');
    
        displayForm(form);
    
        switchConnexion.style.display = "none";
        switchInscription.style.display = "block";

        alert(dataJSON['okReg']);
    }

}

const displayErrorsSignin = (dataJSON) => {
    const errorLoginDiv = document.getElementById('errorLogin');
    errorLoginDiv.innerHTML = "";

    const errorPassDiv = document.getElementById('errorPass');
    errorPassDiv.innerHTML = "";
    
    if(dataJSON['errorLogin']) {
        const paraErrorLogin = document.createElement("p");
        paraErrorLogin.textContent = dataJSON['errorLogin'];
        paraErrorLogin.className = 'error';
        errorLoginDiv.appendChild(paraErrorLogin);
    }

    if(dataJSON['errorPass']) {
        const paraErrorPass = document.createElement("p");
        paraErrorPass.textContent = dataJSON['errorPass'];
        paraErrorPass.className = 'error';
        errorPassDiv.appendChild(paraErrorPass);
    }

    if(dataJSON['okConn']) {
        alert(dataJSON['okConn']);
        document.location.href="index.php"; 
    }
}

//********************* END FUNCTIONS *********************//



const switchInscription = document.getElementById('switchInscription');
const switchConnexion = document.getElementById('switchConnexion');
const divForm = document.getElementById('divForm');

window.addEventListener('load', async() => {
        
    const signinForm = document.getElementById('signinForm');
    console.log(signinForm);
    
    signinForm.addEventListener('submit', (e) => {

        whenSubmit(signinForm, 'signin', e);

    })

})

switchInscription.addEventListener('click', async() => {

    form = await fetchForm('inscription');

    displayForm(form);

    switchInscription.style.display = "none";
    switchConnexion.style.display = "block";
    
    const signupForm = document.getElementById('signupForm');

    signupForm.addEventListener('submit', (e) => {

        whenSubmit(signupForm, 'signup', e);

    })
})

switchConnexion.addEventListener('click', async() => {

    form = await fetchForm('connexion');

    displayForm(form);

    switchConnexion.style.display = "none";
    switchInscription.style.display = "block";
        
    const signinForm = document.getElementById('signinForm');
    
    signinForm.addEventListener('submit', (e) => {

        whenSubmit(signinForm, 'signin', e);

    })
})