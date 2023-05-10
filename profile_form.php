<?php 
require_once('autoloader.php');
(session_start() == PHP_SESSION_NONE) ?: session_start();


use App\Controller\ProfilController;
$showInfoUser = new ProfilController();
$getData = $showInfoUser->showInfosProfil();

// var_dump($_GET);
// var_dump($_POST);
?>


    <h1 class="title-form">Profil</h1>
<form action="" method="POST" id="form_profil">


    <input class="input" type="text" name="login" id="login_profil" value="<?= $_SESSION['user']['login']?>">

    <input class="input" type="password" name="new_pass" placeholder="New-password" >

    <input class="input" type="password" name="conf_pass" placeholder="Confirmation password" >

    <input class="input" type="password" name="old_pass" placeholder="Old password">

    <input class="input" type="text " name="email" value="<?= $_SESSION['user']['email']?>" >

    <input class="input" type="text" name="firstname" placeholder="FirstName" >

    <input class="input" type="text" name="lastname" placeholder="LastName" >

    <input class="input" type="date" name="date">

    <input class="input" type="text" name="phone" placeholder="Phone Number" >

    <p id="mess_form"></p>
    <button class="button" type="subit" name="submit_form_profil">Submit</button>
</form>

