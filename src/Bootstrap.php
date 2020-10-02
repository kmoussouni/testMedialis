<?php

declare(strict_types=1);

namespace App;

use FastRoute\Dispatcher;
use Whoops\Handler\PrettyPageHandler;
use function FastRoute\simpleDispatcher;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);

$environment = 'development';

/**
 * Register the error handler
 */
$whoops = new \Whoops\Run;
if ($environment !== 'production') {
    $whoops->pushHandler(new PrettyPageHandler());
} else {
    $whoops->pushHandler(function ($e) {
        echo 'Dev Mode';
    });
}
$whoops->register();

// Doctrine
$injector = include('Dependencies.php');

// Router
$injector->alias('Http\Request', 'Http\HttpRequest');
$injector->share('Http\HttpRequest');
$injector->define('Http\HttpRequest', [
    ':get' => $_GET,
    ':post' => $_POST,
    ':cookies' => $_COOKIE,
    ':files' => $_FILES,
    ':server' => $_SERVER,
]);

$injector->alias('Http\Response', 'Http\HttpResponse');
$injector->share('Http\HttpResponse');
$request = $injector->make('Http\HttpRequest');
$response = $injector->make('Http\HttpResponse');

foreach ($response->getHeaders() as $header) {
    header($header, false);
}

$routeDefinitionCallback = function (\FastRoute\RouteCollector $r) {
    $routes = include('Routes.php');
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
};
$dispatcher = simpleDispatcher($routeDefinitionCallback);

if($_SERVER['DOCUMENT_ROOT']) {

    if($request->getMethod()) {
        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $response->setContent('404 - Page not found');
                $response->setStatusCode(404);
            break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $response->setContent('405 - Method not allowed');
                $response->setStatusCode(405);
        break;
        case \FastRoute\Dispatcher::FOUND:
            
            $className = $routeInfo[1][0];
            $method = $routeInfo[1][1];
            $vars = $routeInfo[2];
            
            $cookies = $request->getCookies();
            
            if(!empty($cookies)) {
                if(!$cookies['token']) {
                    if (!empty($routeInfo[1][2]) && $routeInfo[1][2] === Section::PROTECTED) {
                        {
                            header("Location: /login");
                            die();
                        }
                            
                        break;
                    }
                }
            }

            $class = $injector->make($className);
            $class->$method($vars);
            break;
        }
        
        echo $response->getContent();
    }

}