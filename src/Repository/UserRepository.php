<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class UserRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em,$class);
    }
}