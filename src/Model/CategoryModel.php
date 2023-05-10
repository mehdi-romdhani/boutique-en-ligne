<?php

// namespace App\model;

// use App\model\Model;


// class CategoryModel extends Model
//  {

//     public function __construct()
//     {
//         parent::__construct();
//     }

//     /** 
    
//     @param string $cat

//     */
//     public function insertCat(string $cat) :void
//     {
//         $stmt = $this->pdo->prepare('INSERT INTO category(category) VALUES(:cat)');
//         $stmt->bindParam(':cat',$cat);
//         $stmt->execute();
//     }

//     /** 
    
//     @param string $cat

//     */

//     public function insertSubCat(string $subcat) :void
//     {
//         $stmt = $this->pdo->prepare('INSERT INTO subcategory(subcategory) VALUES(:subcat)');
//         $stmt->bindParam(':subcat',$subcat);
//         $stmt->execute();

//     }

//     public function showCat() :array 
//     {   
//         // var_dump($this->pdo);
//         $stmt = $this->pdo->prepare('SELECT * FROM category');
//         $stmt->execute();
//         $array = $stmt->fetchAll($this->pdo::FETCH_ASSOC);
//         return $array;  
//     }

//     public function showSubCat() :array

//     {
//         $stmt = $this->pdo->prepare('SELECT * FROM subcategory');
//         $stmt->execute();
//         $array = $stmt->fetchAll($this->pdo::FETCH_ASSOC);
//         return $array;
//     }

//     public function deleteCat(int $id)
//     {

//     }

// }
