let shipping= document.querySelector("#shipping_method");
let payment = document.querySelector("#payment_method");
let summary = document.querySelector("#summary_game");
let buy = document.querySelector("#button_buy");


const pattern = (input, event) => {



    input.addEventListener(event, (e) => {


        e.target.value = e.target.value.replace(/[^/\dA-Z]/g, '').replace(/(.{2})/g, '$1/').trim();

    })
}

const fetchFormPayment = async() => {
    const response = await fetch("payment_back.php?formPayment")
    const form = await response.text();

    return form;
}

const fetchInputBuy = async() => {
    const response = await fetch("payment_back.php?buttonBuy")
    return await response.text();
}

const displayForm = (place, form) => {
    place.innerHTML = "";
    place.innerHTML = form;
}

const summaryGames = async() => {
    const response = await fetch("payment_back.php?summaryGame=ok");
    const summaryGame = await response.json();

    displaySummary(summary, summaryGame)
}

const getAdressById = async() => {

    const response = await fetch("payment_back.php?shippingAdress=ok")
    const getAdress = await response.json();
    displayAdress(getAdress, shipping);
}

const buyCart = async(e, form) => {

    e.preventDefault();

    let formData = new FormData(form)

    const response = await fetch('payment_back.php?updateCart=ok', {
        method: "POST",
        body: formData
    })
    const updateCart = await response.json();

    return displayError(updateCart);
}

const displayError = (json) => {

    const adress_error = document.querySelector("#error_adress");
    adress_error.innerHTML = "";


    const cardNumber_error = document.querySelector("#error-card-number");
    cardNumber_error.innerHTML = "";


    const cardExpiration_error = document.querySelector("#error-expiration-date");
    cardExpiration_error.innerHTML = "";


    const cardAuth_error = document.querySelector("#error-cvv");
    cardAuth_error.innerHTML = "";


    const cardName_error = document.querySelector("#error-card-name");
    cardName_error.innerHTML = "";


    if(json['errorAdress']) {
        adress_error.innerHTML = json['errorAdress'];
    }
    if(json['errorCardNumber']) {
        cardNumber_error.innerHTML = json['errorCardNumber'];
    }
    if(json['errorCardExpiration'])
    {
        cardExpiration_error.innerHTML = json['errorCardExpiration'];
    }
    if(json['errorCardAuth'])
    {
        cardAuth_error.innerHTML = json['errorCardAuth'];
    }
    if(json['errorCardName'])
    {
        cardName_error.innerHTML = json['errorCardName'];
    }
    if(json['okCart'])
    {
        return json['okCart'];
    }



}

const displayAdress = (json, place) => {

    const title_place = document.createElement("h3");
    title_place.innerHTML = "At your home";
    title_place.setAttribute("class", "title_place");
    place.appendChild(title_place);

    for(display of json)
    {

        const div_display = document.createElement("div");
        div_display.setAttribute("class", "flex-adress");
        place.appendChild(div_display);

        place.appendChild(div_display)
        const info = document.createElement("div");
        info.setAttribute("class", "div_info");
        div_display.appendChild(info);

        const name = document.createElement("p");
        name.innerHTML = display.firstname + " " + display.lastname;
        name.setAttribute("class", "name");
        info.appendChild(name);

        const adress = document.createElement("p")
        adress.innerHTML = display.adress;
        adress.setAttribute("class", "adress");
        info.appendChild(adress);

        const city = document.createElement("p")
        city.innerHTML = display.city + "," + display.postal_code;
        city.setAttribute("class", "adress");
        info.appendChild(city);


        const country = document.createElement("p")
        country.innerHTML = display.country;
        country.setAttribute("class", "country");
        info.appendChild(country);

        const inputs = document.createElement("div");
        inputs.setAttribute("class", "input")
        div_display.appendChild(inputs);

        const radio = document.createElement("input");
        radio.setAttribute("form", "payment");
        radio.setAttribute("type", "radio");
        radio.setAttribute("value", display.id);
        radio.setAttribute("name", "shipping");
        radio.setAttribute("id", "shipping")
        inputs.appendChild(radio)

        const lineBreak = document.createElement("hr")
        place.appendChild(lineBreak)


    }
    const error_adress = document.createElement("small");
    error_adress.setAttribute("id", "error_adress");
    place.appendChild(error_adress);
}


const displayPrice = (price) => {
    return price / 100;
}
const displaySummary = (place, summary) => {
    for(display of summary)
    {
        const div_display = document.createElement("div");
        div_display.setAttribute("class", "display-summary")
        place.appendChild(div_display)


        const div_container = document.createElement("div");
        div_container.setAttribute("class", "flex-element")
        div_display.appendChild(div_container);

        const div_name_price = document.createElement("div");
        div_name_price.setAttribute("class", "flex-price")
        div_container.appendChild(div_name_price)

        const name = document.createElement("p");
        name.innerHTML = display.title
        name.setAttribute("class", "name-summary")
        div_name_price.appendChild(name)

        const price = document.createElement("p");
        price.innerHTML = displayPrice(display.price) + "€";
        price.setAttribute("class", "price-summary")
        div_name_price.appendChild(price)

        const div_platform_quantity = document.createElement("div");
        div_platform_quantity.setAttribute("class", "flex-platform")
        div_container.appendChild(div_platform_quantity)


        const platform = document.createElement("p");
        platform.innerHTML = display.platform
        platform.setAttribute("class", "platform-summary")
        div_platform_quantity.appendChild(platform);

        const quantity = document.createElement("p");
        quantity.innerHTML = "Qt : " + display.quantity
        quantity.setAttribute("class", "quantity-summary");
        div_platform_quantity.appendChild(quantity)

        const lineBreak = document.createElement("hr")
        place.appendChild(lineBreak)
    }
}

window.addEventListener("load", async() => {

    let form = await fetchFormPayment();


    displayForm(payment, form);

    await getAdressById();

    await summaryGames();

    let button_buy = await fetchInputBuy();
    displayForm(buy, button_buy)

    let form_bought = document.querySelector("#payment");

    form_bought.addEventListener("submit", async(e) => {

           if(await buyCart(e, form_bought) === "okCart")
           {
               window.location.href = "order_summary.php";
           }




    })
})



if(window.location.href === "http://localhost/boutique-en-ligne/order_summary.php")
{
    setTimeout(() => {
        window.location.href = 'index.php'
    }, 8000);
}

