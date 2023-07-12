<?php


class Database
{

    private $db_host = $_ENV['DB_HOST'];
    private $db_name = $_ENV['DB_NAME'];
    private $db_user = $_ENV['DB_USER'];
    private $db_pass = $_ENV['DB_PASS'];



    public function dbConnection()
    {

        try {

            $conn = new PDO(
                "mysql:host=" . $this->db_host .
                    ';db_name=' . $this->db_name,
                $this->db_user,
                $this->db_pass
            );


            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;
        } catch (PDOException $e) {
            echo  "Connection Error " . $e->getMessage();
            exit;
        }
    }
}
