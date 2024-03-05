<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class School extends Constraint
{
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
