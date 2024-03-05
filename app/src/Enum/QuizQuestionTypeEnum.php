<?php

namespace App\Enum;

enum QuizQuestionTypeEnum: string
{
    case YESNO = "Vrai/Faux";
    case MULTIPLE = "Choix multiple";
    case UNIQUE = "Choix unique";
//    case UPLOAD = "Téléchargement";
}
