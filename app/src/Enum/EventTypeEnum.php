<?php

namespace App\Enum;

enum EventTypeEnum: string
{
    case LOGOUT = "Déconnexion";
    case LOGIN = "Connexion";
    case MOUSEOUT = "Souris sortie";
    case MOUSEIN = "Souris entrée";
}
