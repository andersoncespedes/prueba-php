<?php
Class ProductoModel extends Connection{

    public function getAll() : array{
        $consulta = $this->Conection();
        $query = $consulta->query("select * from Product");
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->CloseConnection($query, $consulta);
        return $resultados;
    }

    public function showOne(string $code) {
        $consulta = $this->Conection();
        $query = $consulta->query("select * from Product where code = '".$code."'");
        $resultado = $query->fetch(PDO::FETCH_ASSOC);
        $this->CloseConnection($query, $consulta);
        return $resultado != false ? $resultado : [];
    }

    public function create(stdClass $datos) : bool{
        try{
            $key = '';
            $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
            $max = strlen($pattern)-1;
            for($i=0;$i < 40;$i++) $key .= $pattern[mt_rand(0,$max)];
            $now = new DateTime();
            $consulta = $this->Conection();
            $prepare = $consulta
            ->prepare("INSERT INTO 
            Product(Code, Name,  Category, Price, createdAt, UpdatedAt) 
            VALUES (?, ?, ? , ?, ?, ?)");
            $prepare
            ->execute(
                array(
                    $key, 
                    $datos->Name, 
                    $datos->Category, 
                    $datos->Price, 
                    $now->format('Y-m-d H:i:s'), 
                    $now->format('Y-m-d H:i:s')
                )
            );
            $this->CloseConnection($prepare, $consulta);
            return true;
        }catch(Error $e){
            return false;
        }
            
            
    }
    public function update(string $code, stdClass $datos) : bool{
        try{
        $now = new DateTime();
        $consulta = $this->Conection();
        
        $prepare = $consulta
            ->prepare("UPDATE Product
            SET Name = ?,  Category = ?, Price = ?, updatedAt = ?
            WHERE Code = ? ");
        $prepare
        ->execute(
            array(
                $datos->Name, 
                $datos->Category, 
                $datos->Price, 
                $now->format('Y-m-d H:i:s'),
                $code
            )
        );
        $this->CloseConnection($prepare, $consulta);
        return true;
    }catch(Error $e){
        return false;
    }
    }
    public function delete(string $code) : bool{
        $consulta = $this->Conection();
        $consulta
            ->query("DELETE FROM Product WHERE code = '".$code."'");
        $this->CloseConnection($query, $consulta);
        if(!$consulta) return false;
        return true;
    }

}