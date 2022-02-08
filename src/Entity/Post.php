<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("main")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("main")
     * @Assert\NotBlank
     * @Assert\Length(max=70, groups={"create"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups("detail")
     * @Assert\NotBlank
     */
    private $body;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Ignore
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="posts", fetch="EAGER")
     */
    private $attachedTo;

    /**
     * @ORM\ManyToMany(targetEntity=KeyWord::class)
     * @Groups("detail")
     */
    private $keywords;

    public function __construct()
    {
        $this->keywords = new ArrayCollection();
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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAttachedTo(): ?Category
    {
        return $this->attachedTo;
    }

    public function setAttachedTo(?Category $attachedTo): self
    {
        $this->attachedTo = $attachedTo;

        return $this;
    }

    /**
     * @Groups("detail")
     */
    public function getCategoryName(): ?string
    {
        if ($this->attachedTo instanceof Category) {
            return $this->attachedTo->getName();
        }
        return null;
    }

    /**
     * @return Collection|KeyWord[]
     */
    public function getKeywords(): Collection
    {
        return $this->keywords;
    }

    public function addKeyword(KeyWord $keyword): self
    {
        if (!$this->keywords->contains($keyword)) {
            $this->keywords[] = $keyword;
        }

        return $this;
    }

    public function removeKeyword(KeyWord $keyword): self
    {
        $this->keywords->removeElement($keyword);

        return $this;
    }
}
