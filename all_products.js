const displayGames = async(selectPlatform, selectCategory, selectSubcategory, pageNum) => {

    const divDisplayArticles = document.getElementById('displayArticles');

    const response = await fetch('all_products.php?games=1&platform=' + selectPlatform + '&category=' + selectCategory + '&subcategory=' + selectSubcategory);
    let schemaPages = await response.json();

    divDisplayArticles.innerHTML = "";

    if(schemaPages[pageNum] === undefined) {

        divDisplayArticles.innerHTML = "There is no products that fits you choices";

    }else{

        schemaPages[pageNum] = Object.values(schemaPages[pageNum])

        schemaPages[pageNum].forEach(gameHTML => {

            divDisplayArticles.innerHTML = divDisplayArticles.innerHTML + gameHTML;
            
        });
    }
}

const displayPagination = async(selectPlatform, selectCategory, selectSubcategory, pageNum) => {
    
    const divDisplayPagination = document.getElementById('displayPagination');

    const response = await fetch('all_products.php?pagination=1&platform=' + selectPlatform + '&category=' + selectCategory + '&subcategory=' + selectSubcategory);
    const schemaPages = await response.json();

    divDisplayPagination.innerHTML = "";

    if (schemaPages['numPage'] === undefined) {

        divDisplayPagination.innerHTML = divDisplayPagination.innerHTML + '<i class="fa-solid fa-angle-left" id="previousPage"></i>';

        divDisplayPagination.innerHTML = divDisplayPagination.innerHTML + '<p class="changePage" id="page1">1</p>';

        divDisplayPagination.innerHTML = divDisplayPagination.innerHTML + '<i class="fa-solid fa-angle-right" id="nextPage"></i>';
        
    }else{

        divDisplayPagination.innerHTML = divDisplayPagination.innerHTML + '<i class="fa-solid fa-angle-left" id="previousPage"></i>';

        for (const page in schemaPages['numPage']) {
            if (Object.hasOwnProperty.call(schemaPages['numPage'], page)) {

                let actualPage = schemaPages['numPage'][page];

                divDisplayPagination.innerHTML = divDisplayPagination.innerHTML + actualPage;
            }
        }

        divDisplayPagination.innerHTML = divDisplayPagination.innerHTML + '<i class="fa-solid fa-angle-right" id="nextPage"></i>';

    }

    const changePage = document.getElementsByClassName('changePage');
    

    return changePage;

}

const ifSelectChangeDo = async() => {

    pageNum = 1;

    await displayGames(selectPlatform.value, selectCategory.value, selectSubcategory.value, pageNum);
    changePage = await displayPagination(selectPlatform.value, selectCategory.value, selectSubcategory.value, pageNum);
    
    for (const pagination of changePage) {

        pagination.addEventListener('click', () => {

            pageNum = pagination.innerHTML;

            displayGames(selectPlatform.value, selectCategory.value, selectSubcategory.value, pageNum);
            displayPagination(selectPlatform.value, selectCategory.value, selectSubcategory.value, pageNum);

        })
    }
}






const filterForm = document.getElementById('filterForm');
const selectPlatform = document.getElementById('selectPlatform');
const selectCategory = document.getElementById('selectCategory');
const selectSubcategory = document.getElementById('selectSubcat');

window.addEventListener('load', async() => {

    let pageNum = 1;

    displayGames(selectPlatform.value, selectCategory.value, selectSubcategory.value, pageNum);
    let changePage = await displayPagination(selectPlatform.value, selectCategory.value, selectSubcategory.value, pageNum);

    changePage[0].className = changePage[0].className + ' actualPage';

    const previousPage = document.getElementById('previousPage');

    previousPage.addEventListener('click', () => {

        if(pageNum != 1) {
            pageNum--;
        }

        const paginationNum = nextPage.parentNode.childNodes;

        paginationNum.forEach(element => {

            element.classList.remove('actualPage');

            if(element.innerHTML == pageNum) {
                element.className = element.className + ' actualPage'
            }
            
        });

        displayGames(selectPlatform.value, selectCategory.value, selectSubcategory.value, pageNum);
    })

    const nextPage = document.getElementById('nextPage');

    nextPage.addEventListener('click', () => {

        if(pageNum != changePage.length) {
            pageNum++;
        }

        const paginationNum = nextPage.parentNode.childNodes;

        paginationNum.forEach(element => {

            element.classList.remove('actualPage');

            if(element.innerHTML == pageNum) {
                element.className = element.className + ' actualPage'
            }
            
        });

        displayGames(selectPlatform.value, selectCategory.value, selectSubcategory.value, pageNum);
    })


    for (const pagination of changePage) {

        pagination.addEventListener('click', () => {

            const allSiblingsAndActual = pagination.parentNode.childNodes;

            allSiblingsAndActual.forEach(element => {

                element.classList.remove('actualPage');
                
            });

            pagination.className = pagination.className + ' actualPage'

            pageNum = pagination.innerHTML;

            displayGames(selectPlatform.value, selectCategory.value, selectSubcategory.value, pageNum);

        })
    }
});


selectPlatform.onchange = async(e) => {
    ifSelectChangeDo();
}

selectCategory.onchange = async(e) => {
    ifSelectChangeDo();
}

selectSubcategory.onchange = async(e) => {
    ifSelectChangeDo();
}