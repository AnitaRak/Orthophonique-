<?php

namespace App\Entity;

use App\Repository\TemplateQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TemplateQuestionRepository::class)]
class TemplateQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $requires_audio = false;

    #[ORM\Column]
    private ?bool $requires_text = false;

    #[ORM\Column]
    private ?bool $is_included_in_total_score = false;

    #[ORM\Column]
    private ?bool $is_mcq = false;

    #[ORM\Column]
    private ?bool $is_custom_score = false;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\Length(
        min: 3,
        max: 254,
        minMessage: 'On doit préciser ce que chaque question évalue/renseigne.',
        maxMessage: 'Ce qui est évalué doit être désigné (Production de l\'enfant, niveau d\'aide...).'
    )]
    private ?string $instructions_fr;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instructions_cr = null;

    #[ORM\ManyToOne(inversedBy: 'templateQuestions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Test $test = null;

    #[ORM\OneToMany(mappedBy: 'templateQuestion', targetEntity: TemplateValue::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $templateValues;

    #[ORM\OneToMany(mappedBy: 'templateQuestion', targetEntity: Question::class, orphanRemoval: true)]
    private Collection $questions;

    public function __construct()
    {
        $this->templateValues = new ArrayCollection();
        $this->questions = new ArrayCollection();
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
    public function isRequiresAudio(): ?bool
    {
        return $this->requires_audio;
    }

    public function setRequiresAudio(bool $requires_audio): static
    {
        $this->requires_audio = $requires_audio;

        return $this;
    }

    public function isRequiresText(): ?bool
    {
        return $this->requires_text;
    }

    public function setRequiresText(bool $requires_text): static
    {
        $this->requires_text = $requires_text;

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

    public function isIsMcq(): ?bool
    {
        return $this->is_mcq;
    }

    public function setIsMcq(bool $is_mcq): static
    {
        $this->is_mcq = $is_mcq;

        return $this;
    }

    public function isIsCustomScore(): ?bool
    {
        return $this->is_custom_score;
    }

    public function setIsCustomScore(bool $is_custom_score): static
    {
        $this->is_custom_score = $is_custom_score;

        return $this;
    }

    public function getInstructionsFr(): ?string
    {
        return $this->instructions_fr;
    }

    public function setInstructionsFr(?string $instructions_fr): static
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

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): static
    {
        $this->test = $test;

        return $this;
    }

    /**
     * @return Collection<int, TemplateValue>
     */
    public function getTemplateValues(): Collection
    {
        return $this->templateValues;
    }

    public function addTemplateValue(TemplateValue $templateValue): static
    {
        if (!$this->templateValues->contains($templateValue)) {
            $this->templateValues->add($templateValue);
            $templateValue->setTemplateQuestion($this);
        }

        return $this;
    }

    public function removeTemplateValue(TemplateValue $templateValue): static
    {
        if ($this->templateValues->removeElement($templateValue)) {
            // set the owning side to null (unless already changed)
            if ($templateValue->getTemplateQuestion() === $this) {
                $templateValue->setTemplateQuestion(null);
            }
        }
        return $this;
    }
    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setTemplateQuestion($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getTemplateQuestion() === $this) {
                $question->setTemplateQuestion(null);
            }
        }

        return $this;
    }
}
