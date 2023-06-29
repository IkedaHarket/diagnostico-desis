<?php
require_once "App/config/connection.php";

class CommuneController
{
    public static function getCommunesByIdRegion($id){
        require_once __DIR__ . '/../Models/CommuneModel.php';
        $communeModel = new CommuneModel(Database::getInstance()->getConnection());
        return $communeModel->getCommunesByIdRegion($id);
    }

}