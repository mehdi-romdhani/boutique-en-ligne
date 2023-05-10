window.addEventListener("load", async () => {
 await  displayTableCat();
  await displayFormCat();
});

const containerParentCat = document.querySelector(".form-add-category");
const containerCat = document.querySelector(".container-table-cat");
const containerMessCat = document.querySelector(".container-mess-cat");
const paraCat = document.createElement("p");
containerMessCat.appendChild(paraCat);

const displayTableCat = async () => {
  const getUrlPage = await fetch("./cat_tab.php");
  const response = await getUrlPage.text();
  containerCat.innerHTML = response;

  const formCheckCat = document.querySelector("#form_check_cat");
  // console.log(formCheckCat);
  const checkBoxCat = document.querySelectorAll("#check");
  const checkBoxSubCat = document.querySelectorAll("#checksub");

  // console.log(checkBoxCat);

  checkBoxCat.forEach((check) => {
    // checkbox CATEGORY
    check.addEventListener("change", () => {
      console.log("Value checkbox cat : " + check.value);
    });
  });

  checkBoxSubCat.forEach((checkb) => {
    // checkbox SUBCATEGORY
    checkb.addEventListener("change", () => {
      console.log("Value check box sub : " + checkb.value);
    });
  });
};

const addCatForm = async (formData) => {
  const getUrl = await fetch("./admin.php?addCat=1", {
    method: "POST",
    body: new FormData(formData),
  });

  const response = await getUrl.json();
  displayMessForm(response);
  displayTableCat();
};

const addSubCatForm = async(formData)=>{
    const getUrl = await fetch('./admin.php?addSub=1',{
        method: "POST",
        body: new FormData(formData)
    })

    const response = await getUrl.json();
    displayMessForm(response);
    displayTableCat();


}



const displayMessForm = (dataJSON) => {
  if (dataJSON["notEnterCat"]) {
    paraCat.textContent = dataJSON["notEnterCat"];
    setTimeout(() => {
      paraCat.textContent = "";
    }, 3000);
  } else if (dataJSON["catEnter"]) {
    paraCat.textContent = dataJSON["catEnter"];
    setTimeout(() => {
      paraCat.textContent = "";
    }, 3000);
  } else if (dataJSON['subCatEmpty']){
    //empty;
    paraCat.textContent = dataJSON["subCatEmpty"];
    setTimeout(() => {
      paraCat.textContent = "";
    }, 3000);
  }
};

const displayFormCat = async () => {
  const getUrl = await fetch("./cat_form.php");
  const response = await getUrl.text();
  containerParentCat.innerHTML = response;
  const formCat = document.querySelector("#form-insert-category");
  const linkSubCat = document.querySelector("#linksubcat");

  formCat.addEventListener("submit", async (e) => {
    e.preventDefault();
    console.log("test");
    await addCatForm(formCat);
  });

  linkSubCat.addEventListener("click", (e) => {
    e.preventDefault();
    console.log("test");
    switchFormSub();
  });
};

const switchFormSub = async () => {
  // displayFormCat();
  const getUrl = await fetch("./sub_cat_form.php");
  const response = await getUrl.text();
  const formCat = document.querySelector("#form-insert-category");
  formCat.style.display = "none";
  containerParentCat.innerHTML = response;
  const formSubCat = document.querySelector('#form-insert-sub-category');
  const linkAddCat = document.querySelector("#insert_cat");

    formSubCat.addEventListener('submit',(e)=>{
        e.preventDefault();
        console.log("test");
        addSubCatForm(formSubCat);
    })
  linkAddCat.addEventListener("click", (e) => {
    e.preventDefault();
    console.log("test");
    displayFormCat();
  });


};
