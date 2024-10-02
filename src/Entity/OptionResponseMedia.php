<?php

namespace App\Entity;

use App\Repository\OptionResponseMediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionResponseMediaRepository::class)]
class OptionResponseMedia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\ManyToMany(targetEntity: OptionResponse::class, inversedBy: 'OptionResponsesMedias')]
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
    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, OptionResponse>
     */
    public function getoptionResponses(): Collection
    {
        return $this->optionResponses;
    }

    public function addOptionRespone(OptionResponse $optionRespone): static
    {
        if (!$this->optionResponses->contains($optionRespone)) {
            $this->optionResponses->add($optionRespone);
        }

        return $this;
    }

    public function removeOptionRespone(OptionResponse $optionRespone): static
    {
        $this->optionResponses->removeElement($optionRespone);

        return $this;
    }
}
