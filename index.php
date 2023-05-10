<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("autoloader.php");

    use App\Controller\ProductController;


$ProductController = new ProductController();

if (isset($_GET['getArray'])) {
    $ProductController->getPreorderGame();
}
?>
<!doctype html>
<html lang="en">

<head>
    <?php require_once('_include/head.php') ?>
    <link rel="stylesheet" href="assets/index.css">
    <link rel="stylesheet" href="assets/style.css">
    <script defer src="search.js"></script>
    <script src="https://kit.fontawesome.com/index.js" crossorigin="anonymous"></script>
    <script src="./scripts/index.js"></script>
    <title>Home</title>
</head>

<body>
<div class="accueil">

  <!-- Contenu de l'écran d'accueil ici -->
  <img src="./_img/new-logo-gmm.png" class="logo" alt="logo">
</div>
    <header class="header">
        <?php require_once('_include/header.php') ?>
    </header>
    <main>
        <section class="carousel">
            <button id="prev">
                &#9666
            </button>
            <button id="next">
                &#9656;
            </button>
            <a href="" id="carousel-link">
                <img src="" alt="" id="carousel-img">
            </a>
        </section>
        <section class="flex-released-games">
            <article class="display-title">
                <h2 class="title">New Released Games</h2>
                <a class="link" href="all_products.php">
                    <h4>See more</h4>
                </a>
            </article>
            <article class="display-new-released-games">
                <?php
                foreach ($ProductController->getNewReleasedGames() as $key => $games) {
                    echo $games;
                };
                ?>
            </article>
        </section>
        <section>
            <article class="display-title">
                <h2 class="title">Try Something New</h2>
                <a class="link" href="all_products.php">
                    <h4>See more</h4>
                </a>
            </article>
            <article id="display-rand-games">
                <?php
                    foreach($ProductController->getRandGames() as $key => $games)
                    {
                        echo $games;
                    }
                ?>
            </article>
        </section>
        <section class="flex-released-games">
            <article class="display-title">
                <h2 class="title">Best Sellers</h2>
                <a class="link" href="product.php"><h4>See more</h4></a>
            </article>
            <article class="display-new-released-games">
                <?php
                    foreach($ProductController->getBestSellerGames() as $games)
                    {
                        echo $games;
                    }
                ?>
            </article>
        </section>
    </main>
    <footer>
        <?php require_once('_include/footer.php') ?>
    </footer>
</body>

</html>