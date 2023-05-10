<?php
require_once "autoloader.php";

use App\Controller\UserController;

if(session_status() == PHP_SESSION_NONE){ session_start();}
    

    $user = new UserController();

?>

<?php if(isset($_GET['inscription'])): ?>
    
    <div id="divForm">

        <form action="" method="POST" id="signupForm" class="form-signup">
            <h2 class="title-form">Sign up</h2>


            <input class="input" type="text" name="login" placeholder="Login" required />
            <div id="errorLogin" class="error"></div>


            <input class="input" type="text" name="email" placeholder="Email" required />
            <div id="errorEmail" class="error"></div>


            <input class="input" type="password" name="password" placeholder="Password" required />
            <div></div>

            <input class="input" type="password" name="passwordConfirm" placeholder="Confirm password" required />
            <div id="errorPass" class="error"></div>

            <button class="button" type="submit">Submit</button>

        </form>

    </div>

<?php die (); endif ?>


<?php if(isset($_GET['connexion'])): ?>

    <div id="divForm">

        <form action="" method="POST" id="signinForm" class="form">

            <h2 class="title-form">Sign in</h2>


            <input class="input" type="text" name="login" id="login" placeholder="login" required />
            <div id="errorLogin" class="error"></div>


            <input class="input" type="password" name="password" id="password" placeholder="Enter your password" required />
            <div id="errorPass" class="error"></div>

            <button class="button" type="submit">Submit</button>

        </form>

    </div>

<?php die(); endif ?>



<?php

    !isset($_GET['signup']) ?: $user->Register($_POST['login'], $_POST['email'], $_POST['password'], $_POST['passwordConfirm']);

    !isset($_GET['signin']) ?: $user->Connect($_POST['login'], $_POST['password']);

?>