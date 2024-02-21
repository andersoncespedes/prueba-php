<?php
// Controller for entity product
final class ProductoController extends BaseController
{
    // Endpoint that  show all of the products registered in the db
    public function show() : void {
        // defining Errors
        $strErrorDesc = '';
        // getting method of the request
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        // getting the params of the header
        $arrQueryStringParams = $this->getQueryStringParams();
        // if the method of the request is GET starts the operation
        if (strtoupper($requestMethod) == 'GET') {
            try {
                // instance of the model of product where there are all of the queries
                $product = new ProductoModel();
                // use of the method getAll to get all of the products
                $arrProducts = $product->getAll();
                // encode the data recived from the moden into json statement
                $responseData = json_encode($arrProducts);
            } catch (Error $e) {
                // catching the posibles errors whe the query runs
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            // if the method was not GET the errors are defined
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // if the errors are not defined then show the responsedata ubtained by the model 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } 
        // if the errors are defined then show the errors and exit
        else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    // Endpoint that shows one of the products registered
    public function showOne() : void{
        // defining Errors
        $strErrorDesc = '';
        // getting method of the request
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        // if the method of the request is GET starts the operation
        if(strtoupper($requestMethod) == "GET"){ 
            try{
                // obtaining the code from the uri
                $code = $_GET["code"];
                // instance of the model of product where there are all of the queries
                $product = new ProductoModel();
                // if code is equall null then whrow an error
                if($code == null){
                    throw new Error("Doesn't exist this product");
                }
                // if is not null then call the method showOne to return the one with that code
                $productOne = $product->showOne($code);
                // encode the data recived from the moden into json statement
                $response = json_encode($productOne);
            }catch(Error $e){
                // catching the posibles errors whe the query runs
                $strErrorDesc = $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        // if the method was not GET the errors are defined
        else {
            
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // if the errors are not defined then show the responsedata ubtained by the model 
        if(!$strErrorDesc){
            $this->sendOutput(
                $response,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        }
        // if the errors are defined then show the errors and exit
        else{
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    // endpoint that create a new product
    public function create() : void{
        // defining Errors
        $strErrorDesc = '';
        // getting method of the request
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        // if the method of the request is POST starts the operation
        if(strtoupper($requestMethod) == "POST"){
            try{
                // getting the body content
                $body = file_get_contents('php://input');
                // decoding the body content
                $data = json_decode($body);
                // instance of the model of product where there are all of the queries
                $product = new ProductoModel();
                // if is the method create return true then create a new product else throw a unknow error
                if(!$product->create($data)){
                    throw new Error("unknow error");
                }
            }catch(Error $e){
                // catching the posibles errors whe the query runs
                $strErrorDesc = $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }else{
            // if the method was not POST the errors are defined
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // if the errors are not defined then show the responsedata ubtained by the model 
        if(!$strErrorDesc){
            $this->sendOutput(
                $body,
                array('Content-Type: application/json', 'HTTP/1.1 201 Created')
            );
        }else{
            // if the errors are defined then show the errors and exit
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    // endpoint that UPDATE a product
    public function update() : void{
        // defining Errors
        $strErrorDesc = '';
        // getting method of the request
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        // if the method of the request is PUT and code exists starts the operation
        if(strtoupper($requestMethod) == "PUT" && isset($_GET["code"])){
            try{
                // getting the body content
                $body = file_get_contents('php://input');
                // decoding the body content
                $data = json_decode($body);
                // instance of the model of product where there are all of the queries
                $product = new ProductoModel();
                // if is the method update return true then UPDATE a new product else throw a unknow error
                if(!$product->update($_GET["code"], $data)){
                    throw new Error("unknow error");
                }
            }catch(Error $e){
                // catching the posibles errors whe the query runs
                $strErrorDesc = $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }else{
            // if the method was not PUT the errors are defined
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // if the errors are not defined then show the responsedata obtained by the model 
        if(!$strErrorDesc){
            $this->sendOutput(
                $body,
                array('Content-Type: application/json', 'HTTP/1.1 201 Created')
            );
        }else{
            // if the errors are defined then show the errors and exit
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    // endpoint that DELETE a product
    public function delete() : void{
        // defining Errors
        $strErrorDesc = '';
        // getting method of the request
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        // if the method of the request is DELETE and code exists starts the operation
        if(strtoupper($requestMethod) == "DELETE" && isset($_GET["code"])){
            try{
                // instance of the model of product where there are all of the queries
                $product = new ProductoModel();
                // if is the method update return true then DELETE a product else throw a unknow error
                if(!$product->delete($_GET["code"])){
                    throw new Error("unknow error");
                }
            }catch(Error $e){
                // catching the posibles errors whe the query runs
                $strErrorDesc = $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }else{
            // if the method was not DELETE the errors are defined
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // if the errors are not defined then show the responsedata obtained by the model 
        if(!$strErrorDesc){
            $this->sendOutput(
                "",
                array('Content-Type: application/json', 'HTTP/1.1 204 NoContent')
            );
        }else{
            // if the errors are defined then show the errors and exit
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    
}


