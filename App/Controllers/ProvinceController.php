<?php
require_once "App/config/connection.php";

class ProvinceController
{
    public static function getProvincesByIdRegion($id){
        require_once __DIR__ . '/../Models/ProvinceModel.php';
        $provinceModel = new ProvinceModel(Database::getInstance()->getConnection());
        return $provinceModel->getProvincesByIdRegion($id);
    }

}