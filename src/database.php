<?php

/** Connection to database
 *@return PDO 
 */

function getPdo(): PDO
{
    $dsn = 'mysql:dbname=boutique_en_ligne;host=127.0.0.1';
    $user = 'root';
    $password = '';

    try {
        $pdo = new PDO($dsn, $user, $password);
        // echo "connection réussis";
        return $pdo;
    } catch (PDOException $e) {
        echo "Erreur SQL :", $e->getMessage();
    }
}
