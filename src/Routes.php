<?php

declare(strict_types = 1);

return [
    ['GET', '/', ['App\Controller\HomeController', 'show', \App\Section::PROTECTED]],
    ['GET', '/login', ['App\Controller\SecurityController', 'login']],
    ['POST', '/login', ['App\Controller\SecurityController', 'login']],
    ['GET', '/logout', ['App\Controller\SecurityController', 'logout']],
    ['GET', '/api/items', ['App\Controller\Api\ItemController', 'getAll', \App\Section::PROTECTED]],
    ['POST', '/api/item', ['App\Controller\Api\ItemController', 'post', \App\Section::PROTECTED]],
    ['DELETE', '/api/item/{item_id}', ['App\Controller\Api\ItemController', 'delete', \App\Section::PROTECTED]],
];
