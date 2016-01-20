<?php

/**
 * Statically load a view from the /views/ folder
 */
class View {
    
    const VIEWROOT = '../views/';
    
    static function load($view) {
        
        $viewFile = self::VIEWROOT.$view.'.php';
        
        if(!file_exists($viewFile)) {
            throw new RuntimeException("The file $viewFile does not exist.");
        } else {
            include $viewFile;
        }
    }
}