let buttonAddFormGame = document.querySelector("#addFormGame");
let buttonShowGames = document.querySelector("#showGames")
let placeAddGame = document.querySelector("#placeAddGame");
let placeShowGame = document.querySelector("#placeShowGames");





const fetchFormGame = async() => {
    const response = await fetch("admin_back.php?formAddGame=ok");
    const form = await response.text();

    return form;
}

const submitGame = async(e, form) => {
    e.preventDefault();

    let formDataGame = new FormData(form);
    const response = await fetch("admin_back.php?submitGame=1", {body: formDataGame, method: "POST"});
    const displayErrorJSON = await response.json()

    await displayErrorGame(displayErrorJSON);

}

const displayForm = (form, place) => {
    place.innerHTML = "";
    place.innerHTML = form;
}

const displayErrorGame = (json) => {
    const error_field = document.querySelector("#error-field");
    error_field.innerHTML = "";

    const error_title = document.querySelector("#error-title");
    error_title.innerHTML = "";

    const error_desc = document.querySelector("#error-desc");
    error_desc.innerHTML = "";

    const error_price = document.querySelector("#error-price");
    error_price.innerHTML = "";

    const error_checkbox = document.querySelector("#error-checkbox");
    error_checkbox.innerHTML = "";


    if(json["priceCheck"])
    {
        const price_error = document.createElement("small");
        price_error.innerHTML = json['priceCheck'];
        price_error.className = "error";
        error_price.appendChild(price_error);
    }
    if(json["lengthDesc"])
    {
        const desc_error = document.createElement("small");
        desc_error.innerHTML = json['lengthDesc'];
        desc_error.className = "error";
        error_price.appendChild(desc_error);
    }
    if(json["emptyValues"])
    {
        const field_error = document.createElement("small");
        field_error.innerHTML = json['emptyValues'];
        field_error.className = "error";
        error_field.appendChild(field_error);
    }
    if(json['titleTaken'])
    {
        const title_error = document.createElement("small");
        title_error.innerHTML = json['titleTaken'];
        title_error.className = "error";
        error_title.appendChild(title_error);
    }
    if(json['checkboxError'])
    {
        const checkbox_error = document.createElement("small");
        checkbox_error.innerHTML = json['checkboxError'];
        checkbox_error.className = "error";
        error_checkbox.appendChild(checkbox_error);
    }
    if(json['okAddGame'])
    {
        alert(json['okAddGame'])
        return "display"
    }

}



const displayAllGame = async() => {
    const response = await fetch("admin_back.php?showGame=1");
    const result = await response.json();

    return displayGame(result, placeShowGame);
}

const displayPrice = (price) => {
    return price / 100;
}

const displayGame = (game, place) =>{
    placeShowGame.innerHTML = "";
    for(const val of game)
    {


        const div_place_game = document.createElement("div");
        div_place_game.setAttribute("class", "div_place_game")
        place.appendChild(div_place_game);


        const image_game = document.createElement("img");
        image_game.setAttribute("src", val.image);
        image_game.setAttribute("class", "image_game");
        div_place_game.appendChild(image_game);

        const title_game = document.createElement("h2");
        title_game.setAttribute("class", "title_game");
        title_game.innerHTML = val.title;
        div_place_game.appendChild(title_game);

        const desc_game = document.createElement("p");
        desc_game.setAttribute("class", "desc_game");
        desc_game.innerHTML = val.description;
        div_place_game.appendChild(desc_game);

        const price_game = document.createElement("p");
        price_game.setAttribute("class", "price_game");
        let final_price = displayPrice(val.price);
        price_game.innerHTML = final_price + "€";
        div_place_game.append(price_game);

        const div_platform = document.createElement("div");
        div_platform.setAttribute("class", "div_platform")
        let platform_game;
        for(index of val.platforms)
        {
            platform_game = document.createElement("p");
            platform_game.setAttribute("class", "platform_game");
            platform_game.innerHTML = index.platform;
            div_platform.append(platform_game);
        }
        div_place_game.appendChild(div_platform);



        const update_game = document.createElement("button");
        update_game.setAttribute("value", val.id)
        update_game.setAttribute("class", "button_update");
        update_game.innerHTML = "Update";
        update_game.addEventListener("click", async() => {
            placeAddGame.innerHTML = "";
            let update_place = document.querySelectorAll(".update_place");
            if(update_place !== undefined)
            {
                for(formPlace of update_place)
                {
                    formPlace.innerHTML = "";
                }
            }
            let formUpdate = await fetchUpdateFrom(update_game.value);
                displayForm(formUpdate, update_game.nextSibling.nextSibling);

            let formSubmitGame = document.querySelector("#formGame");

            formSubmitGame.addEventListener("submit", async(e) => {
                let update = await updateGame(e, formSubmitGame, update_game.value);

                if(update === "display")
                {
                    await displayAllGame();
                }
            })
        })
        div_place_game.appendChild(update_game);

        const delete_game =document.createElement("button");
        delete_game.setAttribute("value", val.id)
        delete_game.setAttribute("class", "button_delete");
        delete_game.innerHTML = "Delete";
        delete_game.addEventListener("click", async() => {
            if(confirm('Are you sure you want to delete this game ??') === true)
            {
                deleteGame(delete_game.value);
                alert("Your game has been deleted")
                await displayAllGame();

            }
        })
        div_place_game.appendChild(delete_game);

        const update_place = document.createElement("div");
        update_place.setAttribute("id", val.id);
        update_place.setAttribute("class", "update_place");
        div_place_game.appendChild(update_place);
    }
}




const deleteGame = (idDelete) =>  {
    let formData = new FormData();
    formData.append("id" ,idDelete);

    const response = fetch("admin_back.php?deleteGame=ok", {
        method: "POST",
        body: formData
    })
}

const fetchUpdateFrom = async (id) => {
    let formData = new FormData();
    formData.append("id_update", id)

    const response = await fetch("admin_back.php?formAddGame=ok&updateGame=ok", {
        method: "POST",
        body: formData
    });
    const formUpdate = await response.text();

    return formUpdate
}

const updateGame = async(e, form, id) => {
    e.preventDefault()
    const formData = new FormData(form);
    formData.append("id" , id)
    const response = await fetch("admin_back.php?updateGame=ok", {
        method: "POST",
        body: formData
    })
    const json = await response.json();

    return displayErrorGame(json);
}



buttonAddFormGame.addEventListener('click', async() => {
    let formGame =  await fetchFormGame();
    displayForm(formGame, placeAddGame);
    let formSubmitGame = document.querySelector("#formGame");

    let update_place = document.querySelectorAll(".update_place");
    if(update_place !== undefined)
    {
        for(formPlace of update_place)
        {
            formPlace.innerHTML = "";
        }
    }


    formSubmitGame.addEventListener('submit', async (e) => {
        await submitGame(e, formSubmitGame);
        if(placeShowGame.innerHTML.length > 10 )
        {
           await displayAllGame();
        }
    })

})

buttonShowGames.addEventListener('click', async() => {
    await displayAllGame();

})


