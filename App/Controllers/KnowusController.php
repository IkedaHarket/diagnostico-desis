<?php
require_once "App/config/connection.php";

class KnowusController
{
    public static function getCheckboxsKnowus(){
        require_once __DIR__ . '/../Models/KnowusModel.php';
        $knowus = new KnowusModel(DB);
        return $knowus->getCheckbox();
    }

}