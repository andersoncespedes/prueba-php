<?php
Class CategoryModel extends Connection{
    public function getAll() : array{
        $consulta = $this->Conection();
        $query = $consulta->query("select * from Category");
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->CloseConnection($query, $consulta);
        return $resultados;
    }
}