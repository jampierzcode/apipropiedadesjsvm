<?php

namespace Usuario\Apipropiedades;

class Configuracion
{
    private $conn;
    private $table_name = "business";

    public $id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT * FROM business";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function readById($id)
    {
        $query = "SELECT * FROM business WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt;
    }
    public function readByUser($id)
    {
        $query = "SELECT * FROM business WHERE user_id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt;
    }

    public function create($data)
    {
        try {
            //code...
            $query = "INSERT INTO " . $this->table_name . "(user_id, nombre_razon, website, direccion,  phone_contact, email, logo) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);

            $stmt->execute([
                $data['user_id'],
                $data['nombre_razon'],
                $data['website'],
                $data['direccion'],
                $data['phone_contact'],
                $data['email'],
                $data['logo']
            ]);
            $propiedad_id = $this->conn->lastInsertId();
            $success = json_encode(['message' => 'add', "id" => $propiedad_id]);
            return $success;
        } catch (\Throwable $error) {
            //throw $th;
            $success = json_encode(['message' => 'error', "error" => $error->getMessage()]);
            return $success;
        }
    }

    public function updateByUser($data)
    {
        try {
            //code...
            $query = "UPDATE " . $this->table_name . " SET nombre_razon=?, website=?, direccion=?,  phone_contact=?, email=?, logo=? WHERE user_id=?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                $data['nombre_razon'],
                $data['website'],
                $data['direccion'],
                $data['phone_contact'],
                $data['email'],
                $data['logo'],
                $data['user_id']
            ]);
            $success = json_encode(['message' => 'update']);
            return $success;
        } catch (\Throwable $error) {
            //throw $th;
            //throw $th;
            $success = json_encode(['message' => 'error', "error" => $error->getMessage()]);
            return $success;
        }
    }
}
