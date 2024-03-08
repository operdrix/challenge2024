<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Entité administrateurs
 */
#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[UniqueEntity("email")]
class Admin extends AbstractUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Roles
     */
    #[ORM\Column(type: Types::JSON)]
    protected array $roles = ["ROLE_ADMIN"];

    /********************************/
    /* AUTO GENERATED CONTENT BELOW */
    /********************************/

    public function getId(): ?int
    {
        return $this->id;
    }
}
