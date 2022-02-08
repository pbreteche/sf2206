<?php

namespace App\Normalizer;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationListNormalizer
{
    public function normalize(ConstraintViolationListInterface $errors)
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
}
