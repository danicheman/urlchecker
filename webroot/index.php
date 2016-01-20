<?php

if(!class_exists('Tidy')) die("please install the Tidy extension for PHP");



spl_autoload_register(function ($class_name) {
    include "../classes/" . $class_name . '.php';
});

//return a json response
if (!empty($_POST['url'])) {
    if(strpos($_POST['url'], 'http') === false) {
        $_POST['url'] = "http://".$_POST['url'];
    }
    
    $response['tagCount'] = array();
    $response['html'] = "";
    $response['code'] = "N/A";
    $response['message'] = "";

        
    if (!filter_var($_POST['url'], FILTER_VALIDATE_URL) === false) {

        $url = $_POST['url'];
        $curl = new MyCurl($url);
        $curl->createCurl();
        
        $response['code'] = $curl->getHttpStatus();
        $response['message'] = HttpCodes::getType($response['code']);
        
        
        $html = (string)$curl;
        $tidy = new Tidy();
        
        //$html = preg_replace("/<!\[CDATA\[.+?\]\]>/sUu", "", $html);
        
        

        $tidy->parseString($html, array('indent'=>2, 'output-xhtml' => true));
        
        $tidy->cleanRepair();
        
        //html is now nicely indented
        $html = (string)$tidy;
        
        $tagCount = countTags($html);
        
        
        $response['tagCount'] = $tagCount;
        $response['html'] = htmlentities($html);
        
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
$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
               '@<style[^>]*?>.*?</style>@siU',    // Strip style tags 
               //'@<![\s\S]*?--[ \t\n\r]*>@'        // Strip multi-line comments including CDATA
);

$replace = array("<script></script>",
                 "<style></style>");

$html = preg_replace($search, $replace, $html);

preg_match_all('/<([a-z1-9]+)/i',$html,$matches);
    return array_count_values($matches[1]);
}

