<?php

class CandidateModel{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getCandidates()
    {
        try {
            $query = "SELECT * FROM candidate";
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