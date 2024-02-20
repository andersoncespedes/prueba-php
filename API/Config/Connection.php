<?php

class Conecction {
    protected string $host = "localhost";
    protected string $password = "123456";
    protected string $database = "prueba-tecnica";
    protected string $user = "root";
    protected string $stringConnection;
    protected PDO $connection;
    protected function __construct(){
        $this->stringConnection = 'mysql:host='.$this->host .';dbname='. $this->database;
        $this->connection = new PDO($this->stringConnection, $usuario, $contraseña);
    }
    protected function Conection () : PDO{
        return $this->connection;
    }
    protected function CloseConnection ($cons) : void{
        $this->connection = false;
        $cons = false;
    }
}
