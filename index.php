<?php

define('BASE_PATH', dirname(__FILE__));


require 'vendor/autoload.php';
require 'conf.php';


$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);


$app->get('/', function ($request, $response){
    return $response->withRedirect(SYSTEM_URL);
});


$app->get('/{cod}', function($request, $response){
    $code = $request->getAttribute('cod');

    $Correios = new \App\Controllers\CorreiosController($_conf);
    $events = $Correios->getListEvents($code);
    
    return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($events));
});






 
 


$app->add(function ($request, $response, $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath(substr($path, 0, -1));
        
        if($request->getMethod() == 'GET') {
            return $response->withRedirect((string)$uri, 301);
        }
        else {
            return $next($request->withUri($uri), $response);
        }
    }

    return $next($request, $response);
});
 
$app->run();