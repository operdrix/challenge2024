<?php

namespace App\Enum;

enum MailTypeEnum
{
        // Inscription à l'application
    case STUDENT_REGISTER;
        // Inscription à un cour individuel
    case STUDENT_INSCRIPTION;
        // Inscription à un cour via une classe
    case GRADE_INSCRIPTION;
        // Convocation à un quiz
    case STUDENT_QUIZ;
}
