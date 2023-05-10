<?php

namespace App\Model;
use PDO;
class AdminModel{

    public ?PDO $conn;

    public function __construct()
    {

        // parent::__construct();
        try {
            $this->conn = new \PDO('mysql:host=localhost;dbname=boutique_en_ligne', "root", "");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
    }

    public function reqInsertGame ($title, $desc, $price, $image, $date, $developper, $publisher, $category, $sub_category)
    {
        $req = $this->conn->prepare("INSERT INTO product (title, description, price, image, release_date, developper, publisher, id_category, id_subcategory) VALUES (:title, :description, :price, :image, :release_date, :developper, :publisher, :id_category, :id_subcategory)");
        $req->execute(array(
            ":title" => $title,
            ":description" => $desc,
            ":price" => $price,
            ":image" => $image,
            ":release_date" => $date,
            ":developper" => $developper,
            ":publisher" => $publisher,
            ":id_category" => $category,
            ":id_subcategory" => $sub_category
        ));
    }


    public function getPlatform():array {
        $req = $this->conn->prepare("SELECT * FROM platform");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertPlatform($id_game, $id_platform):void
    {
        $req = $this->conn->prepare("INSERT INTO compatibility (id_game, id_platform) VALUES (:id_game, :id_platform)");
        $req->execute(array(
            ":id_game" => $id_game,
            ":id_platform" => $id_platform
        ));

    }

    public function searchGameById($id):array
    {
        $req = $this->conn->prepare("SELECT *,product.id AS product_id, 
                                    product.title,
                                    product.description,
                                    product.price,
                                    product.image,
                                    product.release_date,
                                    product.developper,
                                    product.publisher,
                                    product.id_category,
                                    product.id_subcategory,
                                    compatibility.id_game,
                                    compatibility.id_platform,
                                    platform.id AS id_plat,
                                    platform.platform FROM product INNER JOIN compatibility INNER JOIN platform WHERE product.id = :id");
        $req->execute(array(
           ":id" => $id
        ));

        return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function updateById($title, $desc, $price, $image, $date, $developper, $publisher, $category, $sub_category, $id)
    {
        $req = $this->conn->prepare("UPDATE product SET title=:title, description=:description, price=:price, image=:image, release_date=:release_date, developper=:developper, publisher=:publisher, id_category=:id_category, id_subcategory=:id_subcategory WHERE id=:id");
        $req->execute(array(
            ":title" => $title,
            ":description" => $desc,
            ":price" => $price,
            ":image" => $image,
            ":release_date" => $date,
            ":developper" => $developper,
            ":publisher" => $publisher,
            ":id_category" => $category,
            ":id_subcategory" => $sub_category,
            "id" => $id
        ));


    }

    public function checkIfTitleIsSet($title):int
    {
        $req = $this->conn->prepare('SELECT product.title FROM product WHERE title=:title');
        $req->execute(array(
            ":title" => $title
        ));
        return $req->rowCount();
    }

//    public function findCompatibilityById($id)
//    {
//        $req = $this->conn->prepare("SELECT id_game, id_platform FROM compatibility INNER JOIN platform WHERE id_game=:id_game");
//        $req->execute(array(
//            ":id_game" => $id
//        ));
//
//        return $req->fetchAll(PDO::FETCH_ASSOC);
//    }

    public function findCompatibility($id)
    {
        $req = $this->conn->prepare("SELECT id_game, id_platform FROM compatibility WHERE id_game=:id_game");
        $req->execute(array(
            ":id_game" => $id
        ));

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }


    public function fetchLastGame():array
    {
        $req = $this->conn->prepare("SELECT product.id FROM product ORDER BY id DESC LIMIT 1");
        $req->execute();
        $lastGame = $req->fetch(PDO::FETCH_ASSOC);

        return $lastGame;
    }

    public function deleteGame($id) {

        var_dump($id);
        $req = $this->conn->prepare("DELETE FROM product WHERE id = :id ");
        $req->execute(array(
            ":id" =>$id
        ));

        $req = $this->conn->prepare("DELETE FROM compatibility WHERE id_game = :id_game ");
        $req->execute(array(
            ":id_game" =>$id
        ));


    }

    public function deleteCompat($id)
    {
        $req = $this->conn->prepare("DELETE FROM compatibility WHERE id_game = :id_game ");
        $req->execute(array(
            ":id_game" =>$id
        ));
    }

    public function displayGames()
    {

        $req = $this->conn->prepare("SELECT * FROM product");
        $req->execute();
        $allGame = $req->fetchAll(PDO::FETCH_ASSOC);


        foreach ($allGame as $key => $game ){

            $platform = $this->conn->prepare("SELECT id_game, platform.platform FROM compatibility
                                            INNER JOIN platform ON platform.id = compatibility.id_platform
                                            WHERE :id_game = id_game");
            $platform->execute(array(
                ":id_game" => $game['id']
            ));
            $platforms  = $platform->fetchAll(PDO::FETCH_ASSOC);
            $game['platforms'] = $platforms;
            $allGame[$key] = $game;
        }

        echo json_encode($allGame, JSON_PRETTY_PRINT);
    }

    public function getCategory($table)
    {
        $req = $this->conn->prepare("SELECT * FROM $table");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function GetAllRoles() {

        $sql = "SELECT * FROM role";

        $req = $this->conn->prepare($sql);
        $req->execute();
        $tab = $req->fetchAll(PDO::FETCH_ASSOC);

        return $tab;
    }

    public function GetUserDataByRoleId($idRole) {

        if($idRole == 'all') {

            $sql = "SELECT *,user.id FROM user INNER JOIN role ON user.id_role = role.id";

            $req = $this->conn->prepare($sql);
            $req->execute();
            $tab = $req->fetchAll(PDO::FETCH_ASSOC);

        }else{

            $sql = "SELECT *,user.id FROM user INNER JOIN role ON user.id_role = role.id WHERE id_role = :idRole";
            
            $req = $this->conn->prepare($sql);
            $req->execute(array(':idRole' => $idRole));
            $tab = $req->fetchAll(PDO::FETCH_ASSOC);
        }

        return $tab;

    }

    public function GetAllRoleExeptActualById($idActualRole) {

        $sql = "SELECT * FROM role WHERE NOT id = :actualId";

        $req = $this->conn->prepare($sql);
        $req->execute(array(':actualId' => $idActualRole));
        $tab = $req->fetchAll(PDO::FETCH_ASSOC);

        return $tab;

    }

    public function UpdateRole($idRole, $idUser) {

        $sql = "UPDATE user SET id_role = :id_role WHERE id = :userId";

        $req = $this->conn->prepare($sql);
        $req->execute(array(':id_role' => $idRole,
                            ':userId' => $idUser
        ));
        
        return "Role changed successfully";

    }

    public function DeleteUser($idUser) {

        $sql = "DELETE FROM user WHERE id = :idUser";

        $req = $this->conn->prepare($sql);
        $req->execute(array(':idUser' => $idUser));

        return "User deleted successfully";

    }

    public function insertCat(string $cat) :void
    {
        $stmt = $this->conn->prepare('INSERT INTO category(category) VALUES(:cat)');
        $stmt->bindParam(':cat',$cat);
        $stmt->execute();
    }

    /** 
    
    @param string $cat

    */

    public function insertSubCat(string $subcat) :void
    {
        $stmt = $this->conn->prepare('INSERT INTO subcategory(subcategory) VALUES(:subcat)');
        $stmt->bindParam(':subcat',$subcat);
        $stmt->execute();

    }

    public function showCat() :array 
    {   
        // var_dump($this->conn);
        $stmt = $this->conn->prepare('SELECT * FROM category');
        $stmt->execute();
        $array = $stmt->fetchAll($this->conn::FETCH_ASSOC);
        return $array;  
    }

    public function showSubCat() :array

    {
        $stmt = $this->conn->prepare('SELECT * FROM subcategory');
        $stmt->execute();
        $array = $stmt->fetchAll($this->conn::FETCH_ASSOC);
        return $array;
    }

    public function insertPlateform(string $plateform): void
    {
        $stmt = $this->conn->prepare('INSERT INTO platform(platform) VALUES(:content)');
        $stmt->bindParam(':content',$plateform);
        $stmt->execute();

    }

    public function showPlateform(){
        $stmt = $this->conn->prepare('SELECT * FROM platform');
        $stmt->execute();
        $result = $stmt->fetchAll($this->conn::FETCH_ASSOC);
        return $result;
    }


    public function deletePlateform(int $id)
    {
    
    $stmt = $this->conn->prepare('DELETE FROM platform WHERE id=:id ');
    $stmt->bindParam(':id',$id);
    $stmt->execute();

    }

}