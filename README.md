# urlchecker
Enter a url address and urlchecker will display it's source. You can also highlight specific tags.
Check it out here:
http://urlchecker.askmephp.com/

# Hierarchy Overview

## /webroot/
All files that are accessible publicly are in here. Includes testing HTML, Javascript, and CSS files.

## /webroot/index.php
This is the entrypoint for the url checker code.

## /classes/
PHP files in here can be auto-loaded by index.php, they include the View loader, Curl helper, and HTTP Codes array.

## /views/
In here is one lonely view file used by the main "launching" file /webroot/index.php


