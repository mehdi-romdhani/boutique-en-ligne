<?php

namespace App\Controller;

use App\Controller\PlateformModel;
use App\Model\AdminModel;
use App\model\CategoryModel;

class CategoryController
{


    public function __construct()
    {
        
    }
    /**
     @param $content string
     */
    public function addCat(string $content): void
    {
        $content = htmlspecialchars((trim($content)));
        $messages = []; //for stock mess in JSON
        $insertModelCat = new AdminModel();

        if (empty($content)) {

            $messages['notEnterCat'] = "Please enter a category";
        } else {
            $insertModelCat->insertCat($content);
            $messages['catEnter'] = "New category added";
        }

        $JSON_mess = json_encode($messages, JSON_PRETTY_PRINT);
        echo $JSON_mess;
    }

    public function addSubCat(string $content): void
    {
        $content = htmlspecialchars((trim($content)));
        $messages = []; //for stock mess in JSON
        $insertModelCat = new AdminModel();

        if (empty($content)) {

            $messages['subCatEmpty'] = "Please enter a Subcategory";
        } else {
            $insertModelCat->insertSubCat($content);
            $messages['SubCatEnter'] = "New Subcategory added";
        }

        $JSON_mess = json_encode($messages, JSON_PRETTY_PRINT);
        echo $JSON_mess;
    }
}
