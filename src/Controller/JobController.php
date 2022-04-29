<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\Status;
use App\Service\JobService;
use http\Exception\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    private JobService $jobService;
    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    #[Route('/job', name: 'app_job')]
    public function index(): Response
    {
        $jobs = $this->jobService->getAllJobs();

        return $this->render('jobs.html.twig', $jobs);
    }

    #[Route('/change-status', name: 'app_change_status')]
    public function changeStatus(Request $request): Response
    {
        $requestContent = $request->getContent();

        if (!isset($requestContent['job']) && !isset($requestContent['oldStatus'])) {
            throw new InvalidArgumentException('You need to input a job and a new status to proceed');
        }

        $job = $requestContent['job'];

        $oldStatus = $requestContent['oldStatus'];
        $success = $this->jobService->changeStatus(1, 1);
        $responseStatus = 500;

        if ($success === true) {
            $responseStatus = 500;
        }
        $response = new Response();
        $response->setStatusCode($responseStatus);
        return $response;
    }

    #[Route('/create-test-data', name: 'app_test_data_create')]
    public function createTestData(Request $request): Response
    {
        $this->jobService->createTestData();
        return new Response('Job created');
    }
}
