<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;

#[ORM\Entity(repositoryClass: JobRepository::class)]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    /**
     * @OneToMany(targetEntity="App\Entity\Application", mappedBy="job")
     */
    private int $id;

    #[ORM\Column(type: 'integer')]

    private int $user;

    #[ORM\Column(type: 'string', length: 10)]
    /**
     * @var Status
     * @ManyToOne(targetEntity="App\Entity\Status")
     * @JoinColumn(name="status_id", referencedColumnName="id")
     */
    private int $status;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 500)]
    private $content;

    #[ORM\Column(type: 'date')]
    private $lifecycle;

    /**
     * @param $title
     * @param $content
     * @param $Lifecycle
     */
    public function __construct(int $user, int $status, $title, $content, $Lifecycle)
    {
        $this->user = $user;
        $this->status = $status;
        $this->title = $title;
        $this->content = $content;
        $this->lifecycle = $Lifecycle;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): int
    {
        return $this->user;
    }

    public function setUser(int $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getLifecycle(): ?\DateTimeInterface
    {
        return $this->lifecycle;
    }

    public function setLifecycle(\DateTimeInterface $lifecycle): self
    {
        $this->lifecycle = $lifecycle;

        return $this;
    }
}
