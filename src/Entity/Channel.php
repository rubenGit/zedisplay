<?php

namespace App\Entity;

use App\Traits\IdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
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
     *@ORM\OneToMany(targetEntity="App\Entity\Content", mappedBy="channel", cascade={"persist"})
     */
    private $contents;

    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="channels", cascade={"persist"})
     */
    private $client;

    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\Device", inversedBy="channels", cascade={"persist"})
     */
    private $device;

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
    }
    public function getId(): ?int
    {
        return $this->id;
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
            $content->setChannel($this);
        }

        return $this;
    }

    public function removeContent(Content $content): self
    {
        if ($this->contents->contains($content)) {
            $this->contents->removeElement($content);
            // set the owning side to null (unless already changed)
            if ($content->getChannel() === $this) {
                $content->setChannel(null);
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

    public function getDevice(): ?Device
    {
        return $this->device;
    }

    public function setDevice(?Device $device): self
    {
        $this->device = $device;

        return $this;
    }
}
