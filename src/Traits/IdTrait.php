<?php

namespace App\Traits;

trait IdTrait
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    public function getId(): ?string
    {
        return $this->id;
    }
}
