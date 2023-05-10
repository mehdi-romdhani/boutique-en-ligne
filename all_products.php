<?php

    if(session_status() == PHP_SESSION_NONE){ session_start();}

    require_once ("autoloader.php");

    use App\Controller\ProductController;
    $product = new ProductController();

    function createOptionsSelect($table) {
    
        $product = new ProductController();

        $resultTab = $product->GetAllOneTable($table);

        foreach ($resultTab as $result) : ?>

            <option value="<?= $result['id'] ?>"><?= $result[$table] ?></option>
            
        <?php endforeach;

    }

    if(isset($_GET['games']) || isset($_GET['pagination'])) {

        $productsTable = $product->GetProductByFilter($_GET['platform'], $_GET['category'], $_GET['subcategory']);

        $pages = [];
        
        $numPage = 1;

        for ($i=0; $i < sizeof($productsTable); $i+=18) {

            for ($j=$i; $j < $i+18; $j++) {
                
                if(isset($productsTable[$j])) {
                    $productsTable[$j]['price'] = substr_replace($productsTable[$j]['price'], ".", -2, 0) . "€";
                    strlen($productsTable[$j]['title']) > 10 ? $productsTable[$j]['titleMobile'] = substr($productsTable[$j]['title'], 0, 10) . "..." : $productsTable[$j]['titleMobile'] = $productsTable[$j]['title'] ;
                    strlen($productsTable[$j]['title']) > 20 ? $productsTable[$j]['titleDesktop'] = substr($productsTable[$j]['title'], 0, 20) . "..." : $productsTable[$j]['titleDesktop'] = $productsTable[$j]['title'] ;

                    $pages[$numPage][$j] =
                    '<div class="oneGame">
                        <a href="product.php?id=' . $productsTable[$j]['id'] . '"><img src="' . $productsTable[$j]['image'] . '" alt="" /></a>

                        <div class="titrePrix">
                            <a href="product.php?id=' . $productsTable[$j]['id'] . '" class="titleMobile">' . $productsTable[$j]['titleMobile'] . '</a>
                            <a href="product.php?id=' . $productsTable[$j]['id'] . '" class="titleDesktop">' . $productsTable[$j]['titleDesktop'] . '</a>
                            <a href="product.php?id=' . $productsTable[$j]['id'] . '"><p>' . $productsTable[$j]['price'] . '</p></a>
                        </div>
                    </div>';
                }
            }

            $pages['numPage'][$numPage] = '<p class="changePage" id="page' . $numPage . '">' . $numPage  ;

            $numPage++;
        }

        $json = json_encode($pages, JSON_PRETTY_PRINT);
        echo $json;

        die();
    }

?>


<!doctype html>
<html lang="en">
<head>
   <?php require_once("_include/head.php") ?>
    <script defer src="all_products.js"></script>
    <script defer src="search.js"></script>
    <link rel="stylesheet" href="./assets/all_products.css">
    <link rel="stylesheet" href="./assets/style.css">

    <title>All products</title>
</head>
<body>
    <header>
        <?php require_once "_include/header.php" ?>
    </header>

    <main>

        <div class="filterContainer">
            <div class="filters">

                <select name="platform" id="selectPlatform">
                    <option value="all">Platform</option>
                    <?= createOptionsSelect('platform') ?>
                </select>

                <select name="category" id="selectCategory">
                    <option value="all">Category</option>
                    <?= createOptionsSelect('category') ?>
                </select>

                <select name="subcat" id="selectSubcat">
                    <option value="all">Sub category</option>
                    <?= createOptionsSelect('subcategory') ?>
                </select>

            </div>
        </div>

        <div class="articleContainer"><div id="displayArticles"></div></div>

        <div id="displayPagination"></div>

    </main>

    <footer>
        <?php require_once "_include/footer.php" ?>
    </footer>
</body>
</html>