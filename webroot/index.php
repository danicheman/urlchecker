<?php

if(!class_exists('Tidy')) die("please install the Tidy extension for PHP");

spl_autoload_register(function ($class_name) {
    include "../classes/" . $class_name . '.php';
});

//return a json response
if (!empty($_POST['url'])) {
    
    if (!filter_var($_POST['url'], FILTER_VALIDATE_URL) === false) {

        
        
        $response['tagCount'] = array();
        $response['html'] = "";
        $response['code'] = "N/A";
        $response['message'] = "";
        
        
        $url = $_POST['url'];
        $curl = new MyCurl($url);
        $curl->createCurl();
        
        $response['code'] = $curl->getHttpStatus();
        $response['message'] = HttpCodes::getType($response['code']);
        
        if($response['code'] === 200) {
            
            $html = (string)$curl;
            $tidy = new Tidy();
            
            //todo: get character encoding and convert it to UTF-8 if it's something else
    
            $tidy->parseString($html, array('indent'=>2, 'output-xhtml' => true));
            $tidy->cleanRepair();
            $tagCount = countTags($html);
            
            $response['tagCount'] = $tagCount;
            $response['html'] = htmlentities((string)$tidy);
            
            
            
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    
    } else {
        echo($_POST['url'] . " is not a valid URL");
    }
    exit;
}


//return the page view
View::load("base");

function countTags($html) {
    preg_match_all('/<([^\/!][a-z1-9]*)/i',$html,$matches);
    return array_count_values($matches[1]);
}

