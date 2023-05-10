const getRolesJSON = async() => {                                       // recupere les noms et les id de tous les roles de la db
    
    const response = await fetch('admin.php?getAllRoles=1');            // renvoie un tableau JSON avec les id et noms de tous les roles
    const dataJSON = await response.json();

    return dataJSON;

}

const displaySelectRoles = async(functionToUse, selectId) => {          // ajouter les roles en option dans le select

    const rolesJSON = await functionToUse;                              // choisir quelle fonction va etre utiliser pour recuperer les data des roles (tous les roles ou tous sauf l'actuel)

    const parentSelect = document.getElementById(selectId);             // cibler le select dans lequel on veux ajouteren option les roles recuperer

    rolesJSON.forEach(role => {                                         // parcourir le JSON recupere avec la fonction (les id et nom des roles)

        let selectRole = document.createElement("option");              // creer un element option
        selectRole.value = role['id'];                                  // lui attribuer l'id du role en value
        selectRole.innerHTML = role['role'];                            // lui attribuer le nom du role pour l'afficher dans la liste
        parentSelect.appendChild(selectRole);                           // append l'option dans le select
        
    });

}


const getRoleByInput = async(roleId) => {                               // recuperer un JSON des data de tous les user avec le role choisi

    const response = await fetch('admin.php?inputRole=' + roleId);      // renvoie un tableau JSON de toutes les data des users appartenant au role choisi
    const userDataJSON = await response.json();

    return userDataJSON;

}

const getAllRolesExeptActualJSON = async(actualRoleId) => {

    const response = await fetch('admin.php?actualRole=' + actualRoleId);
    const roles = await response.json();

    return roles;

}

const displayUserDataByRole = async(roleId) => {                            // display un table HTML avec les data des user qui ont le role choisi

    const displayDiv = document.getElementById('displayUserData');

    const response = await fetch('admin.php?tableUserRole=' + roleId);
    const table = await response.text();

    displayDiv.innerHTML = "";
    displayDiv.innerHTML = table;


    /******************* Change role *******************/

    const selectChangeRole = document.getElementsByClassName('selectChangeRole');

    for(let select of selectChangeRole) {
        
        select.onchange = async(e) => {                                    // quand on choisis le role dans le select

            const roleId = e.target.value;                                      // on recupere la value de l'option choisie (l'id de role)
            whenChangeRole(select.name, roleId);                                      // et on display les users qui correspondent au role choisis
        
        }

    };


    /******************* Click infos *******************/

    const infoButtons = document.getElementsByClassName('infoUser');

    for (let button of infoButtons) {

        button.addEventListener('click', async() => {

            const infosDiv = document.getElementById('infosUser' + button.value);


            if(infosDiv.style.display === "none") {

                infosDiv.style.display = "block";

            }else{

                infosDiv.style.display = "none";

            }
        }) 
    }


    /******************* Click delete *******************/

    const deleteButton = document.getElementsByClassName('supprUser');

    for (let buttonD of deleteButton) {
        


        buttonD.addEventListener('click', async() => {

            if(window.confirm("Do you really want to delete this user ?")) {

                const response = await fetch('admin.php?deleteUser=' + buttonD.value);
                await response.text();

                buttonD.parentNode.parentNode.parentNode.removeChild(buttonD.parentNode.parentNode);

            }
        })
    }
}

const whenChangeRole = async(selectName, optionValue) => {                      // selectName = id user / optionValue = id role

    const response = await fetch('admin.php?changeRole=' + optionValue + '&userId=' + selectName);
    const message = await response.text();


}







const rolesSelect = document.getElementById('role');                    // cible le select de role

// AFFICHER LES ROLES DANS LE SELECT
displaySelectRoles(getRolesJSON(), 'role');                             // getRolesJSON recupere tous les roles et displaySelectRoles cree les options correspondantes dans le select
displayUserDataByRole('all');                                           // display tous les users dans la div

rolesSelect.onchange = async(e) => {                                    // quand on choisis le role dans le select

    const roleId = e.target.value;                                      // on recupere la value de l'option choisie (l'id de role)
    displayUserDataByRole(roleId);                                      // et on display les users qui correspondent au role choisis

}