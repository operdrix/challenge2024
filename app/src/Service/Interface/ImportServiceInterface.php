<?php

namespace App\Service\Interface;

use App\Entity\Grade;
use App\Entity\School;
use App\Entity\Teacher;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImportServiceInterface
{
    /**
     * Gère l'import CSV d'une nouvelle classe liée à un organisme de formation existant
     * 
     * Renvoie la classe nouvellement créée
     */
    public function importCSV(UploadedFile $file, Teacher $teacher, School $school): Grade;
}
