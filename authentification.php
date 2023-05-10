<?php
if (session_status() == PHP_SESSION_NONE){ session_start();}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once '_include/head.php' ?>
    <link rel="stylesheet" href="assets/connect.css">
    <script src="authentification.js" defer></script>
    <title>Authenticate</title>
</head>

<body>

    <header id="header"><a href="index.php"><img class="logo" src="_img/newnewlogo.png" alt=""></a></header>

    <main id="main">

        <div id="divForm">

            <form action="" method="POST" id="signinForm" class="form">

                <h2 class="title-form">Sign in</h2>

                <input class="input" type="text" name="login" id="login" placeholder="login" required />
                <div id="errorLogin" class="error"></div>

                <input class="input" type="password" name="password" id="password" placeholder="Password" required />
                <div id="errorPass" class="error"></div>

                <button class="button" type="submit">Submit</button>

            </form>
        </div>

            <p id="switchInscription">Not registered yet?</p>
            <p id="switchConnexion" style="display: none;"><< Back</p>

    </main>

</body>

</html>