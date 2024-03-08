<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class IsExistingStudent extends Constraint
{
    public string $message = 'Votre email {{ email }} n\'est pas affiliée à un compte existant';
    public string $mode = 'strict';

    public function __construct(
        string $mode = null,
        string $message = null,
        array $groups = null,
        $payload = null
    ) {
        parent::__construct([], $groups, $payload);

        $this->mode = $mode ?? $this->mode;
        $this->message = $message ?? $this->message;
    }

    public function validatedBy()
    {
        return static::class . 'Validator';
    }
}
