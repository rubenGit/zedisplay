<?php

namespace App\Entity;

use App\Traits\IdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChannelRepository")
 */
class Channel
{
    use IdTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     *@ORM\ManyToMany(targetEntity="App\Entity\Content", mappedBy="channels", cascade={"persist","remove"})
     */
    private $contents;

    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="channels", cascade={"persist"})
     */
    private $client;

    /**
     *@ORM\ManyToMany(targetEntity="App\Entity\Device", inversedBy="channels", cascade={"persist","remove"})
     *@JoinTable(name="channels_devices",
     *      joinColumns={@JoinColumn(name="channel_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="device_id", referencedColumnName="id")}
     *      )
     */
    private $devices;

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
        $this->contents = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeDevice(Device $device): self
    {
        if ($this->devices->contains($device)) {
            $this->devices->removeElement($device);
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
            $content->addChannel($this);
        }

        return $this;
    }

    public function removeContent(Content $content): self
    {
        if ($this->contents->contains($content)) {
            $this->contents->removeElement($content);
            $content->removeChannel($this);
        }

        return $this;
    }
}
