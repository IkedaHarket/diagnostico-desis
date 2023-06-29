<?php 

    $db_host = 'localhost';
    $db_name = 'desis_vote';
    $db_user = 'root';
    $db_password = '';
    
    try {
        $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec("SET NAMES utf8");
    } catch (PDOException $e) {
        echo 'Error de conexión: ' . $e->getMessage();
        die(); 
    }
    define('DB',$db);
