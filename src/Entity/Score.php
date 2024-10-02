<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScoreRepository::class)]
class Score
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $points = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $value_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $response_name = null;

    #[ORM\Column]
    private ?bool $is_included_in_total_score = null;

    #[ORM\ManyToOne(inversedBy: 'scores')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    #[ORM\ManyToOne(inversedBy: 'scores')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Response $response = null;

    
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }
    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function getValueName(): ?string
    {
        return $this->value_name;
    }

    public function setValueName(?string $value_name): static
    {
        $this->value_name = $value_name;

        return $this;
    }

    public function getResponseName(): ?string
    {
        return $this->response_name;
    }

    public function setResponseName(?string $response_name): static
    {
        $this->response_name = $response_name;

        return $this;
    }

    public function isIsIncludedInTotalScore(): ?bool
    {
        return $this->is_included_in_total_score;
    }

    public function setIsIncludedInTotalScore(bool $is_included_in_total_score): static
    {
        $this->is_included_in_total_score = $is_included_in_total_score;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }

    public function setResponse(?Response $response): static
    {
        $this->response = $response;

        return $this;
    }
}
