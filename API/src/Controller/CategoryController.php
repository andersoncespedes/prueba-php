<?php
// Controller for entity category
final class CategoryController extends BaseController
{
    // Endpoint that  show all of the categories registered in the db
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
                // instance of the model of category where there are all of the queries
                $category = new CategoryModel();
                // use of the method getAll to get all of the categories
                $arrCategory = $category->getAll();
                // encode the data recived from the model into json statement
                $responseData = json_encode($arrCategory);
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
        if (!$strErrorDesc) {
            // if the errors are not defined then show the responsedata ubtained by the model 
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            // if the errors are defined then show the errors and exit
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}
