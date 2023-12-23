<?php
require_once '../database/db.php';

class DAL {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => &$val) {
            $stmt->bindParam(":$key", $val);
        }

        $stmt->execute();
    }

    public function getById($table, $id) {
        $sql = "SELECT * FROM $table WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($table, $id, $data) {
        $setClause = "";
        foreach ($data as $key => $value) {
            $setClause .= "$key = :$key, ";
        }
        $setClause = rtrim($setClause, ", ");

        $sql = "UPDATE $table SET $setClause WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => &$val) {
            $stmt->bindParam(":$key", $val);
        }

        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    public function delete($table, $id) {
        $sql = "DELETE FROM $table WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    public function selectAll($table) {
        $sql = "SELECT * FROM $table";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>