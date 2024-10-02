<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Item $item = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TemplateQuestion $templateQuestion = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: OptionResponse::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $optionResponses;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Score::class, orphanRemoval: true)]
    private Collection $scores;

    public function __construct()
    {
        $this->optionResponses = new ArrayCollection();
        $this->scores = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }
    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): static
    {
        $this->item = $item;

        return $this;
    }

    public function getTemplateQuestion(): ?TemplateQuestion
    {
        return $this->templateQuestion;
    }

    public function setTemplateQuestion(?TemplateQuestion $templateQuestion): static
    {
        $this->templateQuestion = $templateQuestion;

        return $this;
    }

    /**
     * @return Collection<int, OptionResponse>
     */
    public function getOptionResponses(): Collection
    {
        return $this->optionResponses;
    }

    public function addOptionResponse(OptionResponse $optionResponse): static
    {
        if (!$this->optionResponses->contains($optionResponse)) {
            $this->optionResponses->add($optionResponse);
            $optionResponse->setQuestion($this);
        }

        return $this;
    }

    public function removeOptionResponse(OptionResponse $optionResponse): static
    {
        if ($this->optionResponses->removeElement($optionResponse)) {
            // set the owning side to null (unless already changed)
            if ($optionResponse->getQuestion() === $this) {
                $optionResponse->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Score>
     */
    public function getScores(): Collection
    {
        return $this->scores;
    }

    public function addScore(Score $score): static
    {
        if (!$this->scores->contains($score)) {
            $this->scores->add($score);
            $score->setQuestion($this);
        }

        return $this;
    }

    public function removeScore(Score $score): static
    {
        if ($this->scores->removeElement($score)) {
            // set the owning side to null (unless already changed)
            if ($score->getQuestion() === $this) {
                $score->setQuestion(null);
            }
        }

        return $this;
    }
}
