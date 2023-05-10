let carousel = document.querySelector("#carousel");
let previous = document.querySelector("#prev");
let next = document.querySelector("#next");
let link = document.querySelector("#carousel-link");
let img = document.querySelector("#carousel-img");

const getArray = async () => {
  const response = await fetch("index.php?getArray=ok");
  return await response.json();
};


const displayImage = (e, array, previous, next, link, img) => {
  let i = 0;

  link.href = "product.php?id=" + array[i].id;
  img.src = array[i].image;

  next.addEventListener("click", () => {
    i++;

    if (i > array.length - 1) {
      i = 0;
    }

    link.href = "product.php?id=" + array[i].id;
    img.src = array[i].image;
  });

  previous.addEventListener("click", () => {
    i--;

    if (i < 0) {
      i = array.length - 1;
    }
    link.href = "product.php?id=" + array[i].id;
    img.src = array[i].image;
  });
};

window.addEventListener("load", async (e) => {
  let array = await getArray();
  displayImage(e, array, previous, next, link, img);
});

const hamburger = document.querySelector(".hamburger");
const navMenu = document.querySelector(".nav-menu");
const navLinks = document.querySelectorAll(".nav-menu ul li a");
const btnClose = document.querySelector(".btn-close");

hamburger.addEventListener("click", () => {
  hamburger.classList.toggle("active");
  navMenu.classList.toggle("active");
  body.classList.toggle("active");
});

navLinks.forEach((link) => {
  link.addEventListener("click", () => {
    hamburger.classList.remove("active");
    navMenu.classList.remove("active");
    body.classList.remove("active");
  });
});

btnClose.addEventListener("click", () => {
  navMenu.classList.remove("active");
  body.classList.remove("active");
});

window.addEventListener("resize", function () {
  var exampleDiv = document.querySelector(".container-search");

  if (window.innerWidth < 769) {
    exampleDiv.classList.add(".container-search");
  } else {
    exampleDiv.classList.remove(".container-search");
  }
});

const accueil = document.querySelector(".accueil");

accueil.addEventListener("animationend", () => {
  accueil.style.display = "none";
});

const animationJouee = sessionStorage.getItem('animationJouee');

if (!animationJouee) {
    
  accueil.classList.add('anim-jouee');
  
  sessionStorage.setItem('animationJouee', 'true');
} else {
  accueil.style.display = 'none';
}
