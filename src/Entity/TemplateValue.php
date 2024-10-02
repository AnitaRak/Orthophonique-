<?php

namespace App\Entity;

use App\Repository\TemplateValueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemplateValueRepository::class)]
class TemplateValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $complete_name = null;

    #[ORM\Column]
    private ?int $score = null;

    #[ORM\ManyToOne(inversedBy: 'templateValues')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TemplateQuestion $templateQuestion = null;

    #[ORM\OneToMany(mappedBy: 'templateValue', targetEntity: OptionResponse::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $optionResponses;

    public function __construct()
    {
        $this->optionResponses = new ArrayCollection();
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
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCompleteName(): ?string
    {
        return $this->complete_name;
    }

    public function setCompleteName(?string $complete_name): static
    {
        $this->complete_name = $complete_name;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

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
            $optionResponse->setTemplateValue($this);
        }

        return $this;
    }

    public function removeOptionResponse(OptionResponse $optionResponse): static
    {
        if ($this->optionResponses->removeElement($optionResponse)) {
            // set the owning side to null (unless already changed)
            if ($optionResponse->getTemplateValue() === $this) {
                $optionResponse->setTemplateValue(null);
            }
        }

        return $this;
    }
}
