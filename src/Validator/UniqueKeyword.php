<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueKeyword extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'The name "{{ value }}" should be unique in database.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
