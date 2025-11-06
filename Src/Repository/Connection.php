<?php
namespace Repository;

use PDO;
use PDOException;
use RuntimeException;

class Connection extends PDO
{
    private $host = "35.192.166.128";
    private $db_name = "pci";
    private $username = "pcidatabase";
    private $password = 'z"tF&uUrq?*v0t%A';

    public function __construct()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";

        try {
            parent::__construct($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException("Erro de conexão: " . $e->getMessage());
        }
    }
    public function close()
    {
        $this->pdo = null; // fecha a conexão
    }
    
}
