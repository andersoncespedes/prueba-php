<?php

class ProductoController extends BaseController
{
    public function show() : void {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $producto = new ProductoModel();
                $intLimit = 10;
                $arrUsers = $producto->getAll();
                $responseData = json_encode($arrUsers);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    // Endpoint que muestra un solo elemento por medio del code
    public function showOne() : void{
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if(strtoupper($requestMethod) == "GET"){ 
            try{
                $code = $_GET["code"];
                $product = new ProductoModel();
                if($code == null){
                    throw new Error("Doesn't exist this product");
                }
                $productOne = $product->showOne($code);
                $response = json_encode($productOne);
            }catch(Error $e){
                $strErrorDesc = $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
            
        }
        else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        if(!$strErrorDesc){
            $this->sendOutput(
                $response,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        }
        else{
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
        
    }
    public function create() : void{
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if(strtoupper($requestMethod) == "POST"){
            try{
                $body = file_get_contents('php://input');
                $data = json_decode($body);
                $product = new ProductoModel();
                $product->create($data);
        
            }catch(Error $e){
                $strErrorDesc = $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }else{
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        if(!$strErrorDesc){
            $this->sendOutput(
                $body,
                array('Content-Type: application/json', 'HTTP/1.1 201 Created')
            );
        }else{
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    public function update() : void{
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if(strtoupper($requestMethod) == "PUT" && isset($_GET["code"])){
            try{
                $body = file_get_contents('php://input');
                $data = json_decode($body);
                $product = new ProductoModel();
                $product->update($_GET["code"], $data);
        
            }catch(Error $e){
                $strErrorDesc = $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }else{
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        if(!$strErrorDesc){
            $this->sendOutput(
                $body,
                array('Content-Type: application/json', 'HTTP/1.1 201 Created')
            );
        }else{
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    
}


