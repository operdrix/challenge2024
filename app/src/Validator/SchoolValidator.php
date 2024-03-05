<?php

namespace App\Validator;

use App\Entity\School;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use UnexpectedValueException;

class SchoolValidator extends ConstraintValidator
{
    /**
     * @param School $school
     */
    public function validate($school, Constraint $constraint)
    {
        $form = $this->context->getObject();
        dd($form);
        if (!$school instanceof School) {
            throw new UnexpectedValueException($school, School::class);
        }

        /**
         * Au moins un moyen de contact
         */
        if (is_null($school->getEmail()) && is_null($school)) {
            $this->context
                ->buildViolation("Vous devez renseigner au moins une méthode de contact")
                ->atPath('school.email')
                ->addViolation();

            $this->context
                ->buildViolation("Vous devez renseigner au moins une méthode de contact")
                ->atPath('school.phoneNumber')
                ->addViolation();
        }

        /**
         * Si l'école n'a pas de logo et qu'il n'y en a pas un de soumis
         */
        if (is_null($school->getLogoFilename()) && is_null($form->get('logo')->getData())) {
            $this->context
                ->buildViolation("Veuillez téléverser un logo")
                ->atPath('school.logo')
                ->addViolation();
        }
    }
}
