<?php

namespace App\Entity;

use App\Repository\TipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TipRepository::class)]
class Tip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["data-tip","data-comment","data-rating"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["data-tip","data-comment","data-rating"])]
    #[Assert\NotBlank(message: 'Veuillez saisir un titre')]
    private $title;

    #[ORM\Column(type: 'text')]
    #[Groups(["data-tip"])]
    #[Assert\NotBlank(message: 'Veuillez remplir votre astuce')]
    private $content;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["data-tip"])]
    private $createdAt;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["data-tip"])]
    private $updatedAt;

    #[ORM\OneToMany(mappedBy: 'tip', targetEntity: Comment::class, orphanRemoval: true)]
    #[Groups(["data-tip"])]
    private $comments;

    #[ORM\OneToMany(mappedBy: 'tip', targetEntity: Rating::class, orphanRemoval: true)]
    #[Groups(["data-tip"])]
    private $ratings;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'tips')]
    #[Groups(["data-tip"])]
    private $tag;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tips')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["data-tip"])]
    private $user;

    #[ORM\Column(type: 'boolean')]
    private $isValid;

    public function __construct()
    {
        $this->isValid = false;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->comments = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->tag = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTip($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTip() === $this) {
                $comment->setTip(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setTip($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getTip() === $this) {
                $rating->setTip(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tag->removeElement($tag);

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

    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }
}
