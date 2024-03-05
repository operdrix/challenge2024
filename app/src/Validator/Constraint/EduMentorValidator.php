<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class EduMentorPasswordValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof EduMentorPassword) {
            throw new UnexpectedTypeException($constraint, EduMentorPassword::class);
        }

        if (is_null($value) || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        /**
         * Règles de sécurité concernant les mots de passes sur la plateforme EduMentor
         * - Min length: 8
         * - Max length: 255
         * - Contains an Uppercase letter
         * - Contains an alphanumerical char
         * - Contains a symbol char
         */
        if (strlen($value) < 8) {
            $this->context
                ->buildViolation('Votre mot de passe doit contenir au minimum 8 caractères')
                ->addViolation();
        }

        if (strlen($value) > 255) {
            $this->context
                ->buildViolation('Votre mot de passe ne peut pas dépasser 255 caractères')
                ->addViolation();
        }

        if (!preg_match('/[A-Z]/', $value)) {
            $this->context
                ->buildViolation('Votre mot de passe doit contenir au moins une lettre majuscule')
                ->addViolation();
        }

        if (!preg_match('/\d/', $value)) {
            $this->context
                ->buildViolation('Votre mot de passe doit contenir au moins un chiffre')
                ->addViolation();
        }

        if (!preg_match('/[^a-zA-Z\d]/', $value)) {
            $this->context
                ->buildViolation('Votre mot de passe doit contenir au moins un symbole')
                ->addViolation();
        }
    }
}
