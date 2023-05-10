<?php

namespace App\Model;
use PDO;

class CartModel 
{

    private ?PDO $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO('mysql:host=localhost;dbname=boutique_en_ligne', "root", "");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function AddProduct( ?int $idProduct, ?int $quantity, ?string $platform, ?int $cartId) : string
    {

        $message = "";

        // CHECK IF THE PRODUCT IS ALREADY IN THE CART //
        $sqlCount = "SELECT * FROM item_cart WHERE id_cart = :cart AND id_game = :idProduct AND platform = :platform";
        
        $reqCount = $this->conn->prepare($sqlCount);
        $reqCount->execute([':cart' => $cartId,
                            ':idProduct' => $idProduct,
                            ':platform' => $platform
        ]);
        $row = $reqCount->rowCount();

        // GET ONE PRODUCT PRICE, MULTIPLY BY THE QUANTITY AND ADD IT TO THE ITEM_CART AND THE CART PRICE //


        // GET PRICE ONE PRODUCT //
        $sqlGetPrice = "SELECT price FROM product  WHERE id = :id";
        $reqGetPrice = $this->conn->prepare($sqlGetPrice);
        $reqGetPrice->execute([':id' => $idProduct]);

        $priceOneItem = $reqGetPrice->fetch(PDO::FETCH_ASSOC)['price'];

        $priceItems = $priceOneItem * $quantity;

        if($row === 0) {

            // IF THE PRODUCT ISN'T IN THE CART, ADD IT //
            $sql = "INSERT INTO item_cart (id_cart, id_game, quantity, price, platform) VALUES (:cart, :idProduct, :quantity, :price, :platform)";
            $req = $this->conn->prepare($sql);
            $req->execute([':cart' => $cartId,
                           ':idProduct' => $idProduct,
                           ':quantity' => $quantity,
                           ':price' => $priceItems,
                           ':platform' => $platform
            ]);


            // GET CART PRICE //
            $sqlGetPriceCart = "SELECT total_price FROM cart WHERE id = :cartId";
            $reqGetPriceCart = $this->conn->prepare($sqlGetPriceCart);
            $reqGetPriceCart->execute([':cartId' => $cartId]);

            $priceOneCart = $reqGetPriceCart->fetch(PDO::FETCH_ASSOC)['total_price'];

            $newCartPrice = $priceOneCart + $priceItems;


            // CHANGE CART PRICE //
            $sqlChangeCartPrice = "UPDATE cart SET total_price = :newPrice WHERE id = :cartId";
            $reqChangeCartPrice = $this->conn->prepare($sqlChangeCartPrice);
            $reqChangeCartPrice->execute([':newPrice' => $newCartPrice,
                                        ':cartId' => $cartId
            ]);

            $message = "The article was successfully added to the cart";

        }else{

            // IF THE PRODUCT IS ALREADY IN THE CART, GET DATA //
            $sqlId = "SELECT quantity, price, id FROM item_cart WHERE id_cart = :cart AND id_game = :idProduct AND platform = :platform";
            
            $reqId = $this->conn->prepare($sqlId);
            $reqId->execute([':cart' => $cartId,
                             ':idProduct' => $idProduct,
                             ':platform' => $platform
            ]);

            $tab = $reqId->fetch(PDO::FETCH_ASSOC);

            // AND INCREASE QUANTITY AND PRICE //
            $quantityNew = $tab['quantity'] + $quantity;
            $priceNew = $tab['price'] + $priceItems;

            $sqlUp = "UPDATE item_cart SET quantity = :quantity, price = :newPrice WHERE id = :id";

            $reqUp = $this->conn->prepare($sqlUp);
            $reqUp->execute([':quantity' => $quantityNew,
                             ':newPrice' => $priceNew,
                             ':id' => $tab['id']
            ]);

            $message = "The article was successfully added to the cart";
        }

        return $message;

    }

    public function GetCartContent(?int $cart) : ?array
    {

        $sql = "SELECT *, item_cart.id, product.price AS game_price, item_cart.price AS price FROM item_cart INNER JOIN cart ON item_cart.id_cart = cart.id INNER JOIN product ON item_cart.id_game = product.id WHERE id_cart = :idCart";

        $req = $this->conn->prepare($sql);
        $req->execute([':idCart' => $cart]);
        $cartContent = $req->fetchAll(PDO::FETCH_ASSOC);

        return $cartContent;

    }

