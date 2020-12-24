<?php

require 'Dev.php';

session_start();
$url = str_replace('/network3/', '', $_SERVER['REQUEST_URI']);

 define('WWW','/network3');                            
 define('CORE','/network3/vendor/core');   
 define('ROOT','');                 
 define('APP','/network3/app');
 define('LAYOUT','default');
 define('IMG','/network3/public/img');
 define('UPLOAD','/network3/uploads');
 define('AVATARS','/network3/uploads/avatars/');
 define('LOGO','InZpNet');

use vendor\core\Router;

spl_autoload_register(function ($class) {
   // echo '<br>'.$class.'<br>';
    $file = str_replace('\\', '/', $class).'.php';

    if (is_file($file)) {
        require_once $file;
    }
});
include 'vendor/core/routes.php';
Router::dispatch($url);

