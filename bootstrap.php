<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/src"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

// database configuration parameters
$conn = array(
    'url' => 'sqlite:///db.sqlite',
    'driver' => 'pdo_sqlite'
    // 'path' => __DIR__ . '/db.sqlite',
    // 'user' =>      'xxx',
    // 'password' =>  'xxx',
    // 'charset' =>   'UTF8'
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
