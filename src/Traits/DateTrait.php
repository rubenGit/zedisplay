<?php

namespace App\Traits;

use DateTimeInterface;

trait DateTrait
{
    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }
}
