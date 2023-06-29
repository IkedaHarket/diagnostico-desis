<?php
require_once __DIR__ . '/../Controllers/ProvinceController.php';

class CommuneModel{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getCommunesByIdRegion($idRegion)
    {
        $provinces = ProvinceController::getProvincesByIdRegion($idRegion);

        try {
            $result = [];
            foreach ($provinces as $province) {
                $query = "SELECT * FROM tbl_comuna WHERE idProvincia = {$province['id']}";
                $statement = DB->prepare($query);
                $statement->execute();
                
                $result[] = $statement->fetchAll(PDO::FETCH_ASSOC);
            }
            return $result;
        } catch (PDOException $e) {
            echo 'Error al ejecutar la consulta: ' . $e->getMessage();
        }
    }


}

?>