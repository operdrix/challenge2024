<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class EduMentorPassword extends Constraint
{
    public string $message = 'Votre mot de passe ne répond pas aux exigences de sécurité';
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
