<?php
require_once "App/config/connection.php";

class RegionController
{
    public static function getRegions(){
        require_once __DIR__ . '/../Models/RegionModel.php';
        $regionModel = new RegionModel(Database::getInstance()->getConnection());
        return $regionModel->getRegions();
    }

}