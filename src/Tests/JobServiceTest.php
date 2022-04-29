<?php

namespace App\Tests;

use App\Entity\Job;
use App\Entity\Status;
use App\Repository\JobRepository;

use App\Repository\StatusRepository;
use App\Service\JobService;
use Doctrine\ORM\EntityManager;
use Mockery;
use PHPUnit\Framework\TestCase;

class JobServiceTest extends TestCase
{
    public function testGetPostedJobs()
    {
        $jobRepository = Mockery::mock(JobRepository::class);
        $entityManagerMock = Mockery::mock(EntityManager::class);
        $statusRepository = Mockery::mock(StatusRepository::class);
        $job = new Job(1,1,'title', 'content', new \DateTime());
        $jobRepository->shouldReceive('findBy')->withAnyArgs()->twice()->andReturn([$job]);
        $jobService = new JobService($jobRepository, $entityManagerMock, $statusRepository, '', '');
        $result = $jobService->getAllJobs();
        $expectedResult = [
            'draft' => [$job],
            'posted'=> [$job]
        ];

        $this->assertEquals($expectedResult, $result);
    }

    public function testChangeStatus()
    {
        $jobRepository = Mockery::mock(JobRepository::class);
        $entityManagerMock = Mockery::mock(EntityManager::class);
        $statusRepository = Mockery::mock(StatusRepository::class);
        $job = new Job(1,1,'title', 'content', new \DateTime());
        $status = new Status();
        $status->setName('posted');
        $jobRepository->shouldReceive('find')->withArgs([1])->andReturns($job);
        $statusRepository->shouldReceive('find')->withArgs([2])->andReturns($status);
        $statusRepository->shouldReceive('find')->withArgs([1])->andReturns($status);
        $jobService = new JobService($jobRepository, $entityManagerMock, $statusRepository, 'posted', 'draft');
        $result = $jobService->changeStatus(1, 1);

        $this->assertEquals(false, $result);
    }

}