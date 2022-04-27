<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity(fields={"name"}, message="Il y a déjà un tag avec ce nom")
 */
#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["data-tip","data-tag", "data-astuces-search-filter"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Groups(["data-tip","data-tag", "data-astuces-search-filter", "data-tip"])]
    #[Assert\NotBlank(message: 'Veuillez saisir un nom')]
    private $name;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["data-tag"])]
    private $createdAt;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["data-tag"])]
    private $updatedAt;

    #[ORM\ManyToMany(targetEntity: Tip::class, mappedBy: 'tag')]
    #[Groups(["data-tag"])]
    private $tips;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->tips = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Tip[]
     */
    public function getTips(): Collection
    {
        return $this->tips;
    }

    public function addTip(Tip $tip): self
    {
        if (!$this->tips->contains($tip)) {
            $this->tips[] = $tip;
            $tip->addTag($this);
        }

        return $this;
    }

    public function removeTip(Tip $tip): self
    {
        if ($this->tips->removeElement($tip)) {
            $tip->removeTag($this);
        }

        return $this;
    }
}
