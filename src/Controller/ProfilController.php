<?php

namespace App\Controller;

use App\Model\AdminModel;
use App\Model\ProfilModel;
use DateTime;

class ProfilController{

    public function showInfosProfil(){

        $modelDATA = new ProfilModel()  ;
        $getINFOS = $modelDATA->showInfoProfil();
        return $getINFOS;
    }


    public function updateInfoProfil(?string $login,?string $pass,?string $confpass,?string $email,?string $firstname,?string $lastname,?string $date,?string $phone){

        $login = htmlspecialchars(trim($login));
        $pass = htmlspecialchars(trim($pass));
        $confpass = htmlspecialchars(trim($confpass));
        $email = htmlspecialchars(trim($email));

        // $date = new DateTime($date);

        $model = new ProfilModel();
        $messages = [];


        
        if(!empty($login) && $pass == $confpass && !empty($email)){
            
            $passHash = password_hash($pass,PASSWORD_DEFAULT);
            $model->updateProfil($login,$passHash,$email);

            $_SESSION['user']['login'] = $login;
            $_SESSION['user']['email'] = $email;

            $messages['updataDATA'] = "Your profil is update";
        }
        
        if(!empty($firstname) && !empty($lastname) && !empty($date) && !empty($phone)){
            $model->insertProfil($firstname,$lastname,$date,$phone);
            $_SESSION['user']['firstname'] = $firstname;
            $_SESSION['user']['lastname'] = $lastname;
            $_SESSION['user']['phone_number'] = $phone;

            $messages['updateFULLDATA'] = "Your profil is update";

        }
         if(empty($login) && empty($pass) && empty($confpass) && empty($email) && empty($firstname) && empty($lastname) && empty($date) && empty($phone) ){
            $messages['noSub'] = "Please insert data in your field";
        }

        $messJSON = json_encode($messages,JSON_PRETTY_PRINT);
        echo $messJSON;



        
    }


}


?>