<?php
Class ProductoModel extends Connection{
    public function getAll() : array{
        $consulta = $this->Conection();
        $query = $consulta->query("select * from Product");
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->CloseConnection($query, $consulta);
        return $resultados;
    }
    public function showOne(string $code){
        $consulta = $this->Conection();
        $query = $consulta->query("select * from Product where code = '".$code."'");
        $resultado = $query->fetch(PDO::FETCH_ASSOC);
        $this->CloseConnection($query, $consulta);
        return $resultado;
    }
    public function create() : bool{
        $consulta = $this->Connection();
        $prepare = $consulta
        ->prepare("INSERT INTO Product(code, id_category, Price, createdAt, UpdatedAt) VALUES (?, ?, ? , ?, ?)");

    }
}