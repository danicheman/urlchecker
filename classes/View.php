<?php

class View {
    
    static function load($view) {
        $viewFile = '../views/'.$view.'.php';
        
        if(!file_exists($viewFile)) {
            throw new RuntimeException("The file $viewFile does not exist.");
        } else {
            include $viewFile;
        }
    }
}