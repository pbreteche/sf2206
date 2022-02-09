<?php

namespace App\Serializer;

use App\Entity\Post;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class PostSerializer
{
    /** @var SerializerInterface */
    private $serializer;

    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    public function deserialize(string $data, ?Post $post): Post
    {
        $this->serializer->deserialize($data, Post::class, 'json', [
            AbstractNormalizer::OBJECT_TO_POPULATE => $post,
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['createdAt'],
        ]);

        return $post;
    }
}