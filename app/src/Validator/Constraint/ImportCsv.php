<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class ImportCsv extends Constraint
{
    public string $message = 'Votre fichier CSV ne correspond pas aux attentes de la plateforme';
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
