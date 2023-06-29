<?php
require_once "App/config/connection.php";

class CandidateController
{
    public static function getCandidates(){
        require_once __DIR__ . '/../Models/CandidateModel.php';
        $regionModel = new CandidateModel(Database::getInstance()->getConnection());
        return $regionModel->getCandidates();
    }

}