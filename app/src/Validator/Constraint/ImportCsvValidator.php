<?php

namespace App\Validator\Constraint;

use DateTime;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ImportCsvValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof ImportCsv) {
            throw new UnexpectedTypeException($constraint, ImportCsv::class);
        }

        if (is_null($value) || '' === $value) {
            return;
        }

        if (!$value instanceof UploadedFile) {
            throw new UnexpectedValueException($value, UploadedFile::class);
        }

        if (($handle = fopen($value->getPathname(), 'r')) !== false) {
            $isFirst = true;
            $index = 1;

            while (($data = fgetcsv($handle)) !== false) {
                // Validate header row data
                if ($isFirst) {
                    if (empty($data)) {
                        $this->context
                            ->buildViolation('La ligne devant comporter le nom de la classe n\'est pa renseigné')
                            ->addViolation();
                    }

                    if (sizeof($data) > 1) {
                        $this->context
                            ->buildViolation('La ligne devant comporter le nom de la classe comporte trop de données')
                            ->addViolation();
                    }

                    if (is_null($data[0]) || $data[0] === '') {
                        $this->context
                            ->buildViolation('La ligne devant comporter le nom de la classe est vide')
                            ->addViolation();
                    }

                    $isFirst = false;
                    continue;
                }

                // Validate student row data
                if (sizeof($data) < 6) {
                    $this->context
                        ->buildViolation('La ligne pour l\'étudiant ' . $index . ' ne comporte pas assez de données')
                        ->addViolation();
                }

                if (sizeof($data) > 6) {
                    $this->context
                        ->buildViolation('La ligne pour l\'étudiant ' . $index . ' ne comporte trop de données')
                        ->addViolation();
                }

                if (sizeof($data) == 6) {
                    if (!DateTime::createFromFormat('d/m/Y', $data[3])) {
                        $this->context
                            ->buildViolation('La date de naissance pour l\'étudiant ' . $index . ' ne répond pas au format jour/mois/année')
                            ->addViolation();
                    }
                }

                $index++;
            }
        }
    }
}
