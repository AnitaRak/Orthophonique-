<?php

namespace App\Entity;

use App\Entity\Trait\ActiveTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    use ActiveTrait;
    use SlugTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 90, nullable: true)]
    private ?string $name_cr = null;

    #[ORM\Column(length: 90)]
    #[Assert\NotBlank(message: 'Un item doit obligatoirement avoir un nom')]
    private ?string $name_fr = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Test $test = null;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: Question::class, orphanRemoval: true)]
    private Collection $questions;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: Response::class, orphanRemoval: true)]
    private Collection $responses;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: Illustration::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $illustrations;

    #[ORM\ManyToOne]
    private ?SchoolGrade $school_grade = null;

    #[ORM\Column]
    private ?int $sequence = null;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->responses = new ArrayCollection();
        $this->illustrations = new ArrayCollection();
        $this->active = true;
    }
    /**
     * Add questions based on TemplateQuestions associated with the Item's Test.
     */
    public function addQuestionsFromTemplateQuestions(): void
    {
        foreach ($this->getTest()->getTemplateQuestions() as $templateQuestion) {
            $question = new Question();
            $question->setActive(true);
            $question->setItem($this);
            $question->setTemplateQuestion($templateQuestion);
            $this->addQuestion($question);
        }
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
    public function getNameCr(): ?string
    {
        return $this->name_cr;
    }

    public function setNameCr(?string $name_cr): static
    {
        $this->name_cr = $name_cr;

        return $this;
    }

    public function getNameFr(): ?string
    {
        return $this->name_fr;
    }

    public function setNameFr(string $name_fr): static
    {
        $this->name_fr = $name_fr;

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
            $question->setItem($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getItem() === $this) {
                $question->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Response>
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Response $response): static
    {
        if (!$this->responses->contains($response)) {
            $this->responses->add($response);
            $response->setItem($this);
        }

        return $this;
    }

    public function removeResponse(Response $response): static
    {
        if ($this->responses->removeElement($response)) {
            // set the owning side to null (unless already changed)
            if ($response->getItem() === $this) {
                $response->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Illustration>
     */
    public function getIllustrations(): Collection
    {
        return $this->illustrations;
    }

    public function addIllustration(Illustration $illustration): static
    {
        if (!$this->illustrations->contains($illustration)) {
            $this->illustrations->add($illustration);
            $illustration->setItem($this);
        }

        return $this;
    }

    public function removeIllustration(Illustration $illustration): static
    {
        if ($this->illustrations->removeElement($illustration)) {
            // set the owning side to null (unless already changed)
            if ($illustration->getItem() === $this) {
                $illustration->setItem(null);
            }
        }
        return $this;
    }

    public function getSchoolGrade(): ?SchoolGrade
    {
        return $this->school_grade;
    }

    public function setSchoolGrade(?SchoolGrade $school_grade): static
    {
        $this->school_grade = $school_grade;

        return $this;
    }

    public function getSequence(): ?int
    {
        return $this->sequence;
    }

    public function setSequence(int $sequence): static
    {
        $this->sequence = $sequence;

        return $this;
    }
}
