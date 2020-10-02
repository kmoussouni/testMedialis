<?php

declare(strict_types=1);

namespace App;

use Auryn\Injector;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$injector = new Injector();

//// doctrine
$connectionParams = array(
    'url' => 'sqlite:///../db.sqlite',
    'driver' => 'pdo_sqlite'
);
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

$entityManager = EntityManager::create($conn, $config);

$injector->delegate('Doctrine\ORM\EntityManager', function () use ($entityManager) {
    return $entityManager;
});

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

$injector->alias('Twig\Loader\FilesystemLoader', 'Twig\Loader\FilesystemLoader');
$injector->delegate('Twig\Environment', function () use ($injector) {
    $loader = new FilesystemLoader(dirname(__DIR__) . '/templates');
    $twig = new Environment($loader);
    return $twig;
});

return $injector;
