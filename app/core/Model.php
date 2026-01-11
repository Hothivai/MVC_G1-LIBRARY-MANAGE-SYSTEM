<?php

class Model
{
    protected $db;
    protected $table;
    protected $fillable = [];

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function findAll()
    {
        $query = $this->db->prepare('SELECT * FROM ' . $this->table);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public function findById($id)
    {
        $query = $this->db->prepare('SELECT * FROM ' . $this->table . ' WHERE id = ?');
        $query->execute([$id]);
        return $query->fetchObject(static::class);
    }

    public function save()
    {
        // Save logic
    }

    public function delete()
    {
        // Delete logic
    }
}
