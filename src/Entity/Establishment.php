<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\CreatedUpdatedTrait;
use App\Traits\IdTrait;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EstablishmentRepository")
 */
class Establishment
{
    use IdTrait;
    use CreatedUpdatedTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\GroupCompany", inversedBy="establishments")
     */
    private $groupCompany;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="establishments")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Device", mappedBy="establishment", cascade={"remove"})
     */
    private $devices;

    public function __toString()
    {
        return $this->name ;
    }

    public function __construct()
    {
        try {
            $uuidGenerator = Uuid::uuid4();
            $this->id = $uuidGenerator->toString();
        } catch (\Exception $exception) {
            // Do something
        }

        $this->devices = new ArrayCollection();
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

    /**
     * @return Collection|Device[]
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addDevice(Device $device): self
    {
        if (!$this->devices->contains($device)) {
            $this->devices[] = $device;
            $device->setEstablishment($this);
        }

        return $this;
    }

    public function removeDevice(Device $device): self
    {
        if ($this->devices->contains($device)) {
            $this->devices->removeElement($device);
            // set the owning side to null (unless already changed)
            if ($device->getEstablishment() === $this) {
                $device->setEstablishment(null);
            }
        }

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

    public function getGroupCompany(): ?GroupCompany
    {
        return $this->groupCompany;
    }

    public function setGroupCompany(?GroupCompany $groupCompany): self
    {
        $this->groupCompany = $groupCompany;

        return $this;
    }


}
