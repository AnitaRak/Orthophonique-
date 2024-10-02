<?php

namespace App\Entity;

use App\Repository\OptionResponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionResponseRepository::class)]
class OptionResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 90)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'optionResponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    #[ORM\ManyToOne(inversedBy: 'optionResponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TemplateValue $templateValue = null;

    #[ORM\ManyToMany(targetEntity: OptionResponseMedia::class, mappedBy: 'optionResponses')]
    private Collection $optionResponsesMedias;

    public function __construct()
    {
        $this->optionResponsesMedias = new ArrayCollection();
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

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getTemplateValue(): ?TemplateValue
    {
        return $this->templateValue;
    }

    public function setTemplateValue(?TemplateValue $templateValue): static
    {
        $this->templateValue = $templateValue;

        return $this;
    }

    /**
     * @return Collection<int, OptionResponseMedia>
     */
    public function getOptionResponsesMedias(): Collection
    {
        return $this->optionResponsesMedias;
    }

    public function addOptionResponsesMedia(OptionResponseMedia $optionResponsesMedia): static
    {
        if (!$this->optionResponsesMedias->contains($optionResponsesMedia)) {
            $this->optionResponsesMedias->add($optionResponsesMedia);
            $optionResponsesMedia->addOptionRespone($this);
        }

        return $this;
    }

    public function removeOptionResponsesMedia(OptionResponseMedia $optionResponsesMedia): static
    {
        if ($this->optionResponsesMedias->removeElement($optionResponsesMedia)) {
            $optionResponsesMedia->removeOptionRespone($this);
        }

        return $this;
    }
}
