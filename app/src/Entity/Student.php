<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Élève
 */
#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student extends AbstractUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::JSON)]
    protected array $roles = ["ROLE_STUDENT"];

    /********************************/
    /* AUTO GENERATED CONTENT BELOW */
    /********************************/

    public function getId(): ?int
    {
        return $this->id;
    }
}
