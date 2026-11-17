<?php
// Base class for all models: gives each model the PDO connection.
abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }
}
