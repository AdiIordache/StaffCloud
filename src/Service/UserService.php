<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {

        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function createUser(UserType $type): User
    {
        $user = new User();
        $user->setType($type->getId());
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function getUsers(): array
    {
        return $this->userRepository->findAll();
    }
}