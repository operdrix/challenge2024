<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Prof
 */
#[ORM\Entity(repositoryClass: TeacherRepository::class)]
class Teacher extends AbstractUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::JSON)]
    protected array $roles = ["ROLE_TEACHER"];

    /********************************/
    /* AUTO GENERATED CONTENT BELOW */
    /********************************/

    public function getId(): ?int
    {
        return $this->id;
    }
}
