<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\CreatedUpdatedTrait;
use App\Traits\IdTrait;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
 */
class GroupCompany
{
    use IdTrait;
    use CreatedUpdatedTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="groupCompany")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Establishment", mappedBy="groupCompany", cascade={"remove"})
     */
    private $establishments;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;


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
        $this->establishmentsofGroup = new ArrayCollection();
        $this->establishments = new ArrayCollection();
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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|Establishment[]
     */
    public function getEstablishmentsofGroup(): Collection
    {
        return $this->establishmentsofGroup;
    }

    public function addEstablishmentsofGroup(Establishment $establishmentsofGroup): self
    {
        if (!$this->establishmentsofGroup->contains($establishmentsofGroup)) {
            $this->establishmentsofGroup[] = $establishmentsofGroup;
            $establishmentsofGroup->setGCompany($this);
        }

        return $this;
    }

    public function removeEstablishmentsofGroup(Establishment $establishmentsofGroup): self
    {
        if ($this->establishmentsofGroup->contains($establishmentsofGroup)) {
            $this->establishmentsofGroup->removeElement($establishmentsofGroup);
            // set the owning side to null (unless already changed)
            if ($establishmentsofGroup->getGCompany() === $this) {
                $establishmentsofGroup->setGCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Establishment[]
     */
    public function getEstablishments(): Collection
    {
        return $this->establishments;
    }

    public function addEstablishment(Establishment $establishment): self
    {
        if (!$this->establishments->contains($establishment)) {
            $this->establishments[] = $establishment;
            $establishment->setGroupCompany($this);
        }

        return $this;
    }

    public function removeEstablishment(Establishment $establishment): self
    {
        if ($this->establishments->contains($establishment)) {
            $this->establishments->removeElement($establishment);
            // set the owning side to null (unless already changed)
            if ($establishment->getGroupCompany() === $this) {
                $establishment->setGroupCompany(null);
            }
        }

        return $this;
    }

}
