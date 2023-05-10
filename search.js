const getAllProducts = async(search) => {

    const response = await fetch('_include/header.php?getAll=1&search=' + search);
    const products = await response.json();

    return products;
}

const displayGamesSearch = async(search, pageNum) => {

    const tabHTML = await getAllProducts(search);

    mainSearch.innerHTML = "";

    if (tabHTML['noResult']) {

        const paraNoResult = document.createElement('p');
        paraNoResult.className = "noResultText";
        paraNoResult.innerHTML = tabHTML['noResult'];
        mainSearch.appendChild(paraNoResult);
        
    }else{

        tabHTML[pageNum] = Object.values(tabHTML[pageNum])

        const divAllGamesSearch = document.createElement('div');
        divAllGamesSearch.className = 'allGamesSearch';
        mainSearch.appendChild(divAllGamesSearch);

        tabHTML[pageNum].forEach(gameHTML => {

            divAllGamesSearch.innerHTML = divAllGamesSearch.innerHTML + gameHTML;
        });
    }
}

const displayPaginationSearch = async(search) => {

    const tabHTML = await getAllProducts(search);

    const divDisplayPaginationSearch = document.createElement('div')
    divDisplayPaginationSearch.id = 'displayPaginationSearch';
    mainSearch.appendChild(divDisplayPaginationSearch)

    if (tabHTML['numPage'] === undefined) {

        divDisplayPaginationSearch.innerHTML = divDisplayPaginationSearch.innerHTML + '<i class="fa-solid fa-angle-left" id="previousPageSearch"></i>';

        divDisplayPaginationSearch.innerHTML = divDisplayPaginationSearch.innerHTML + '<p class="changePageSearch" id="page1">1</p>';

        divDisplayPaginationSearch.innerHTML = divDisplayPaginationSearch.innerHTML + '<i class="fa-solid fa-angle-right" id="nextPageSearch"></i>';
        
    }else{

        divDisplayPaginationSearch.innerHTML = divDisplayPaginationSearch.innerHTML + '<i class="fa-solid fa-angle-left" id="previousPageSearch"></i>';

        for (const page in tabHTML['numPage']) {
            if (Object.hasOwnProperty.call(tabHTML['numPage'], page)) {

                let actualPage = tabHTML['numPage'][page];

                divDisplayPaginationSearch.innerHTML = divDisplayPaginationSearch.innerHTML + actualPage;
            }
        }

        divDisplayPaginationSearch.innerHTML = divDisplayPaginationSearch.innerHTML + '<i class="fa-solid fa-angle-right" id="nextPageSearch"></i>';
    }

    let changePageSearch = document.getElementsByClassName('changePageSearch');

    for (const paginationSearch of changePageSearch) {

        paginationSearch.addEventListener('click', async() => {

            const allSiblingsAndActual = paginationSearch.parentNode.childNodes;

            allSiblingsAndActual.forEach(element => {

                element.classList.remove('actualPage');
                
            });

            paginationSearch.className = paginationSearch.className + ' actualPage';

            pageNumSearch = paginationSearch.innerHTML;

            displayGamesSearch(searchBar.value, pageNumSearch);
            changePageSearch = await displayPaginationSearch(searchBar.value);

        })
    }
}



const searchBar = document.getElementById('searchBar');
const iconSearch = document.getElementById('iconSearch');

const mainList = document.getElementsByTagName('main');
const mainBefore = mainList[0];

const bodyList = document.getElementsByTagName('body');
const body = bodyList[0];

const mainSearch = document.createElement('main');
mainSearch.className = "searchMain";
const footer = document.getElementsByTagName('footer')[0];

mainBefore.style.display = "block";
footer.style.display = "block";
mainSearch.style.display = "none";


searchBar.addEventListener('focus', () => {
    iconSearch.className = 'fa-solid fa-xmark';
})

searchBar.addEventListener('focusout', () => {
    iconSearch.className = 'fa-solid fa-magnifying-glass';
})

searchBar.addEventListener('keyup', async() => {

    pageNumSearch = 1;

    mainBefore.style.display = "none";
    footer.style.display = "none";
    mainSearch.style.display = "flex";

    body.appendChild(mainSearch);

    displayGamesSearch(searchBar.value, pageNumSearch);
    displayPaginationSearch(searchBar.value);

    searchBar.addEventListener('focusout', () => {
        iconSearch.className = 'fa-solid fa-xmark';
    })

    iconSearch.addEventListener('click', () => {

        searchBar.value = "";

        pageNumSearch = 1;
    
        mainBefore.style.display = "block";
        footer.style.display = "block";
        mainSearch.style.display = "none";

        iconSearch.className = 'fa-solid fa-magnifying-glass';
    })

});

window.addEventListener('unload', () => {
    searchBar.value = "";
});