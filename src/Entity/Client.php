<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use App\Traits\CreatedUpdatedTrait;
use App\Traits\IdTrait;

/**
 * Class Client
 * @package App\Entity
 * @ORM\Entity
 */
class Client
{
    use IdTrait;
    use CreatedUpdatedTrait;

    /**
     * @var string The name of the client
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string The company name of the client
     *
     * @ORM\Column(type="string")
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $taxId;

    /**
     * @var string The address of the client
     *
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @var string The city of the client
     *
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @var string The postal code of the client
     *
     * @ORM\Column(type="string")
     */
    private $postalCode;

    /**
     * @var string The state of the client
     *
     * @ORM\Column(type="string")
     */
    private $state;

    /**
     * @var string The country of the client
     *
     * @ORM\Column(type="string", length=2)
     */
    private $country;

    /**
     * @var string The name of the client's person of contact
     *
     * @ORM\Column(type="string")
     */
    private $contactPersonName;

    /**
     * @var string The phone of the client's person of contact
     *
     * @ORM\Column(type="string")
     */
    private $contactPersonPhone;

    /**
     * @var string The email of the client's person of contact
     *
     * @ORM\Column(type="string")
     * @Assert\Email()
     */
    private $contactPersonEmail;

    /**
     * @ORM\OneToMany(targetEntity="GroupCompany", mappedBy="client")
     */
    private $groupCompany;

    /**
     * @ORM\OneToMany(targetEntity="Establishment", mappedBy="client")
     */
    private $establishments;

    /**
     * @ORM\OneToMany(targetEntity="Device", mappedBy="client")
     */
    private $devices;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="client")
     */
    private $users;
    /**
     *@ORM\OneToMany(targetEntity="App\Entity\Content", mappedBy="client")
     */
    private $contents;
    /**
     *@ORM\OneToMany(targetEntity="App\Entity\Channel", mappedBy="client")
     */
    private $channels;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->users = new ArrayCollection();
        $this->groupCompany = new ArrayCollection();
        $this->establishments = new ArrayCollection();
        $this->devices = new ArrayCollection();
        $this->contents = new ArrayCollection();
        $this->channels = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName(string $companyName): void
    {
        $this->companyName = $companyName;
    }

    /**
     * @return string
     */
    public function getTaxId()
    {
        return $this->taxId;
    }

    /**
     * @param string $taxId
     * @return Client
     */
    public function setTaxId(string $taxId)
    {
        $this->taxId = $taxId;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getContactPersonName(): ?string
    {
        return $this->contactPersonName;
    }

    /**
     * @param string $contactPersonName
     */
    public function setContactPersonName(string $contactPersonName): void
    {
        $this->contactPersonName = $contactPersonName;
    }

    /**
     * @return string
     */
    public function getContactPersonPhone(): ?string
    {
        return $this->contactPersonPhone;
    }

    /**
     * @param string $contactPersonPhone
     */
    public function setContactPersonPhone(string $contactPersonPhone): void
    {
        $this->contactPersonPhone = $contactPersonPhone;
    }

    /**
     * @return string
     */
    public function getContactPersonEmail(): ?string
    {
        return $this->contactPersonEmail;
    }

    /**
     * @param string $contactPersonEmail
     */
    public function setContactPersonEmail(string $contactPersonEmail): void
    {
        $this->contactPersonEmail = $contactPersonEmail;
    }

    public function __toString()
    {
        return $this->contactPersonEmail;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setClient($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getClient() === $this) {
                $user->setClient(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|GroupCompany[]
     */
    public function getGroupCompany(): Collection
    {
        return $this->groupCompany;
    }

    public function addGroup(GroupCompany $group): self
    {
        if (!$this->groupCompany->contains($group)) {
            $this->groupCompany[] = $group;
            $group->setClient($this);
        }

        return $this;
    }

    public function removeGroup(GroupCompany $group): self
    {
        if ($this->groupCompany->contains($group)) {
            $this->groupCompany->removeElement($group);
            // set the owning side to null (unless already changed)
            if ($group->getClient() === $this) {
                $group->setClient(null);
            }
        }

        return $this;
    }

    public function addGroupCompany(GroupCompany $groupCompany): self
    {
        if (!$this->groupCompany->contains($groupCompany)) {
            $this->groupCompany[] = $groupCompany;
            $groupCompany->setClient($this);
        }

        return $this;
    }

    public function removeGroupCompany(GroupCompany $groupCompany): self
    {
        if ($this->groupCompany->contains($groupCompany)) {
            $this->groupCompany->removeElement($groupCompany);
            // set the owning side to null (unless already changed)
            if ($groupCompany->getClient() === $this) {
                $groupCompany->setClient(null);
            }
        }

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
            $device->setClient($this);
        }

        return $this;
    }

    public function removeDevice(Device $device): self
    {
        if ($this->devices->contains($device)) {
            $this->devices->removeElement($device);
            // set the owning side to null (unless already changed)
            if ($device->getClient() === $this) {
                $device->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Content[]
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function addContent(Content $content): self
    {
        if (!$this->contents->contains($content)) {
            $this->contents[] = $content;
            $content->setClient($this);
        }

        return $this;
    }

    public function removeContent(Content $content): self
    {
        if ($this->contents->contains($content)) {
            $this->contents->removeElement($content);
            // set the owning side to null (unless already changed)
            if ($content->getClient() === $this) {
                $content->setClient(null);
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
            $establishment->setClient($this);
        }

        return $this;
    }

    public function removeEstablishment(Establishment $establishment): self
    {
        if ($this->establishments->contains($establishment)) {
            $this->establishments->removeElement($establishment);
            // set the owning side to null (unless already changed)
            if ($establishment->getClient() === $this) {
                $establishment->setClient(null);
            }
        }

        return $this;
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
     * @return Collection|Channel[]
     */
    public function getChannels(): Collection
    {
        return $this->channels;
    }

    public function addChannel(Channel $channel): self
    {
        if (!$this->channels->contains($channel)) {
            $this->channels[] = $channel;
            $channel->setClient($this);
        }

        return $this;
    }

    public function removeChannel(Channel $channel): self
    {
        if ($this->channels->contains($channel)) {
            $this->channels->removeElement($channel);
            // set the owning side to null (unless already changed)
            if ($channel->getClient() === $this) {
                $channel->setClient(null);
            }
        }

        return $this;
    }
}
