const getCartContentHTML = async() => {

    const response = await fetch('cart.php?getCart=1');
    const cartContentJSON = await response.text();

    return cartContentJSON;
}

const displayGames = async() => {

    const content = JSON.parse(await getCartContentHTML());

    const main = document.getElementsByTagName('main')[0];

    const divCartContent = document.getElementById('displayCartContent');

    const divAllGames = document.createElement('div');
    divAllGames.className = 'divAllGames';
    divAllGames.innerHTML = "";
    divCartContent.appendChild(divAllGames);


    if(content['isEmpty'] === false) {

        for (const game in content) {
            if (Object.hasOwnProperty.call(content, game)) {

                const element = content[game];

                if(game === "displayGame") {

                    for (const gameHTML in element) {
                        if (Object.hasOwnProperty.call(element, gameHTML)) {
                            
                            const htmlGame = element[gameHTML];
                            divAllGames.innerHTML = divAllGames.innerHTML + htmlGame;
                        }
                    }                
                }
            }
        }

        const deleteButtons = document.getElementsByClassName('deleteGameCart');

        for (const deleteButton of deleteButtons) {

            deleteButton.addEventListener('click', async() => {

                const response = await fetch('cart.php?deleteItem=' + deleteButton.id);
                const result = await response.text();

                const allGames = deleteButton.parentNode.parentNode.parentNode.parentNode;
                const gameToDelete = deleteButton.parentNode.parentNode.parentNode;

                gameToDelete.innerHTML = result;

                setTimeout(() => {
                    allGames.removeChild(gameToDelete)
                }, 5000);

                displayPrice();
            })
        }

        let numOfTest = document.getElementsByClassName('numOf');

        for (const elementNumOf of numOfTest) {

            let numOf = elementNumOf.innerHTML;
            const itemId = elementNumOf.classList[0];
            const quantiteMoins = elementNumOf.previousElementSibling;
            const quantitePlus = elementNumOf.nextElementSibling;
            const price = elementNumOf.parentElement.previousElementSibling;

            quantiteMoins.addEventListener('click', async() => {

                if(numOf > 1) {
                    numOf--;
                    elementNumOf.innerHTML = "";
                    elementNumOf.innerHTML = numOf;

                    const response = await fetch('cart.php?changeQuantity=' + numOf + '&itemId=' + itemId + '&plusMinus=minus')
                    const newPrice = await response.text();

                    price.innerHTML = newPrice;
                    displayPrice();
                }
            })

            quantitePlus.addEventListener('click', async() => {

                if(numOf < 50) {
                    numOf++;
                    elementNumOf.innerHTML = "";
                    elementNumOf.innerHTML = numOf;

                    const response = await fetch('cart.php?changeQuantity=' + numOf + '&itemId=' + itemId + '&plusMinus=plus');
                    const newPrice = await response.text();

                    price.innerHTML = newPrice;
                    displayPrice();
                }
            })
        }

    }else{

        divAllGames.innerHTML = content['displayGame'];

    }
}

const displayPrice = async() => {

    const content = JSON.parse(await getCartContentHTML());
    const divCartPriceBuy = document.getElementById('displayCartPriceBuy');

    const main = document.getElementsByTagName('main')[0];

    console.log(content);

    divCartPriceBuy.innerHTML = content['displayPriceBuy'];
}



const divInspired = document.getElementById('displayInspired');

window.addEventListener('load', async() => {
    
    displayGames();
    displayPrice();
});