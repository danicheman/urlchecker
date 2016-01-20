<?php

if(!class_exists('Tidy')) die("please install the Tidy extension for PHP");


//auto-load objects from the classes folder
spl_autoload_register(function ($class_name) {
    include "../classes/" . $class_name . '.php';
});

//if we got a url, we'll return a json response
if (!empty($_POST['url'])) {
    
    //if the url doesn't start with http then add it
    if(strpos($_POST['url'], 'http') === false) {
        $_POST['url'] = "http://".$_POST['url'];
    }
    
    //set defaults for json response array
    $response['tagCount'] = array();
    $response['html'] = "";
    $response['code'] = "N/A";
    $response['message'] = "";

    //use php's filter to check for a valid url
    if (!filter_var($_POST['url'], FILTER_VALIDATE_URL) === false) {

        $url = $_POST['url'];
        $curl = new MyCurl($url);
        $curl->createCurl();
        
        $response['code'] = $curl->getHttpStatus();
        $response['message'] = HttpCodes::getType($response['code']);
        
        
        $html = $curl->__toString();
        if (!is_string($html)) $response['message'] = "Page Could not be loaded, check the domain. Nothing was returned.";
        else {
            $tidy = new Tidy();
            
            //load page into tidy object, set options, and clean html
            $tidy->parseString($html, array('indent'=>2, 'output-xhtml' => true));
            $tidy->cleanRepair();
            
            //html is now nicely indented
            $html = (string)$tidy;
            
            //count the tags and get the result in a $tag => $count array
            $tagCount = countTags($html);
            
            $response['tagCount'] = $tagCount;
            $response['html'] = htmlentities($html);
        }
        
    } else {
        $response['message'] = $_POST['url'] . " is not a valid URL";
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);

} else {

    //load the base view, located at ../views/base.php
    View::load("base");
    
}


function countTags($html){
    
    $search = array('@<script[^>]*?>.*?</script>@si',  // match javascript
                   '@<style[^>]*?>.*?</style>@si',    // match style tags 
                   //'@<![\s\S]*?--[ \t\n\r]*>@'        // Strip multi-line comments including CDATA
    );
    
    $replace = array("<script></script>\n",
                     "<style></style>\n"
    );
    
    $html = preg_replace($search, $replace, $html);
    
    preg_match_all('/<([a-z1-9]+)/i',$html,$matches);
    
    return array_count_values($matches[1]);
}

