<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    /**
     * One Application has One Provider.
     * @OneToOne(targetEntity="App\Entity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private int $provider;

    #[ORM\Column(type: 'integer')]
    private $employee;

    #[ORM\Column(type: 'integer')]
    /**
     * One Product has One Shipment.
     * @OneToOne(targetEntity="App\Entity\Status")
     * @JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status;
    /**
     * @ManyToOne(targetEntity="App\Entity\Job")
     * @JoinColumn(name="job_id", referencedColumnName="id")
     */
    private int $job;

    /**
     * @return int
     */
    public function getJob(): int
    {
        return $this->job;
    }

    /**
     * @param int $job
     */
    public function setJob(int $job): void
    {
        $this->job = $job;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProvider(): ?int
    {
        return $this->provider;
    }

    public function setProvider(int $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function getEmployee(): ?int
    {
        return $this->employee;
    }

    public function setEmployee(int $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
