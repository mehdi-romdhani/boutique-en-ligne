<?php

require_once ("autoloader.php");
if (session_status() == PHP_SESSION_NONE){ session_start();}

use App\Controller\PaymentController;
use App\Controller\ProductController;

$PaymentController = new PaymentController();

$ProductController = new ProductController();

$last_id_cart = $ProductController->getLastCartPaid($_SESSION['user']['id']);


?>


<!doctype html>
<html lang="en">
<head>
    <?php require_once('_include/head.php'); ?>
    <link rel="stylesheet" href="assets/order.css">
    <script src="payment.js" defer></script>
    <title>Order</title>
</head>
<body class="order-summary">
    <main>
        <section class="flex-all">
            <h1 class="text">Your order is complete</h1>
            <h2 class="text">Here is your recap</h2>
            <h3 class="text">N° of order <?php echo $last_id_cart['id'] ?></h3>
            <div class="flex-cart">
                <?php  foreach($ProductController->displayItemCart($last_id_cart['id']) as $cart)
                {
                    echo $cart;
                }; ?>
            </div>
            <h3 class="text">You will be redirected to the home page</h3>
            <h3 class="text">If you are not redirected click <a href="index.php">here</a></h3>
        </section>
    </main>
</body>
</html>
