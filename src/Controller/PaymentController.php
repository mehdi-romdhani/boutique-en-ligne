<?php

namespace App\Controller;
use App\Model\PaymentModel;

class PaymentController
{
    private $model;

    public function __construct() {
        $this->model = new PaymentModel();
    }

    public function verifFormPayment(?int $idAdress, ?string $cardNumber, ?string $cardExpiration, ?string $cardAuth, ?string $cardName, ?int $id_cart, ?int $id_user) {

        $cardNumberRep = str_replace(" ", "", $cardNumber);

        $cardExpirationRep = str_replace("/", "", $cardExpiration);


        $date = date("Y-m-d H:i:s");
        $messages = [];

        if(is_numeric($idAdress) && ctype_digit($cardNumberRep) && strlen(($cardNumberRep)) == 16 && ctype_digit($cardExpirationRep) && grapheme_strlen($cardExpirationRep) == 4 && ctype_digit($cardAuth) && grapheme_strlen((string)$cardAuth) == 3 && isset($cardName) && isset($messages))
        {


            $games_cart = $this->model->getItemCart($id_cart);

            $this->model->insertSoldGames($games_cart);

            $this->model->cartBought($idAdress, $date, $id_cart);

            $this->model->setCart($id_user, $date);

            $id_actual_cart = $this->model->getCart($id_user);

            $_SESSION['user']['actualCart'] = $id_actual_cart['id'];

            $messages['okCart'] = "okCart";

        }
        else {
            if(empty($idAdress))
            {
                $messages['errorAdress'] = "Please select an adress or create a new one";
            }
            if(!ctype_digit($cardNumberRep) || strlen($cardNumberRep) != 16)
            {
                $messages['errorCardNumber'] = "Please verify you card number is correct";
            }

            if(!ctype_digit($cardExpirationRep) || strlen($cardExpirationRep) != 4)
            {
                $messages['errorCardExpiration'] = "Please verify your card expiration date is correct";
            }
            if(!ctype_digit($cardAuth) || strlen($cardAuth) != 3)
            {

                $messages['errorCardAuth'] = "Please verify that the 3 digits behind your card are correct";
            }
            if(empty($cardName))
            {
                $messages['errorCardName'] = "Please enter the name on your credit card";
            }

        }
            echo json_encode($messages, JSON_PRETTY_PRINT);

    }


    public function getCart($id_user)
    {
        return $this->model->getCart($id_user);
    }

    public function getAdress($id) {

        $this->model->getAdressByIdUser($id);
    }

    public function getSummaryGames($id_cart) {
        $this->model->getSummaryGame($id_cart);
    }
}