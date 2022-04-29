<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

trait ServiceTrait
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}