<?php

namespace App\Service;

use App\Entity\Job;
use App\Entity\Status;
use App\Entity\User;
use App\Entity\UserType;
use App\Repository\JobRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\InvalidArgumentException;


class JobService
{
    private JobRepository $jobRepository;
    private EntityManagerInterface $entityManager;
    private StatusRepository $statusRepository;
    private string $draftConfiguration;
    private string $postedConfiguration;
    public function __construct(
        JobRepository $jobRepository,
        EntityManagerInterface $entityManager,
        StatusRepository $statusRepository,
        string $draftConfiguration,
        string $postedConfiguration)
    {
        $this->jobRepository = $jobRepository;
        $this->entityManager = $entityManager;
        $this->statusRepository = $statusRepository;
        $this->draftConfiguration = $draftConfiguration;
        $this->postedConfiguration = $postedConfiguration;
    }

    public function getAllJobs(): array
    {
        $postedJobs = $this->jobRepository->findBy(['status' => Status::POSTED_STATUS]);
        $draftJobs = $this->jobRepository->findBy(['status' => Status::DRAFT_STATUS]);

        return ['draft' => $draftJobs, 'posted' => $postedJobs];
    }

    public function changeStatus(int $jobId, int $oldStatus): bool
    {
        $config = [
            'draft' => [$this->draftConfiguration],
            'posted' => [$this->postedConfiguration]
        ];

        $newStatusId = $oldStatus === 1 ? 2 : 1;
        /** @var Job $job */
        $job = $this->jobRepository->find($jobId);

        /** @var Status $status */
        $status = $this->statusRepository->find($newStatusId);
        $oldStatus = $this->statusRepository->find($oldStatus);
        if (isset($config[$status->getName()]) && in_array($oldStatus->getName(), $config[$status->getName()])) {
            $job->setStatus($newStatusId);
            $this->entityManager->flush($job);
            return true;
        }
        return false;
    }

    public function createTestData(): void
    {
        $user = new User();
        $user->setName('Test');
        $userType = new UserType();
        $userType->setType('Client');
        $draftStatus = new Status();
        $draftStatus->setName('Draft');
        $postedStatus = new Status();
        $postedStatus->setName('Posted');
        $this->entityManager->persist($postedStatus);
        $this->entityManager->flush();
        $this->entityManager->persist($userType);
        $this->entityManager->flush();
        $this->entityManager->persist($user);
        $user->setType($userType->getId());
        $this->entityManager->flush();
        $this->entityManager->persist($draftStatus);
        $this->entityManager->flush();
        $i= 0;
        while ($i<=5) {
        $job = new Job($user->getId(), $draftStatus->getId(),'Some title'.$i, 'Some content', new \DateTime());
        $this->entityManager->persist($job);
        $this->entityManager->flush();
        $i++;
        }
    }
}