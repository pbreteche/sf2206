<?php

namespace App\Transient;

class FacebookPublicationInput
{
    private $id;
    private $publishDate;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getPublishDate()
    {
        return $this->publishDate;
    }

    public function setPublishDate(\DateTimeImmutable $publishDate): self
    {
        $this->publishDate = $publishDate;
        return $this;
    }
}