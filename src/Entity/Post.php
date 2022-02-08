<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

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
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups("detail")
     */
    private $body;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Ignore
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     */
    private $attachedTo;

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
}
