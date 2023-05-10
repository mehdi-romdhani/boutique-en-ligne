<?php

    namespace App\model;
    use PDO;
    use PDOException;

class PaymentModel
{
    private ?PDO $connect;

    public function __construct()
    {
        try {
            $this->connect = new PDO('mysql:host=localhost;dbname=boutique_en_ligne', "root", "");
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
    }

    public function getAdressByIdUser($id_user) {
        $req = $this->connect->prepare("SELECT shipping_info.id,
                                        shipping_info.adress,
                                        shipping_info.country,
                                        shipping_info.postal_code,
                                        shipping_info.city,
                                        shipping_info.id_user,
                                        user.lastname,
                                        user.firstname FROM shipping_info
                                        INNER JOIN user ON user.id = shipping_info.id_user  WHERE shipping_info.id_user = :id_user");

        $req->execute([
            ":id_user" => $id_user
        ]);

         echo json_encode($req->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT);
         die();
    }

    public function getSummaryGame($id_cart) {
        $req = $this->connect->prepare("SELECT 
                                                cart.id,
                                                cart.id_user,
                                                item_cart.id_game,
                                                item_cart.id_cart,
                                                item_cart.platform,
                                                item_cart.quantity,
                                                item_cart.price,
                                                product.title,
                                                product.image FROM cart 
                                                    INNER JOIN item_cart 
                                                        ON cart.id = item_cart.id_cart 
                                                    INNER JOIN product  
                                                        ON item_cart.id_game = product.id 
                                                              WHERE item_cart.id_cart = :id_cart");
        $req->execute([
            ":id_cart" => $id_cart
        ]);

        echo json_encode($req->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT);
        die();
    }

    public function cartBought(?int $id_adress, ?string $date, ?int $id_cart) {
        $req = $this->connect->prepare('UPDATE cart SET is_paid=:is_paid, id_shipping=:id_shipping, date_paid=:date_paid WHERE id=:id_cart');
        $req->execute([
            ":is_paid" => 1,
            ":id_shipping" => $id_adress,
            ":date_paid" => $date,
            ":id_cart" => $id_cart
        ]);
    }

    public function setCart($id_user, $date) {
        $sqlCart = "INSERT INTO cart (id_user, date_creation, is_paid) VALUES (:idUser, :dateCrea, :isPaid)";
        $reqCart = $this->connect->prepare($sqlCart);
        $reqCart->execute([
            ':idUser' => $id_user,
            ':dateCrea' => $date,
            ':isPaid' => false
        ]);
    }

    public function getCart($id_user):array
    {
        $req = $this->connect->prepare("SELECT cart.id,
                                                cart.total_price FROM cart 
                                                        WHERE id_user=:id_user 
                                                          AND is_paid=:is_paid");
        $req->execute([
           ":id_user" => $id_user,
           ":is_paid" => false
        ]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function insertSoldGames($getitemCart) {

        foreach ($getitemCart as $item) {
            $sold = $this->connect->prepare("SELECT sold.id_game FROM sold WHERE id_game=:id_game");
            $sold->execute([
                ":id_game" => $item['id_game']
            ]);
            $game_sold = $sold->fetch(PDO::FETCH_ASSOC);
            $game_exist = $sold->rowCount();

            if($game_exist === 1) {
                $req = $this->connect->prepare("UPDATE sold SET sold=:sold WHERE id_game=:id_game");
                $req->execute([
                    ":sold" => (int)$item['quantity'] + (int)$game_sold,
                    ":id_game" => $item['id_game']
                ]);
            } else {
                $req = $this->connect->prepare("INSERT INTO sold  (id_game, sold) VALUES (:id_game, :sold)");
                $req->execute([
                    ":id_game" => $item['id_game'],
                    ":sold" => $item['quantity']
                ]);
            }
        }
    }

    public function getItemCart($id_actual_cart) {
        $req = $this->connect->prepare("SELECT item_cart.id_game,
                                        item_cart.quantity FROM item_cart WHERE id_cart=:id_cart");
        $req->execute([
            ":id_cart" => $id_actual_cart
        ]);

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

}
