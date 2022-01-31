<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: RatingRepository::class)]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["data-rating","data-tip"])]
    private $id;

    #[ORM\ManyToOne(targetEntity: Tip::class, inversedBy: 'ratings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["data-rating","data-tip"])]
    private $tip;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ratings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["data-rating","data-tip"])]
    private $user;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["data-rating"])]
    private $createdAt;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["data-rating"])]
    private $updatedAt;

    #[ORM\Column(type: 'integer')]
    #[Groups(["data-rating","data-tip"])]
    #[Assert\NotBlank(message: 'Veuillez saisir une note')]
    private $value;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTip(): ?Tip
    {
        return $this->tip;
    }

    public function setTip(?Tip $tip): self
    {
        $this->tip = $tip;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }
}
