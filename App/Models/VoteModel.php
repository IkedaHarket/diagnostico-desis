<?php

class VoteModel{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function saveVote($data)
    {
        $stmt = $this->db->prepare("INSERT INTO votes (name, alias,rut,email,id_region,id_commune,id_candidate) VALUES ( :name, :alias, :rut, :email, :id_region, :id_commune, :id_candidate)");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':alias', $data['alias']);
        $stmt->bindParam(':rut', $data['rut']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id_region', $data['tbl_region']);
        $stmt->bindParam(':id_commune', $data['tbl_commune']);
        $stmt->bindParam(':id_candidate', $data['id_candidate']);

        try {
            $stmt->execute();
            $idVote = $this->db->lastInsertId();
            $array = array_map('intval', explode(',', $data['knowus']));
            foreach ($array as $value) {
                $stmt = $this->db->prepare("INSERT INTO votes_knowus (id_votes, id_knowus) VALUES (:id_votes, :id_knowus)");
                $stmt->bindParam(':id_votes', $idVote );
                $stmt->bindParam(':id_knowus', $value);
                $stmt->execute();
            }
            http_response_code(201);
            return 'El voto se registro correctamente';

        } catch (PDOException $e) {

            $message = "Error al guardar el voto";

            if(strpos($e->getMessage(), 'rut')){
                http_response_code(401);
                $message = "Este rut ya ha sido utilizado";
            }
            return $message;
        }
    }



    public function validateData()
    {
        $name = $_POST["name"];
        $alias = $_POST["alias"];
        $rut = $_POST["rut"];
        $email = $_POST["email"];
        $region = $_POST["region"];
        $commune = $_POST["commune"];
        $candidate = $_POST["candidate"];
        $knowus = $_POST["knowus"];

        $errors = [];

        if(empty($name)) $errors[] = "El nombre es obligatorio";
        if(empty($alias)) $errors[] = "El alias es obligatorio";
        if(empty($rut)) $errors[] = "El rut es obligatorio";
        // if($region == "#") $errors[] = "La region es obligatorio";
        // if($commune == "#") $errors[] = "La comuna es obligatorio";
        // if($candidate == "#") $errors[] = "El candidato es obligatorio";

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El correo electrónico no es válido.";
        }

        // Retornar los errores encontrados
        return $errors;
    }

}

?>