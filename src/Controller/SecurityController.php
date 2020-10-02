<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\TwigRenderer;
use Doctrine\ORM\EntityManager;
use Http\Request;
use Http\Response;

class SecurityController
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

    public function login()
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        
        if($this->request->getMethod() === 'POST') {
            $username = $this->request->getParameter('username');
            $password = $this->request->getParameter('password');
            if($username) {
                $user = $userRepository->findOneBy(['username' => $username, 'password' => $password]);
                
                if($user) {
                    $token = hash('sha1', $username);
                    setcookie("token", $token, time()+3600);

                    $this->entityManager->persist($user->setToken($token));
                    $this->entityManager->flush();
                    
                    header("Location: /");
                    exit();
                }
            }
        }
            
        $html = $this->renderer->render(
            'Login.twig', 
            []
        );
        
        $this->response->setContent($html);
    }
    
    public function logout()
    {
        setcookie('token', '', -1, '/'); 
        
        header("Location: /");
        exit();
    }
}