<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("autoloader.php");

use App\Controller\CartController;

$cart = new CartController();

$pageHTML = [];

if (isset($_GET['getCart'])) {

    if (isset($_SESSION['user'])) {

        $content = $cart->GetCartContent($_SESSION['user']['actualCart']);

        if (isset($content) && isset($content[0]) && $content[0] !== "") {

            foreach ($content as $game) {

                $game['price'] = substr_replace($game['price'], ".", -2, 0) . "€";
                $game['total_price'] = substr_replace($game['total_price'], ".", -2, 0) . "€";

                $pageHTML['isEmpty'] = false;

                $pageHTML['displayGame'][$game['id']] =
                    '<div class="oneGameCart">

                        <img src="' . $game['image'] . '" alt="" />

                        <div class="divGameNotImage">

                            <h3 class="titleGameCart">' . $game['title'] . '</h3>

                            <div class="platformDelete">

                                <p class="platformGame">' . $game['platform'] . '</p>
                                <i class="fa-solid fa-trash-can deleteGameCart" id="' . $game['id'] . '"></i>

                            </div>

                            <div class="priceQuantity">

                                <p class="price">' . $game['price'] . '</p>

                                <span id="quantityChoice">
                                    <i class="' . $game['id'] . ' fa-solid fa-circle-minus quantiteMoins"></i>
                                    <p class="' . $game['id'] . ' numOf" id="quantiteNum">' . $game['quantity'] . '</p>
                                    <i class="' . $game['id'] . ' fa-solid fa-circle-plus quantitePlus"></i>
                                </span>
                            </div>
                        </div>
                    </div>';


                $pageHTML['displayPriceBuy'] =
                    '<div class="priceBuy">

                        <div class="price">
                            <p>Price :</p>
                            <p>' . $game['total_price'] . '</p>
                        </div>

                        <a href="payments.php"><button>Go to payment ></button></a>
                    </div>';
            }
        } else {

            $pageHTML['isEmpty'] = true;

            $pageHTML['displayGame'] =
                '<i class="fa-solid fa-cart-shopping style="margin:15px""></i>
                <p class="cartEmpty">Your cart is empty</p>
                <p class="paraCartEmpty">You have added nothing into your cart <br/> Please browse our site to find incredible offer</p>';

            $pageHTML['displayPriceBuy'] =
                '<div class="priceBuy">

                    <div class="price">
                        <p>Price :</p>
                        <p>0.00€</p>
                    </div>

                    <button disabled="disabled">Go to payment ></button>
                </div>';
        }
    } else {

        $pageHTML['isEmpty'] = true;

        $pageHTML['displayGame'] =
             '<i class="fas fa-shopping-cart" style="margin:15px"></i> 
            <p class="cartEmpty">You are not logged</p>
            <p class="paraCartEmpty">You cannot add games to your cart if you are not logged <br/> Please log in or register to add games to the cart</p>';

        $pageHTML['displayPriceBuy'] =
            '<div class="priceBuy">

                <div class="price">
                    <p>Price :</p>
                    <p>0.00€</p>
                </div>

                <button disabled="disabled">Go to payment ></button>
            </div>';
    }

    $json = json_encode($pageHTML, JSON_PRETTY_PRINT);
    echo $json;

    die();
}

!isset($_GET['deleteItem']) ?: ($cart->DeleteItem($_GET['deleteItem'])) . (die());

!isset($_GET['changeQuantity']) ?: ($cart->ChangeQuantity($_GET['changeQuantity'], $_GET['itemId'], $_GET['plusMinus'])) . (die());

?>

<!doctype html>
<html lang="en">

<head>
    <?php require_once("_include/head.php") ?>
    <script defer src="cart.js"></script>
    <link rel="stylesheet" href="./assets/cart.css">
    <title>Cart</title>
</head>

<body>
    <header>
        <?php require_once "_include/header.php" ?>
    </header>

    <main class="container-cart">

        <h2>Your Cart</h2>
        <!-- <hr id="hre"> -->

        <div id="displayCartContent">

        </div>

        <hr id="hre">
        <h2>Summary</h2>


        <div id="displayCartPriceBuy"></div>
        <div id="displayInspired"></div>
    </main>


</body>

</html>