<?php

require_once('autoloader.php');
(session_start() == PHP_SESSION_NONE) ?: session_start();
// var_dump($_SESSION);

use App\Controller\ShippingController;

$shippingInfo = new ShippingController;

if(isset($_GET['ship'])){

    $shippingInfo->insertInfoShipping($_POST['adress_shipping'],$_POST['country_ship'],$_POST['post_code_ship'],$_POST['city_ship']);
    die();
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once("_include/head.php") ?>
    <script defer src="./scripts/shipping.js"></script>
    <link rel="stylesheet" href="./assets/Shipping_style.css">
    <title>GameVault - Profile</title>
</head>

<?php require_once('_include/header.php') ?>

<div class="container-title">
    <h1>Shipping</h1>
    <hr id="shipHR">
</div>


<div class="container-form-shipping">
    <form action="" method="POST" id="form_shipping" >
        <label for="firstname"></label>
        <input type="text" name="firstname_ship" placeholder="<?= $_SESSION['user']['firstname'] ?>">
        <label for="lastname"></label>
        <input type="text" name="lastname_ship" placeholder="<?= $_SESSION['user']['lastname'] ?>">
        <label for="phone_number"></label>
        <input type="text" name="phone_num_ship" placeholder="<?= $_SESSION['user']['phone_number']?>">
        <label for="country"></label>
        <input type="text" name="country_ship" placeholder="Country">
        <label for="adress"></label>
        <input type="text" name="adress_shipping" placeholder="adress">
        <label for="City"></label>
        <input type="text" name="city_ship" placeholder="City">
        <label for="post_code"></label>
        <input type="text" name="post_code_ship" placeholder="Post Code">
        <p id="mess_form_ship"></p>
        <p id="mess_form"></p>
        <button type="submit" name="submit_form_profil">Submit</button>
    </form>
    <a href="./payments.php" id="payeship"> <i class="fa-solid fa-arrow-left"></i> Go back to payement</a>
</div>


