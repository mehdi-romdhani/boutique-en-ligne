<?php

namespace App\Classes;

use App\Controller\ProductController;
use App\Model\ProductModel;

class Pruduct 
{

    private ?int $id = 2;
    private ?string $title = 'azerty';
    private ?string $short_description = 'azer ojhb boln bhik';
    private ?string $description = 'azer ojhb boln bhik azer ojhb boln bhik vazer ojhb boln bhik';
    private ?int $price = 1200;
    private ?string $image = '_img/img.jpg';
    private ?string $release_date = '2020-10-12';
    private ?string $developper = 'poiuyt';
    private ?string $publisher = 'zerfds';
    private ?int $id_category = 2;
    private ?int $id_subcategory = 3;
    private ?array $compatibility = [1, 2, 3];
    private ?int $in_cart = 2;

    public function __construct() {

    }


    //*************** SETTERS ***************//
    
    public function setId(?int $id) : void
    {
        $this->id = $id;
    }

    public function setTitle(?string $title) : void
    {
        $this->title = $title;
    }

    public function setShortDescription(?string $short_description) : void
    {
        $this->short_description = $short_description;
    }

    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }

    public function setPrice(?int $price) : void
    {
        $this->price = $price;
    }

    public function setImage(?string $image) : void
    {
        $this->image = $image;
    }

    public function setReleaseDate(?string $release_date) : void
    {
        $this->release_date = $release_date;
    }

    public function setDevelopper(?string $developper) : void
    {
        $this->developper = $developper;
    }

    public function setPublisher(?string $publisher) : void
    {
        $this->publisher = $publisher;
    }

    public function setIdCategory(?int $id_category) : void
    {
        $this->id_category = $id_category;
    }

    public function setIdSubcategory(?int $id_subcategory) : void
    {
        $this->id_subcategory = $id_subcategory;
    }

    public function setCompatibility(?array $compatibility) : void
    {
        $this->compatibility = $compatibility;
    }

    public function setInCart(?int $in_cart) : void
    {
        $this->in_cart = $in_cart;
    }



    //*************** GETTERS ***************//

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getTitle() : ?string
    {
        return $this->title;
    }

    public function getShortDescription() : ?string
    {
        return $this->short_description;
    }

    public function getDescription() : ?string
    {
        return $this->description;
    }

    public function getPrice() : ?int
    {
        return $this->price;
    }
    
    public function getImage() : ?string
    {
        return $this->image;
    }

    public function getReleaseDate() : ?string
    {
        return $this->release_date;
    }

    public function getDevelopper() : ?string
    {
        return $this->developper;
    }

    public function getPublisher() : ?string
    {
        return $this->publisher;
    }

    public function getIdCategory() : ?int
    {
        return $this->id_category;
    }

    public function getIdSubcategory() : ?int
    {
        return $this->id_subcategory;
    }

    public function getCompatibility() : array
    {
        return $this->compatibility;
    }

    public function getInCart() : ?int
    {
        return $this->in_cart;
    }

    public function getGame() : array
    {
        $tabClass = ['id' => $this->getId(),
                     'title' => $this->getTitle(),
                     'shortDescription' => $this->getShortDescription(),
                     'description' => $this->getDescription(),
                     'price' => $this->getPrice(),
                     'image' => $this->getImage(),
                     'releaseDate' => $this->getReleaseDate(),
                     'developper' => $this->getDevelopper(),
                     'publisher' => $this->getPublisher(),
                     'idCategory' => $this->getIdCategory(),
                     'idSubcategory' => $this->getIdSubcategory(),
                     'compatibility' => $this->getCompatibility(),
                     'inCart' => $this->getInCart()
        ];
        return $tabClass;
    }

}

?>