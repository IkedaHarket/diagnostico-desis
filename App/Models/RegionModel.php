<?php

class RegionModel{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getRegions()
    {
        try {
            $query = "SELECT * FROM tbl_region";
            $statement = DB->prepare($query);
            $statement->execute();
            
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo 'Error al ejecutar la consulta: ' . $e->getMessage();
        }
    }


}

?>