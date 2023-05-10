<?php

namespace App\Controller;

use App\Model\AdminModel;
use App\Model\PlateformModel;


class PlateformController
{




    public function __construct()
    {
        //empty

    }

    public function addForm(string $content): void
    {
        $content = htmlspecialchars(trim($content));
        $messages = [];
        $model = new AdminModel();

        if (empty($content)) {
            $messages['check_empty'] = "This input is empty";
        } else {

            $model->insertPlateform($content);
            $messages['not_empty'] = "New Category Added ";
        }

        $json_mess = json_encode($messages, JSON_PRETTY_PRINT);

        echo $json_mess;
    }


    public function showPlateform()
    {
        $modelPlateform = new AdminModel();

        $tabPlat = $modelPlateform->showPlateform();
        return $tabPlat;
    }




    public function deletePlat(array $idArrayCheck)
    {
        $model = new AdminModel();

        foreach ($idArrayCheck as $key => $platforme) {
            $intPlatform = (int)$platforme;
            $model->deletePlateform($intPlatform);
        }
    }
}
