<?php

namespace App\Enum;

enum DifficultyEnum: string
{
    case BEGINER = "Débutant";
    case INTERMEDIATE = "Intermédiaire";
    case ADVANCED = "Avancé";
    case EXPERT = "Expert";
    case MATHIS = "Dieu";
}
