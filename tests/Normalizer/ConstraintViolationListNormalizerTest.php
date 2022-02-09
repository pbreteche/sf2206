<?php

namespace App\Tests\Normalizer;

use App\Entity\Post;
use App\Normalizer\ConstraintViolationListNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationListNormalizerTest extends TestCase
{
    private static $instance;

    public static function setUpBeforeClass(): void
    {
        self::$instance = new ConstraintViolationListNormalizer();
    }

    public function testSupportsNormalization(): void
    {
        $stub = $this->createStub(Post::class);
        $result = self::$instance->supportsNormalization($stub);

        $this->assertFalse($result, 'This should not support Post entity class');

        $stub = $this->createStub(ConstraintViolationListInterface::class);
        $result = self::$instance->supportsNormalization($stub);

        $this->assertTrue($result, 'This should support ConstraintViolationList class');

        $stub = $this->createStub(ConstraintViolationListInterface::class);
        $result = self::$instance->supportsNormalization($stub, 'json');

        $this->assertTrue($result, 'This should support in json format');
    }

    public function testNormalize(): void
    {
        $stub = $this->createStub(ConstraintViolationInterface::class);
        $stub->method('getPropertyPath')
            ->willReturn('a path');
        $stub->method('getInvalidValue')
            ->willReturn('a value');
        $stub->method('getCode')
            ->willReturn('a code');
        $stub->method('getMessage')
            ->willReturn('a message');

        $result = self::$instance->normalize([$stub]);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertIsArray($result[0]);
        $this->assertCount(4, $result[0]);
        $this->assertArrayHasKey('path', $result[0]);
        $this->assertArrayHasKey('value', $result[0]);
        $this->assertArrayHasKey('error_code', $result[0]);
        $this->assertArrayHasKey('error_message', $result[0]);
    }
}
