<?php
namespace App\Model;

use DateTime;
use PDO;
use PDOException;

class ProfilModel{

    public ?PDO $connect;


    public function __construct()
    {
        try {
            $this->connect = new \PDO('mysql:host=localhost;dbname=boutique_en_ligne', "root", "");
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
    }


    public function showInfoProfil() :array

    {
        $id = $_SESSION['user']['id'];
        $stmt = $this->connect->prepare('SELECT * FROM user WHERE id = :id');
        $stmt->bindParam('id',$id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateProfil(?string $login,?string $password,?string $email)
    {
        $id = $_SESSION['user']['id'];
        $stmt = $this->connect->prepare('UPDATE user SET login = :login, password = :password, email = :email WHERE id = :id' );
        $stmt->bindParam(':login',$login);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        
    }

    public function insertProfil(?string $firstname,?string $lastname,?string $date,?string $phone){

        $stmt = $this->connect->prepare("INSERT INTO user(firstname,lastname,birth_date,phone_number) VALUES(:firstname,:lastname,:date,:phone)");

           
        $id = $_SESSION['user']['id'];
        $stmt = $this->connect->prepare("UPDATE user SET firstname = :firstname,lastname = :lastname ,birth_date = :date, phone_number = :phone WHERE id = :id");

        $stmt->bindParam(':firstname',$firstname);
        $stmt->bindParam(':lastname',$lastname);
        $stmt->bindParam(':date',$date);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':id',$id);
        $result = $stmt->execute();
        var_dump($result);
        
    }
}
