<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $budget;

    /**
     * @ORM\ManyToOne(targetEntity=Contact::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contacts;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getBudget(): ?string
    {
        return $this->budget;
    }

    public function setBudget(string $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getContacts(): ?Contact
    {
        return $this->contacts;
    }

    public function setContacts(?Contact $contacts): self
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "id"        => $this->getId(),
            "name"      => $this->getName(),
            "code"      => $this->getCode(),
            "url"       => $this->getUrl(),
            "budget"    => $this->getBudget(),
            "contacts"  => $this->getContacts(),
        ];
    }
}
