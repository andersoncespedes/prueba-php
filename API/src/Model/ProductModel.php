<?php
// model for the etity Product
Class ProductoModel extends Connection
{
    private function validation(stdClass $data) : Error | bool {
      if(preg_match('/\d/', $data->Name)){
        return throw new Error("it doesn't allow Numbers in Name");
      }else if(preg_match('/[a-zA-Z]/', $data->Price)){
        return throw new Error("it doesn't allow characters in Price");
      }else if($data->Price < 0){
        return throw new Error("it doesn't allow Number under 0 in Price");
      }else if (strlen($data->Name) < 3){
        return throw new Error("it doesn't allow less than 3 characters in Name");
      }
      else{
        return true;
      }
    }   
    // query to show all of the products
    public function getAll() : array{
        $consulta = $this->Conection();
        $query = $consulta->query("select * from Product");
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->CloseConnection($query, $consulta);
        return $resultados;
    }
    // query to show one of the products
    public function showOne(string $code) {
        $consulta = $this->Conection();
        $query = $consulta->query("select * from Product where code = '".$code."'");
        $resultado = $query->fetch(PDO::FETCH_ASSOC);
        $this->CloseConnection($query, $consulta);
        return $resultado != false ? $resultado : [];
    }
    // query to create a new product
    public function create(stdClass $datos) : bool | Error{
        $validaton = $this->validation($datos);
        if($validaton){
        }else{
            return $validaton;
        }
        try{
            // creation of a new code 
            $key = '';
            $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
            $max = strlen($pattern)-1;
            for($i=0;$i < 40;$i++) $key .= $pattern[mt_rand(0,$max)];
            //  intance of the class DateTime to get the current date
            $now = new DateTime();
            // connection started
            $consulta = $this->Conection();
            // query prepare to excecute
            $prepare = $consulta
            ->prepare("INSERT INTO 
            Product(Code, Name,  Category, Price, createdAt, UpdatedAt) 
            VALUES (?, ?, ? , ?, ?, ?)");

            // query excecuted

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
            // close connection
            $this->CloseConnection($prepare, $consulta);
            return true;
        }catch(Error $e){
            return false;
        }
            
            
    }
    // query to update a product 
    public function update(string $code, stdClass $datos) : bool | Error{
        // validate the data 
        $validaton = $this->validation($datos);
        if($validaton){
        }else{
            return $validaton;
        }
        try{
        //  intance of the class DateTime to get the current date

        $now = new DateTime();
        $consulta = $this->Conection();
        // connection started
        
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
        return $e;
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