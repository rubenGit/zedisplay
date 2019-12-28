<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\CreatedUpdatedTrait;
use App\Traits\IdTrait;
use Ramsey\Uuid\Uuid;

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
     *@ORM\ManyToOne(targetEntity="App\Entity\Content", inversedBy="device" , cascade={"persist", "merge", "detach"})
     */
    private $contents;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        try {
            $uuidGenerator = Uuid::uuid4();
            $this->id = $uuidGenerator->toString();
        } catch (\Exception $exception) {
            // Do something
        }
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

    public function getContents(): ?Content
    {
        return $this->contents;
    }

    public function setContents(?Content $contents): self
    {
        $this->contents = $contents;

        return $this;
    }



}
