<?php

class Model {

    protected $id;
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    public function load($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);

        $data = $stmt->fetch();

        if (empty($data)) {
            echo 'cold not find dataset';exit;
        }
        $this->id = $id;
        return $data;
    }

    public function create($data) {
        $fields = array_keys($data);
        $values = array_values($data);
        $placeholders = str_repeat('?,', count($fields) - 1) . '?';

        $sql = "INSERT INTO {$this->table} (" . implode(',', $fields) . ") VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function update($id, $data) {
        $fields = array_keys($data);
        $values = array_values($data);
        $set = implode(' = ?, ', $fields) . ' = ?';

        $sql = "UPDATE {$this->table} SET $set WHERE id = ?";
        $values[] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getId()
    {
        return $this->id;
    }

}