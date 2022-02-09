<?php

namespace App\Validator;

use App\Repository\KeyWordRepository;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueKeywordValidator extends ConstraintValidator
{
    /** @var KeyWordRepository */
    private $repository;
    /** @var PropertyAccessorInterface */
    private $propertyAccessor;

    public function __construct(
        KeyWordRepository $repository,
        PropertyAccessorInterface $propertyAccessor
    ) {
        $this->repository = $repository;
        $this->propertyAccessor = $propertyAccessor;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\UniqueKeyword */

        $name = $this->propertyAccessor->getValue($value, 'name');
        if (!$name) {
            throw new \Exception('UniqueKeyword constraint need a "name" property path');
        }

        if (null === $name || '' === $name) {
            return;
        }

        $existingKeywords = $this->repository->findBy(['name' => $name]);

        if (empty($existingKeywords)) {
            return;
        }


        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $name)
            ->addViolation();
    }
}
