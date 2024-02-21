<?php
Class CategoryModel extends Connection{
    // method that returns all of the results 
    public function getAll() : array{
        // connection started
        $consulta = $this->Conection();
        // Query to get all of the categories
        $query = $consulta->query("select * from Category");
        // Results of the query
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        // Close Connection
        $this->CloseConnection($query, $consulta);
        // returning results
        return $resultados;
    }
}