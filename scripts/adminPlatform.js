window.addEventListener("DOMContentLoaded", async () => {
   await displayPlat();
});
const formPlateform = document.querySelector("#form-insert-plateform");
const btnAddPlateform = document.querySelector("#add_plat");
const containeTablePlat = document.querySelector(".container-table-plat");

async function displayPlat() {
  const pageTable = await fetch("./plat_tab.php");
  const reponse = await pageTable.text();
  containeTablePlat.innerHTML = reponse;
  const checkBoxPlat = document.querySelectorAll(".check_plat");
  const formPlat = document.querySelector("#form_check_plat");

  checkBoxPlat.forEach((checkBox) => {
    checkBox.addEventListener("change", () => {
      if (checkBox.checked) {
        console.log(checkBox.value);
      }
    });
  });

  formPlat.addEventListener("submit", async (e) => {
    e.preventDefault();
    let showAlert = true;
    let checkedValue = null;
    checkBoxPlat.forEach((check) => {
      if (check.checked && showAlert) {
        checkedValue = check.value;
        showAlert = false;
      }
    });

    if (!checkedValue) {
      alert("Please select a platform to remove");
    } else if (
      checkedValue == 3 ||
      checkedValue == 2 ||
      checkedValue == 1
    ) {
      alert("You can't remove this platform");
    } else {
      if (confirm("Are you sure you want to delete this platform ?")) {
        await deletePlate(formPlat, checkedValue);
      }
    }
  });
}

async function addPlateform(form) {
  const getUrlFetch = await fetch("admin.php?tab=1", {
    method: "POST",
    body: form,
  });

  const dataJSON = await getUrlFetch.json();
  console.log(dataJSON);
  displayMess(dataJSON);
  displayPlat();
}

const deletePlate = async (data, id) => {
  try {
    const url = await fetch("./plat_tab.php?idPlat=" + id, {
      method: "POST",
      body: new FormData(data),
    });
    const response = await url.text();
    containeTablePlat.innerHTML = response;
    displayPlat(); //callback this function for see update !
  } catch (error) {
    console.error(error);
  }
};

function displayMess(dataJSON) {
  const containerPlateform = document.querySelector(
    ".container-mess-plateform"
  );

  containerPlateform.innerHTML = "";
  if (dataJSON["check_empty"]) {
    const paraPlat = document.createElement("p");
    paraPlat.textContent = dataJSON["check_empty"];
    containerPlateform.appendChild(paraPlat);
  } else if (dataJSON["not_empty"]) {
    const paraPlat = document.createElement("p");
    paraPlat.textContent = dataJSON["not_empty"];
    containerPlateform.appendChild(paraPlat);
    setTimeout(() => {
      paraPlat.textContent = "";
    }, 3000);
    containeTablePlat.innerHTML = "";
    // displayPlat();
  } else {
    console.log("dslkfs");
  }
}

formPlateform.addEventListener("submit", async (e) => {
  e.preventDefault();
  const form = new FormData(formPlateform);
  await addPlateform(form);
  console.log("form");
});

