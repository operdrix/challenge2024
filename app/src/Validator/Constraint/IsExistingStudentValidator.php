<?php

namespace App\Validator\Constraint;

use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsExistingStudentValidator extends ConstraintValidator
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof IsExistingStudent) {
            throw new UnexpectedTypeException($constraint, IsExistingStudent::class);
        }

        // Let more pertinent constraint handle missing or blank value
        if (is_null($value) || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $student = $this->entityManager->getRepository(Student::class)->findOneBy(['email' => $value]);

        if (is_null($student)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ email }}', $value)
                ->addViolation();
        }
    }
}