    public function DeleteItemOneLine(?int $idItemLine) : ?string
    {

        $sqlGetPrice = "SELECT price FROM item_cart WHERE id = :id";
        $reqGetPrice = $this->conn->prepare($sqlGetPrice);
        $reqGetPrice->execute([':id' => $idItemLine]);

        $priceOneLine = $reqGetPrice->fetch(PDO::FETCH_ASSOC);


        $sqlGetPriceCart = "SELECT total_price , cart.id AS cartId FROM item_cart INNER JOIN cart ON item_cart.id_cart = cart.id WHERE item_cart.id = :id";
        $reqGetPriceCart = $this->conn->prepare($sqlGetPriceCart);
        $reqGetPriceCart->execute([':id' => $idItemLine]);

        $priceOneCart = $reqGetPriceCart->fetch(PDO::FETCH_ASSOC);
        

        $newCartPrice = $priceOneCart['total_price'] - $priceOneLine['price'];
        $cartId = $priceOneCart['cartId'];;

        $sqlChangeCartPrice = "UPDATE cart SET total_price = :newPrice WHERE id = :cartId";
        $reqChangeCartPrice = $this->conn->prepare($sqlChangeCartPrice);
        $reqChangeCartPrice->execute([':newPrice' => $newCartPrice,
                                      ':cartId' => $cartId
        ]);


        $sqlDelete = "DELETE FROM item_cart WHERE id = :id";

        $reqDelete = $this->conn->prepare($sqlDelete);
        $reqDelete->execute([':id' => $idItemLine]);

        $message = "The item was successfully deleted from your cart";

        return $message;

    }

    public function ChangeQuantity(?string $quantity, ?int $itemId, ?string $plusMinus) : ?int
    {

        // GET PRICE ITEM_CART //
        $sqlGetPriceLine = "SELECT price FROM item_cart WHERE id = :id";
        $reqGetPriceLine = $this->conn->prepare($sqlGetPriceLine);
        $reqGetPriceLine->execute([':id' => $itemId]);

        $priceOneLine = $reqGetPriceLine->fetch(PDO::FETCH_ASSOC);


        // GET PRICE ONE PRODUCT //
        $sqlGetPrice = "SELECT product.price FROM item_cart INNER JOIN product ON item_cart.id_game = product.id WHERE item_cart.id = :id";
        $reqGetPrice = $this->conn->prepare($sqlGetPrice);
        $reqGetPrice->execute([':id' => $itemId]);

        $priceOneItem = $reqGetPrice->fetch(PDO::FETCH_ASSOC);


        // GET PRICE WHOLE CART //
        $sqlGetPriceCart = "SELECT total_price , cart.id AS cartId FROM item_cart INNER JOIN cart ON item_cart.id_cart = cart.id WHERE item_cart.id = :id";
        $reqGetPriceCart = $this->conn->prepare($sqlGetPriceCart);
        $reqGetPriceCart->execute([':id' => $itemId]);

        $priceOneCart = $reqGetPriceCart->fetch(PDO::FETCH_ASSOC);


        $cartId = $priceOneCart['cartId'];

        if($plusMinus === 'minus') {

            $newCartPrice = $priceOneCart['total_price'] - $priceOneItem['price'];
            $changePrice = $priceOneLine['price'] - $priceOneItem['price'];

        }elseif($plusMinus === 'plus') {

            $newCartPrice = $priceOneCart['total_price'] + $priceOneItem['price'];
            $changePrice = $priceOneLine['price'] + $priceOneItem['price'];
        }


        $sqlChangeCartPrice = "UPDATE cart SET total_price = :newPrice WHERE id = :cartId";
        $reqChangeCartPrice = $this->conn->prepare($sqlChangeCartPrice);
        $reqChangeCartPrice->execute([':newPrice' => $newCartPrice,
                                      ':cartId' => $cartId
        ]);


        $sql = "UPDATE item_cart SET quantity = :quantity, price = :price WHERE id = :id";
        $req = $this->conn->prepare($sql);
        $req->execute([':quantity' => $quantity,
                       ':price' => $changePrice,
                       ':id' => $itemId
        ]);

        return $changePrice;

    }

}

?>