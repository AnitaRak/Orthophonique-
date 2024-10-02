<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait ActiveTrait
{

    #[ORM\Column]
    private ?bool $active = null;

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }
}
