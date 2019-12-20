<?php

namespace App\Traits;

trait IdTrait
{
    /**
     * @ORM\Column(type="string", unique=true)
     * @ORM\Id
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
