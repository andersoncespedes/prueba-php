<?php
// model for the etity Product
Class ProductoModel extends Connection
{
    private function validation(stdClass $data) : Error | bool {
        // if there's a number in data->name then throw an error
      if(preg_match('/\d/', $data->Name)){
        return throw new Error("it doesn't allow Numbers in Name");
      }
        // if there's a character in data->price then throw an error
      else if(preg_match('/[a-zA-Z]/', $data->Price)){
        return throw new Error("it doesn't allow characters in Price");
      }
      // if $data->price < 0 then throw an error
      else if($data->Price < 0){
        return throw new Error("it doesn't allow Number under 0 in Price");
      }
      // if $data->name length is lower than 0 then throw an error
      else if (strlen($data->Name) < 3){
        return throw new Error("it doesn't allow less than 3 characters in Name");
      }
      // if none of them are true then return true
      else{
        return true;
      }
    }   
    // query to show all of the products
    public function getAll() : array{
        // connection started
        $consult = $this->Conection();
        // Query to get all of the products
        $query = $consult->query("select * from Product");
        // Results of the query
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->CloseConnection($query, $consult);
        // returning results
        return $results;
    }
    // query to show one of the products
    public function showOne(string $code) {
        // connection started
        $consult = $this->Conection();
        // Query to get one of the products with the code passed by parameter
        $query = $consult->query("select * from Product where code = '".$code."'");
        // Results of the query
        $result = $query->fetch(PDO::FETCH_ASSOC);
        // Close Connection
        $this->CloseConnection($query, $consulta);
        // returning results if result = false then return [] else returns the results
        return $result != false ? $result : [];
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
            // query prepare to excecute to create a new product
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
        // connection started
        $consulta = $this->Conection();
        // query prepare to UPDATE a product where Code = code(parameter)
        $prepare = $consulta
            ->prepare("UPDATE Product
            SET Name = ?,  Category = ?, Price = ?, updatedAt = ?
            WHERE Code = ? ");
        $prepare
        // query excecuted
        ->execute(
            array(
                $datos->Name, 
                $datos->Category, 
                $datos->Price, 
                $now->format('Y-m-d H:i:s'),
                $code
            )
        );
         // close connection
        $this->CloseConnection($prepare, $consulta);
        return true;
    }catch(Error $e){
        return $e;
    }
    }
    // query to delete a product
    public function delete(string $code) : bool{
        // connection started
        $consult = $this->Conection();
        $consult
            ->query("DELETE FROM Product WHERE code = '".$code."'");
        $this->CloseConnection($query, $consult);
        if(!$consult) return false;
        return true;
    }

}