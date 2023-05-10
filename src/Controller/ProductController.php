<?php

namespace App\Controller;

use App\Model\ProductModel;



class ProductController {

    private $model;

    public function __construct() {

        $this->model = new ProductModel();
        
    }

    public function GetAllOneTable($table) {

        $result = $this->model->GetAllOneTable($table);

        return $result;

    }

    public function getPlatformProduct($id_game):array {

        return $this->model->getPlatformProduct($id_game);

    }

    public function GetProductByFilter($platform, $category, $subcategory) {

        $products = $this->model->GetProductByFilter($platform, $category, $subcategory);
        
        return $products;

    }


    public function getPreorderGame():array
    {
        return $this->model->preorderGames();
    }

    public function getRandGames():array
    {
        foreach($this->model->randomGames() as $key => $games)
        {
            $game_price = substr_replace($games['price'], ".", -2, 0) . "€";
            $game[] = '<div class="rand-game">
                        <a href="product.php?id='. $games['id'] .'"><img src="'. $games['image'] .'" class="img-rand-games" alt="" /></a>
                        <div class="new-rand-games-title-price">
                            <a href="product.php?id=' . $games['id'] .'"class="rand-link"><p class="rand-text">' . $games['title'] . '</p></a>
                            <p class="rand-price">' . $game_price . '</p>
                        </div>
                    </div>';
        }
        return $game;
    }

    public function getBestSellerGames():array {
        foreach($this->model->bestsellersGames() as $games)
        {
            $game_price = substr_replace($games['price'], ".", -2, 0) . "€";
            $game[] = '<div class="new-released-game">
                        <a href="product.php?id='. $games['id_game'] .'"><img src="'. $games['image'] .'" class="img-released-games" alt="" /></a>
                        <div class="new-released-games-title-price">
                            <a href="product.php?id=' . $games['id_game'] .'"class="link-released-games"><p class="new-released-text">' . $games['title'] . '</p></a>
                            <p class="new-released-price">' . $game_price . '</p>
                        </div>
                    </div>';
        }
        return $game;
    }

    public function getLastCartPaid($id_user) {
        return $this->model->getLastCartPaid($id_user);

    }

    public function displayItemCart($id_cart) {
        foreach($this->model->displayItemCart($id_cart) as $cart)
        {
            $cart_price = substr_replace($cart['price'], ".", -2, 0) . "€";
            $carts[] = '<div class="order-cart">
                        <img src="'. $cart['image'] .'" class="img-order" alt="" />
                        <div class="flex-order">
                            <div class="flex-price">
                                <p class="text-left">' .$cart['title'] . '</p>
                                <p class="text-right">' .'Qt: ' . $cart['quantity']. '</p>
                            </div>
                            <div class="flex-platform">
                                <p class="text-left">' . $cart['platform'] . '</p>
                                <p class="text-right">' . $cart_price . '</p>
                            </div>
                        </div>
                    </div>';
        }

        return $carts;
    }
    public function getNewReleasedGames():array
    {


        foreach($this->model->newReleasedGames() as $key => $games)
        {
            $game_price = substr_replace($games['price'], ".", -2, 0) . "€";
            $game[] = '<div class="new-released-game">
                        <a href="product.php?id='. $games['id'] .'" class="link-games" ><img src="'. $games['image'] .'" class="img-released-games" alt=""/></a>
                        <div class="new-released-games-title-price">
                            <a href="product.php?id=' . $games['id'] . '" class="link-released-games" ><p class="new-released-text">' . $games['title'] . '</p></a>
                            <p class="new-released-price">' . $game_price . '</p>
                        </div>
                    </div>';
        }
        return $game;
    }

    public function GetDataOneProduct($id)
    {

        $data = $this->model->GetDataOneProduct($id);

        return $data;
    }

    public function GetAllByLetters($letters) {

        $liste = $this->model->GetAllByLetters($letters);

        return $liste;

    }

}

?>