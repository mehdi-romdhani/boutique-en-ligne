<?php

namespace App\Controller;

use App\Model\CartModel;

class CartController
{

    private ?object $model;

    public function __construct() {

        $this->model = new CartModel();

    }

    public function AddProduct(?int $id, ?int $quantity, ?string $platform, ?int $cartId)
    {

        $quantity = intval($quantity);

        if($id !== "" && $quantity !== "" && $platform !== "" && $cartId !== "") {

            if($quantity >= 1 && $quantity <= 50) {

                $message = $this->model->AddProduct($id, $quantity, $platform, $cartId);

            }else{

                $message = "Please choose a quantity between 1 and 50";
            }
        
        }else{

            if($quantity === "") {

                $message = "Please choose a quantity";
            }

            if($platform === "") {

                $message = "Please choose a platform";
            }

            if($quantity !== "" && $platform !== "") {

                $message = "There was an issue with the server, please try later";
            }
        }

        echo $message;
    }

    public function GetCartContent(?int $cart)
    {

        $content = $this->model->GetCartContent($cart);

        return $content;

    }

    public function DeleteItem(?int $idItemLine)
    {

        $result = $this->model->DeleteItemOneLine($idItemLine);

        echo $result;

    }

    public function ChangeQuantity(?int $quantity, ?int $itemId, ?string $plusMinus)
    {

        $newPrice = $this->model->ChangeQuantity($quantity, $itemId, $plusMinus);

        echo substr_replace($newPrice, ".", -2, 0) . "€";

    }

}

?>