<?php

    class Database
    {
        private $host;
        private $username;
        private $password;
        private $dbname;
        private $conn = null;

        private $options = [
            // Throw a PDOException if an error occurs
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Return rows as an array indexed by column name
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Prevent from SQL injection
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        public function __construct($username, $password, $dbname, $host = 'localhost')
        {
            $this->username = $username;
            $this->password = $password;
            $this->dbname = $dbname;
            $this->host = $host;
        }
        
        public function connect()
        {
            if ($this->conn === null) {
                try {
                    $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
                    $this->conn = new PDO($dsn, $this->username, $this->password, $this->options);
                } catch (PDOException $e) {
                    die("Database connection failed: " . $e->getMessage());
                }
            }
            return $this->conn;
        }

        public function disconnect()
        {
            $this->conn = null;
        }
}