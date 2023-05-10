<?php

namespace App\Model;

use PDO;
use PDOException;

class UserModel
{

    private PDO $conn;

    public function __construct()
    {
        $db_username = 'root';
        $db_password = '';

        try {

            $this->conn = new PDO('mysql:host=localhost;dbname=boutique_en_ligne;charset=utf8', $db_username, $db_password);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {

            echo "Error : " . $e->getMessage();
        }
    }

    public function RowCount($table, $attributeToCount, $input)
    {

        $sql = "SELECT * FROM $table WHERE $attributeToCount = :input";

        $req = $this->conn->prepare($sql);
        $req->execute(array(':input' => $input));
        $row = $req->rowCount();

        return $row;
    }

    public function InsertUserDb($login, $email, $hash)
    {

        $sql = "INSERT INTO user (`login`, `password`, `email`, `id_role`) VALUES (:login, :pass, :email, :id_role)";
        $req = $this->conn->prepare($sql);
        $req->execute(array(':login' => $login,
            ':pass' => $hash,
            ':email' => $email,
            ':id_role' => 1
        ));

        $sqlIdUser = "SELECT id FROM user WHERE login = :login";
        $reqIdUser = $this->conn->prepare($sqlIdUser);
        $reqIdUser->execute([':login' => $login]);
        $idUser = $reqIdUser->fetchAll(PDO::FETCH_ASSOC);

        $date = date('Y-m-d H:i:s');

        $sqlCart = "INSERT INTO cart (id_user, date_creation, is_paid) VALUES (:idUser, :dateCrea, :isPaid)";
        $reqCart = $this->conn->prepare($sqlCart);
        $reqCart->execute([':idUser' => $idUser[0]['id'],
                           ':dateCrea' => $date,
                           ':isPaid' => false
        ]);

        return 'okSignup';
    }

    public function GetUserData($login)
    {

        $sql = "SELECT * , user.id FROM user INNER JOIN role ON user.id_role = role.id WHERE login=:login";
        $req = $this->conn->prepare($sql);
        $req->execute([':login' => $login
        ]);
        $tab = $req->fetch(PDO::FETCH_ASSOC);

        $sqlCart = "SELECT id FROM cart WHERE id_user = :idUser AND is_paid=:is_paid";
        $reqCart = $this->conn->prepare($sqlCart);
        $reqCart->execute([
            ':idUser' => $tab['id'],
            ":is_paid" => false
        ]);
        $tempTab = $reqCart->fetch(PDO::FETCH_ASSOC);

        $tab['actualCart'] = $tempTab['id'];

        return $tab;
    }

    public function UpdateOneById($sessionId, $attributToChange, $newAttributValue, $table, $messageOk)
    {

        $sql = "UPDATE $table SET $attributToChange = :newAttributValue WHERE id = :sessionId";

        $req = $this->conn->prepare($sql);
        $req->execute(array(':newAttributValue' => $newAttributValue,
            ':sessionId' => $sessionId
        ));

        return $messageOk;
    }

    public function DeleteLine($table, $id)
    {

        $sql = "DELETE FROM $table WHERE id = :sessionId";

        $req = $this->conn->prepare($sql);
        $req->execute(array(':sessionId' => $id));

        return 'okDel';
    }
}


?>