<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin extends AbstractUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

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
