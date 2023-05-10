<?php

namespace App\Controller;

// var_dump("App\Model\AdminModel");

use App\Model\AdminModel;

class AdminControllerGame {
    

    private $model;

    public function __construct()
    {
        $this->model = new AdminModel();
    }


    public function mempty($title, $desc, $price, $image, $date, $developper, $publisher , $category, $sub_category)
    {
        foreach(func_get_args() as $values)
        {

            if(!empty($values))
            {
                continue;
            }else
            {
                return false;
            }
        }
        return true;
    }

    public function insertGame($title, $desc, $price, $image, $date, $developper, $publisher, $checkboxArray, $category, $sub_category):void
    {
        $messages = [];

        $title = htmlspecialchars(trim($title));
        $desc = htmlspecialchars(trim($desc));
        $price = htmlspecialchars(trim($price));
        $image = htmlspecialchars(trim($image));
        $date = htmlspecialchars(trim($date));
        $developper = htmlspecialchars(trim($developper));
        $publisher = htmlspecialchars(trim($publisher));
        $category = htmlspecialchars(trim($category));
        $sub_category = htmlspecialchars(trim($sub_category));

        $priceInt = (int)$price;
        $categoryInt= (int)$category;
        $sub_categoryInt= (int)$sub_category;




        $checkTitle = $this->model->checkIfTitleIsSet($title);




        if(preg_match("#^[0-9]*$#" , $price) && grapheme_strlen($desc) > 100 && $this->mempty($title, $desc, $price, $image, $date, $publisher, $developper, $category, $sub_category && $checkTitle === 0 && $checkboxArray !== null))
        {
            $this->model->reqInsertGame($title, $desc, $priceInt, $image, $date, $developper, $publisher, $categoryInt, $sub_categoryInt);

            $this->setPlatform($checkboxArray);

            $messages['okAddGame'] = "You're game has been added to the product list";
        }
        else{
            if(!preg_match("#^[0-9]*$#", $price))
            {
                $messages['priceCheck'] = "The price must be only number";
            }
            if(grapheme_strlen($desc < 100))
            {
                $messages['lengthDesc'] = "The length of the description must be above 100 characters";
            }
            if(!$this->mempty($title, $desc, $price, $image, $date, $publisher, $developper, $category, $sub_category))
            {
                $messages['emptyValues'] = "Fill all the field please";
            }
            if($checkTitle != 0)
            {
                $messages['titleTaken'] = "The game you are trying to insert is already in the database";
            }
            if($checkboxArray == null)
            {
                $messages['checkboxError'] = "Please check at least one platform";
            }


        }
        $json = json_encode($messages, JSON_PRETTY_PRINT);
        echo $json;
    }

    public function updateGame($title, $desc, $price, $image, $date, $developper, $publisher, $checkboxArray, $category, $sub_category,$id):void
    {

        $title = htmlspecialchars(trim($title));
        $desc = htmlspecialchars(trim($desc));
        $price = htmlspecialchars(trim($price));
        $image = htmlspecialchars(trim($image));
        $date = htmlspecialchars(trim($date));
        $developper = htmlspecialchars(trim($developper));
        $publisher = htmlspecialchars(trim($publisher));
        $category = htmlspecialchars(trim($category));
        $sub_category = htmlspecialchars(trim($sub_category));
        $id = htmlspecialchars(trim($sub_category));

        $messages = [];

        $priceInt = (int)$price;
        $categoryInt= (int)$category;
        $sub_categoryInt= (int)$sub_category;




        if(preg_match("#^[0-9]*$#" , $price) && grapheme_strlen($desc) > 100 && $this->mempty($title, $desc, $price, $image, $date, $publisher, $developper, $category, $sub_category))
        {
            $this->model->updateById($title, $desc, $priceInt, $image, $date, $developper, $publisher, $categoryInt, $sub_categoryInt,$id);

            $this->model->deleteCompat($id);


            $this->updatePlatform($checkboxArray, $id);

            $messages['okAddGame'] = "You're game has been updated";
        }
        else{
            if(!preg_match("#^[0-9]*$#", $price))
            {
                $messages['priceCheck'] = "The price must be only number";
            }
            if(grapheme_strlen($desc < 100))
            {
                $messages['lengthDesc'] = "The length of the description must be above 100 characters";
            }
            if(!$this->mempty($title, $desc, $price, $image, $date, $publisher, $developper, $category, $sub_category))
            {
                $messages['emptyValues'] = "Fill all the field please";
            }

        }
        $json = json_encode($messages, JSON_PRETTY_PRINT);
        echo $json;
    }

    public function searchGameById($id) {
        return $this->model->searchGameById($id);
    }
    public function findCompatibility($id) {
        return $this->model->findCompatibility($id);
    }

    public function setPlatform(array $arrayCheckbox):void {


        $id_game = $this->model->fetchLastGame();


        foreach ($arrayCheckbox as $key => $platform){
            $intPlatform = (int)$platform;

            $this->model->insertPlatform($id_game['id'], $intPlatform);
        }
    }

    public function updatePlatform(array $arrayCheckbox, $id):void {

        foreach($arrayCheckbox as $key => $platform)
        {
            $intPLatform = (int)$platform;

            $this->model->insertPlatform($id, $intPLatform);
        }
    }

    public function fetchLastGame()
    {
        $this->model->fetchLastGame();
    }

    public function getPlatform():array
    {
        return $this->model->getPlatform();
    }

    public function displayGames()
    {
        $this->model->displayGames();
    }

    public function getCategory()
    {
        $AdminModel = new AdminModel();
        return $this->model->getCategory("category");
    }

    public function getSubCategory()
    {
        return $this->model->getCategory("subcategory");
    }

    public function deleteGame($id)
    {
        $intId = (int)$id;

        if(gettype($intId) == 'integer')
        {
            $this->model->deleteGame($intId);
        }

    }

}