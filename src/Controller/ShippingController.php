<?php

namespace App\Controller;

use App\Model\ShippingModel;
use App\Model\UserModel;



class ShippingController{


    private $modelShipping;

    public function __construct() {

        $this->modelShipping = new ShippingModel();

    }

    public function insertInfoShipping(?string $adress, ?string $country,?string $postcode, ?string $city){

        $country = htmlspecialchars(trim($country));
        $adress = htmlspecialchars(trim($adress));
        $city = htmlspecialchars(trim($city));
        $postcode = htmlspecialchars(trim($postcode));

        $modelShipping = new ShippingModel();

            foreach(func_get_args() as $values)
            {
                 $values = htmlspecialchars(trim($values));

                if(!empty($values))
                {
                    continue;
                }else
                {
                    $mess['infoShippinFalse']="Please fill in the following fields";
                    $messJSON = json_encode($mess,JSON_PRETTY_PRINT);
                       
                    echo $messJSON;
                    return false;
                }
            }
            
            $this->modelShipping->insertInfoShippin($adress,$country,$postcode,$city);
            $mess['infoShippin']="Your information has been registered";
            $messJSON = json_encode($mess,JSON_PRETTY_PRINT);
               
            // return $messJSON;
            // return true;
            echo $messJSON;
            // die();

    }
}



?>