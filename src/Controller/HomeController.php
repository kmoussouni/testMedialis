<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Item;
use App\Entity\TodoList;
use App\Entity\User;
use App\Service\TwigRenderer;
use Doctrine\ORM\EntityManager;
use Http\Request;
use Http\Response;

class HomeController
{
    private $request;
    private $response;
    protected $renderer;
    private $entityManager;

    public function __construct(Request $request, Response $response, TwigRenderer $renderer, EntityManager $entityManager)
    {
        $this->request = $request;
        $this->response = $response;
        $this->renderer = $renderer;
        $this->entityManager = $entityManager;
    }

    public function show()
    {
        $cookies = $this->request->getCookies();
        if(!$cookies) {
            header("Location: /login");
            die();
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['token' => $cookies['token']]);

        $items = $this->entityManager->getRepository(Item::class)->findBy([
            'user' => $user->getId()
        ]);
    
        $html = $this->renderer->render(
            'HomeController.twig', 
            [
                'items' => $items,
                'user' => $user->getId()
            ]
        );

        
        $this->response->setContent($html);
    }
}
