<?php

class ProvinceModel{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getProvincesByIdRegion($id)
    {
        try {
            $query = "SELECT * FROM tbl_provincia WHERE idRegion = $id";
            $statement = $this->db->prepare($query);
            $statement->execute();
            
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo 'Error al ejecutar la consulta: ' . $e->getMessage();
        }
    }


}

?>