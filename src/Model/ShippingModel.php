<?php

namespace App\Model;

use PDO;
use PDOException;


class ShippingModel{


    private ?PDO $connection;

    public function __construct(){
        try {
            $this->connection = new PDO('mysql:host=localhost;dbname=boutique_en_ligne', "root", "");
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
    }

    public function showInfoShippingProfil(){

        $id = $_SESSION['user']['id'];
        $stmt = $this->connection->prepare('SELECT * FROM user WHERE id = :id');
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function insertInfoShippin($adress,$country,$postal_code,$city){

        $id = $_SESSION['user']['id'];
        $stmt = $this->connection->prepare('INSERT INTO shipping_info(adress,country,postal_code,city,id_user) VALUES (:adress,:country,:postal_code,:city,:id_user)');
        $stmt->bindParam(':adress',$adress);
        $stmt->bindParam(':country',$country);
        $stmt->bindParam(':postal_code',$postal_code);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':id_user',$id);
        $stmt->execute();
    }
}
