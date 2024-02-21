<?php 
// Base controller of the related controllers
abstract class BaseController 
{
    // if the method called doesn't exist then run this method
    public function __call($name, $arguments){
        //send the output that the uri doesn't exist
        $this->sendOutput('ERROR NOT FOUND', array('HTTP/1.1 404 Not Found'));
    }
    // method to send a response from the backend
    protected function sendOutput($data, $httpHeaders=array())
    {
        // remove a header previusly setted
        header_remove('Set-Cookie');
        // if a httpHeaders is an array and has elements then save them into header
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        // then show the data
        echo $data;
        exit;
    }
    // method to get uri segments
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );
        return $uri;
    }
    // method to get header parameters
    protected function getQueryStringParams()
    {
        return parse_str($_SERVER['QUERY_STRING'], $query);
    }

}
