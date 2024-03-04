<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(targetEntity: Training::class, mappedBy: 'teacher')]
    private Collection $trainings;

    #[ORM\OneToMany(targetEntity: TrainingCategory::class, mappedBy: 'teacher')]
    private Collection $trainingCategories;

    #[ORM\OneToMany(targetEntity: Grade::class, mappedBy: 'teacher')]
    private Collection $grades;

    #[ORM\OneToMany(targetEntity: School::class, mappedBy: 'teacher')]
    private Collection $schools;

    public function __construct()
    {
        $this->trainings = new ArrayCollection();
        $this->trainingCategories = new ArrayCollection();
        $this->grades = new ArrayCollection();
        $this->schools = new ArrayCollection();
    }

    /********************************/
    /* AUTO GENERATED CONTENT BELOW */
    /********************************/

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Training>
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function addTraining(Training $training): static
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings->add($training);
            $training->setTeacher($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): static
    {
        if ($this->trainings->removeElement($training)) {
            // set the owning side to null (unless already changed)
            if ($training->getTeacher() === $this) {
                $training->setTeacher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TrainingCategory>
     */
    public function getTrainingCategories(): Collection
    {
        return $this->trainingCategories;
    }

    public function addTrainingCategory(TrainingCategory $trainingCategory): static
    {
        if (!$this->trainingCategories->contains($trainingCategory)) {
            $this->trainingCategories->add($trainingCategory);
            $trainingCategory->setTeacher($this);
        }

        return $this;
    }

    public function removeTrainingCategory(TrainingCategory $trainingCategory): static
    {
        if ($this->trainingCategories->removeElement($trainingCategory)) {
            // set the owning side to null (unless already changed)
            if ($trainingCategory->getTeacher() === $this) {
                $trainingCategory->setTeacher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Grade>
     */
    public function getGrades(): Collection
    {
        return $this->grades;
    }

    public function addGrade(Grade $grade): static
    {
        if (!$this->grades->contains($grade)) {
            $this->grades->add($grade);
            $grade->setTeacher($this);
        }

        return $this;
    }

    public function removeGrade(Grade $grade): static
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getTeacher() === $this) {
                $grade->setTeacher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, School>
     */
    public function getSchools(): Collection
    {
        return $this->schools;
    }

    public function addSchool(School $school): static
    {
        if (!$this->schools->contains($school)) {
            $this->schools->add($school);
            $school->setTeacher($this);
        }

        return $this;
    }

    public function removeSchool(School $school): static
    {
        if ($this->schools->removeElement($school)) {
            // set the owning side to null (unless already changed)
            if ($school->getTeacher() === $this) {
                $school->setTeacher(null);
            }
        }

        return $this;
    }
}
