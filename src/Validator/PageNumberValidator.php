<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PageNumberValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\PageNumber */

        if (null === $value || '' === $value) {
            return;
        }

        if (is_int($value) && 0 < $value) {
            return;
        }

        if (is_string($value) && ctype_digit($value)) {
            $value = intval($value);
            if (0 < $value) {
                return;
            }
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
