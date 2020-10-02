<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Item;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Http\Request;
use Http\Response;
use Whoops\Exception\ErrorException;

class ItemController
{
    private $request;
    private $response;
    private $entityManager;

    public function __construct(Request $request, Response $response, EntityManager $entityManager)
    {
        $this->request = $request;
        $this->response = $response;
        $this->entityManager = $entityManager;
    }

    public function getAll()
    {
        $todolist_id = $this->request->getBodyParameter('todolist_id');

        die($todolist_id);

        $todolists = $this->entityManager
            ->createQueryBuilder('t')
            ->select('')
            ->from(TodoList::class, 't');
;
        return json_encode($todolists);

    }

    public function get($id)
    {
        $todolist = $this->entityManager
            ->createQueryBuilder('t')
            ->select('')
            ->from(TodoList::class, 't')
            ->where('id = :id')
            ->setParameter('id', $id);

        return $this->response(json_encode($todolist));
    }

    public function post()
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        
        $message = $this->request->getBodyParameter('message');
        $token = $this->request->getCookie('token');

        $user = $userRepository->findOneBy(['token' => $token]);
        
        if(!isset($user)) throw new ErrorException();

        $item = new Item();
        $item->setMessage($message);
        $item->setChecked(false);
        $item->setUser($user);

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        $this->response->setStatusCode(200);
        $this->response->setContent(\json_encode([
            'id' => $item->getId(),
            'message' => $item->getMessage(),
            ]));

        return $this->response;
    }

    public function delete()
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $itemRepository = $this->entityManager->getRepository(Item::class);
        
        $uri = $this->request->getUri();

        $re = '/(\/api\/item\/){1}/';
        $data = preg_split($re, $uri);
        
        $id = $data[1];

        $token = $this->request->getCookie('token');

        $user = $userRepository->findOneBy(['token' => $token]);
        $item = $itemRepository->findOneBy(['id' => $id]);
        
        if(!isset($user)) throw new ErrorException('No User detected');
        if(!$item) throw new ErrorException('No Item detected');

        $this->entityManager->remove($item);
        $this->entityManager->flush();

        $this->response->setStatusCode(200);
        $this->response->setContent(\json_encode([
            'id' => $id
            ]));

        return $this->response;
    }
}
