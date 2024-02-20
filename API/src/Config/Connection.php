<?php
class Connection {
    protected string $host = "localhost";
    protected string $password = "123456";
    protected string $database = "prueba-tecnica";
    protected string $user = "root";
    protected string $stringConnection;
    protected PDO $connection;
    public function __construct(){
        $this->stringConnection = 'mysql:host='.$this->host .';dbname='. $this->database;
        $this->connection = new PDO($this->stringConnection, $this->user, $this->password);
    }
    protected function Conection () : PDO{
        return $this->connection;
    }
    protected function CloseConnection ($cons, $connection = null) : void{
        $connection = false;
        $cons = false;
    }
}
