<?php

    if(session_status() == PHP_SESSION_NONE){ session_start();}

    require_once ("autoloader.php");

    use App\Controller\ProductController;
    $product = new ProductController();

    function createOptionsSelect($table) {
    
        $product = new ProductController();

        $resultTab = $product->GetAllOneTable($table);

        $resultat = "";

        foreach ($resultTab as $result) {

            $resultat = $resultat . '<option value="' . $result[$table] . '">' . $result[$table] . '</option>'; 
        }

        return $resultat;
    }

    if(isset($_GET['getDataProduct'])) :

        $data = $product->GetDataOneProduct($_GET['getDataProduct']);

        $data[0]['price'] = substr_replace($data[0]['price'], ".", -2, 0) . "€";
        
        $displayProduct = [];
        $options = $product->getPlatformProduct($_GET['getDataProduct']);
        
        $displayProduct['part1'] = '
        <img src="' . $data[0]['image'] . '" alt="" id="productImage" />

        <div id="divDroite">

            <div id="titreShortDescrPrix">

                <div id="titreShortDescr">

                    <div class="titrePrixMobile">

                        <h2>' . $data[0]['title'] . '</h2>

                        <p class="priceMobile">' . $data[0]['price'] . '</p>
                    </div>

                    <p class="shortDescr">' . $data[0]['short_description'] . '...</p>

                    <a href="#decriptionProduct">Read more</a>
                </div>

                <p class="priceDesktop">' . $data[0]['price'] . '</p>
            </div>

            <div id="selectsButton">

                <select name="platform" id="selectPlatform">
                    <option value="">Platform</option>';
                    foreach ($options as $item) { $displayProduct['part1'] = $displayProduct['part1'] . '<option>' .$item["platform"]. '</option>';}
                $displayProduct['part1'] = $displayProduct['part1'] . '</select>

                <div id="quantity">
                    <p>Quantity</p>

                    <div id="quantityChoice">
                        <i class="fa-solid fa-circle-minus" id="quantiteMoins"></i>
                        <p id="quantiteNum">1</p>
                        <i class="fa-solid fa-circle-plus" id="quantitePlus"></i>
                    </div>
                </div>

                '; if(isset($_SESSION['user'])) {$displayProduct['part1'] = $displayProduct['part1'] . '<button id="cartButton"><i class="fa-solid fa-cart-plus"></i></button>';}else{$displayProduct['part1'] = $displayProduct['part1'] . '<button id="cartButton" disabled="disabled"><i class="fa-solid fa-cart-plus"></i></button>';};
            $displayProduct['part1'] = $displayProduct['part1'] . '</div>
        </div>';

        $displayProduct['part2'] = '
        <div id="divDescriptionAbout">

            <div id="titresDescriptionAbout">
                <span id="titreDescription"><h3>Description</h3></span>
                <span id="titreAbout"><h3>About the game</h3></span>
            </div>

            <div id="paraDescription" style="display: block;">
                <p>' . $data[0]['description'] . '</p>
            </div>

            <div id="paraAbout" style="display: none;">
                <p>Developper : ' . $data[0]['developper'] . '</p>
                <p>Publisher : ' . $data[0]['publisher'] . '</p>
                <p>Release date : ' . $data[0]['release_date'] . '</p>
                <p>Categories : ' . $data[0]['category'] . ', ' . $data[0]['subcategory'] . '</p>
            </div>
        </div>';

        $json = json_encode($displayProduct, JSON_PRETTY_PRINT);
        echo $json;

        die();

    endif;

    use App\Controller\CartController;
    $cart = new CartController;

    !isset($_GET['addToCart']) ?: ($message = $cart->AddProduct($_GET['addToCart'], $_GET['quantity'], $_GET['platformId'], $_SESSION['user']['actualCart'])) .(die());

?>

<!doctype html>
<html lang="en">
<head>
   <?php require_once("_include/head.php") ?>
    <script src="https://kit.fontawesome.com/1241fb6252.js" crossorigin="anonymous"></script>
    <script defer src="product.js"></script>
    <link rel="stylesheet" href="./assets/style.css">
    <link rel="stylesheet" href="assets/product.css" />
    <title>Products</title>
</head>
<body>
    <header>
        <?php require_once "_include/header.php" ?>
    </header>

    <main>
        <div id="displayImageTextSelect"></div>
        <div id="displayDescriptionAbout"></div>
    </main>

    <footer>
        <?php require_once "_include/footer.php" ?>
    </footer>
</body>
</html>