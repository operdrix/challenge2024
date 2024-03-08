<?php

namespace App\Enum;

enum ResourceTypeEnum: string
{
    case PDF = "PDF";
    case VIDEO = "Vidéo";
    case SLIDE = "Diapositive";
    case LINK = "Lien";
    case IMAGE = "Image";
    case OTHER = "Autre";
}
