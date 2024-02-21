<?php
class Connection {
    protected string $host = HOST;
    protected string $password = PASSWORD;
    protected string $database = DATABASE;
    protected string $user = USER;
    protected string $stringConnection;
    protected PDO $connection;
    public function __construct(){
        $this->stringConnection = 'mysql:host='.$this->host .';dbname='. $this->database;
    }
    protected function Conection () : PDO{
        return new PDO($this->stringConnection, $this->user, $this->password);
    }
    protected function CloseConnection ($cons, $connection = null) : void{
        $connection = false;
        $cons = false;
    }
}
