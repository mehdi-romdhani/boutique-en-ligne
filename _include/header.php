<?php

require_once(__DIR__ . "/../autoloader.php");

use App\Controller\ProductController;

$product = new ProductController();

if (isset($_GET['getAll'])) {

  $searchResult = $product->GetAllByLetters($_GET['search']);

  if (isset($searchResult[0]) && $searchResult[0] != "") {

    $pages = [];

    $numPage = 0;

    for ($i = 0; $i < sizeof($searchResult); $i += 6) {

      $numPage++;

      for ($j = $i; $j < $i + 6; $j++) {

        if (isset($searchResult[$j])) {
          for ($j=$i; $j < $i+6; $j++) {
              
            if(isset($searchResult[$j])) {

              strlen($searchResult[$j]['title']) > 10 ? $searchResult[$j]['titleMobile'] = substr($searchResult[$j]['title'], 0, 10) . "..." : $searchResult[$j]['titleMobile'] = $searchResult[$j]['title'] ;
              strlen($searchResult[$j]['title']) > 20 ? $searchResult[$j]['titleDesktop'] = substr($searchResult[$j]['title'], 0, 20) . "..." : $searchResult[$j]['titleDesktop'] = $searchResult[$j]['title'] ;    

              $pages[$numPage][$j] =
              '<div class="oneGame">
                  <a href="product.php?id=' . $searchResult[$j]['id'] . '"><img src="' . $searchResult[$j]['image'] . '" alt="" /></a>
                  <div class="titrePrix">
                    <a href="product.php?id=' . $searchResult[$j]['id'] . '" class="titleMobileSearch">' . $searchResult[$j]['titleMobile'] . '</a>
                    <a href="product.php?id=' . $searchResult[$j]['id'] . '" class="titleDesktopSearch">' . $searchResult[$j]['titleDesktop'] . '</a>
                    <a href="product.php?id=' . $searchResult[$j]['id'] . '"><p>' . substr_replace($searchResult[$j]['price'], '.', -2, 0) . '€' . '</p></a>
                  </div>
              </div>';
            }
          }
        }
      }
      $pages['numPage'][$numPage] = '<p class="changePageSearch" id="page' . $numPage . '">' . $numPage;
    }
  } else {
    $pages['noResult'] = "There is no product that match your search";
  }

  $json = json_encode($pages, JSON_PRETTY_PRINT);
  echo $json;

  die();
}

?>



<div class="header-container">

  <button class="hamburger">
    <span class="hamburger-icon"></span>
    <span class="hamburger-icon"></span>
    <span class="hamburger-icon"></span>
  </button>


  <div class="container-search">
    <a href="./index.php"> <img class="logo" src="./_img/newnewlogo.png" alt="logo"></a>
    <form class="search-form">
      <input type="text" name="searchBar" id="searchBar" placeholder="Search..."><i class="fa-solid fa-magnifying-glass" id="iconSearch"></i>
    </form>
  </div>


  <div class="user-info">

  <?php if (!isset($_SESSION['user'])) : ?><i class="fas fa-shopping-cart" id="cart-no-log"></i><?php endif ?>
  <?php if (isset($_SESSION['user'])) : ?> <a href="cart.php" class="cart"><i class="fas fa-shopping-cart"></i></a><?php endif ?>

    <!-- <a href="cart.php" class="cart"><i class="fas fa-shopping-cart"></i></a> -->
    <?php if (!isset($_SESSION['user'])) : ?> <a href="./authentification.php" class="login">Connect</a><?php endif ?>
    <?php if (isset($_SESSION['user'])) : ?> <a href="./disconnect.php" class="login">Disconnect</a><?php endif ?>

  </div>
  <nav class="nav-menu">
    <button class="btn-close"><span class="hamburger-icon fa fa-times"></span>
    </button>
    <!-- <p style="color:white">locale_lookup</p> -->
    <ul>
      <li><a href="index.php">Home</a></li>
      <!-- <li><?php if (!isset($_SESSION['user'])) : ?> <a href="authentification.php">Authenticate</a> <?php endif ?></li> -->
      <li><?php if (isset($_SESSION['user'])) : ?> <a href="profile.php">Profile</a> <?php endif ?></li>
      <li><a href="all_products.php">All products</a></li>
      <!-- <li><a href="platform.php">Platform</a></li> -->
      <li><?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') : ?> <a href="admin.php">Admin</a> <?php endif ?></li>
    </ul>
  </nav>
</div>