<?php

namespace App\Entity;

use App\Entity\Trait;
use App\Entity\Trait\ActiveTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\TestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    use ActiveTrait;
    use SlugTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Une épreuve doit obligatoirement avoir un nom')]
    #[Assert\Length(
        min: 5,
        max: 49,
        maxMessage: 'Le nom d\'une épreuve peut avoir {{ limit }} caractères au maximum.'
    )]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $is_timed = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero(message: 'Le temps à chronométrer ne peut pas être négatif')]
    private ?int $timer = null;

    #[ORM\Column(length: 800)]
    #[Assert\Length(
        min: 5,
        max: 800,
        maxMessage: 'La consigne d\'une épreuve peut avoir {{ limit }} caractères au maximum.'
    )]
    private ?string $instructions_fr = null;

    #[ORM\Column(length: 800, nullable: true)]
    private ?string $instructions_cr = null;

    #[ORM\Column(length: 800, nullable: true)]
    private ?string $implementation_advice = null;

    #[ORM\ManyToOne(inversedBy: 'tests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TestType $typeTest = null;

    #[ORM\OneToMany(mappedBy: 'test', targetEntity: TemplateQuestion::class, cascade: ['persist'])]
    private Collection $templateQuestions;

    #[ORM\OneToMany(mappedBy: 'test', targetEntity: Item::class)]
    private Collection $items;

    #[ORM\OneToMany(mappedBy: 'test', targetEntity: Evaluation::class, orphanRemoval: true)]
    private Collection $evaluations;

    public function __construct()
    {
        $this->templateQuestions = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
        $this->slug = transliterator_transliterate(
            'Any-Latin; Latin-ASCII; Lower()',
            $this->name
        );
        $this->is_timed = false;
        $this->active = false;
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

    public function isIsTimed(): ?bool
    {
        return $this->is_timed;
    }

    public function setIsTimed(bool $is_timed): static
    {
        $this->is_timed = $is_timed;

        return $this;
    }

    public function getTimer(): ?int
    {
        return $this->timer;
    }

    public function setTimer(?int $timer): static
    {
        $this->timer = $timer;

        return $this;
    }

    public function getInstructionsFr(): ?string
    {
        return $this->instructions_fr;
    }

    public function setInstructionsFr(string $instructions_fr): static
    {
        $this->instructions_fr = $instructions_fr;

        return $this;
    }

    public function getInstructionsCr(): ?string
    {
        return $this->instructions_cr;
    }

    public function setInstructionsCr(?string $instructions_cr): static
    {
        $this->instructions_cr = $instructions_cr;

        return $this;
    }

    public function getImplementationAdvice(): ?string
    {
        return $this->implementation_advice;
    }

    public function setImplementationAdvice(?string $implementation_advice): static
    {
        $this->implementation_advice = $implementation_advice;

        return $this;
    }

    public function getTypeTest(): ?TestType
    {
        return $this->typeTest;
    }

    public function setTypeTest(?TestType $typeTest): static
    {
        $this->typeTest = $typeTest;

        return $this;
    }

    /**
     * @return Collection<int, TemplateQuestion>
     */
    public function getTemplateQuestions(): Collection
    {
        return $this->templateQuestions;
    }

    public function addTemplateQuestion(TemplateQuestion $templateQuestion): static
    {
        if (!$this->templateQuestions->contains($templateQuestion)) {
            $this->templateQuestions->add($templateQuestion);
            $templateQuestion->setTest($this);
        }

        return $this;
    }

    public function removeTemplateQuestion(TemplateQuestion $templateQuestion): static
    {
        if ($this->templateQuestions->removeElement($templateQuestion)) {
            // set the owning side to null (unless already changed)
            if ($templateQuestion->getTest() === $this) {
                $templateQuestion->setTest(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setTest($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getTest() === $this) {
                $item->setTest(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Evaluation>
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): static
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations->add($evaluation);
            $evaluation->setTest($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): static
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getTest() === $this) {
                $evaluation->setTest(null);
            }
        }

        return $this;
    }
}
