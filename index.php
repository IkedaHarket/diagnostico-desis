<?php 
    require_once "App/config/connection.php";
    Database::getInstance();
    include './app/routes/routes.php';
?>