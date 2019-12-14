<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Traits\CreatedUpdatedTrait;
use App\Traits\IdTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeviceRepository")
 */
class Device
{
    use IdTrait;
    use CreatedUpdatedTrait;
    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\Establishment", inversedBy="devices", cascade={"persist"})
     */
    private $establishment;

    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="devices", cascade={"persist"})
     */
    private $client;


    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\Content", inversedBy="device", cascade={"persist"})
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __toString()
    {
        return $this->name;
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEstablishment(): ?Establishment
    {
        return $this->establishment;
    }

    public function setEstablishment(?Establishment $establishment): self
    {
        $this->establishment = $establishment;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getContent(): ?Content
    {
        return $this->content;
    }

    public function setContent(?Content $content): self
    {
        $this->content = $content;

        return $this;
    }
}
