<?php

namespace App\Normalizer;

use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationListNormalizer implements ContextAwareNormalizerInterface
{
    public function normalize($errors, string $format = null, array $context = [])
    {
        $normalizedErrors = [];
        /** @var ConstraintViolationInterface $error */
        foreach ($errors as $error) {
            $normalizedErrors[] = [
                'path' => $error->getPropertyPath(),
                'value' => $error->getInvalidValue(),
                'error_code' => $error->getCode(),
                'error_message' => $error->getMessage(),
            ];
        }

        return $normalizedErrors;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof ConstraintViolationListInterface;
    }
}
