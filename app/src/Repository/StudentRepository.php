<?php

namespace App\Repository;

use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository des élèves
 *
 * @extends ServiceEntityRepository<Student>
 *
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    /**
     * Constructor
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    /**
     * Requête de base
     */
    public function getBaseQueryBuilder(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder("s");

        if (!empty($filters["teacher"])) {
            // Première partie : Jointure via la table Grade
            $queryBuilder->leftJoin('s.grades', 'grade')
                ->leftJoin('grade.teacher', 'teacher1');

            // Deuxième partie : Jointure via les Inscriptions et Training
            $queryBuilder->leftJoin('s.inscriptions', 'inscription')
                ->leftJoin('inscription.training', 'training')
                ->leftJoin('training.teacher', 'teacher2');

            // Assure-toi d'ajouter des conditions spécifiques si nécessaire, par exemple un ID de teacher spécifique
            $queryBuilder->where('teacher1.id = :teacherId OR teacher2.id = :teacherId')
                ->setParameter('teacherId', $filters["teacher"]->getId());
        }

        if (!empty($filters["school"])) {
            $queryBuilder
                ->leftJoin("s.grades", "g")
                ->andWhere("g.school = :school")
                ->setParameter("school", $filters["school"]);
        }

        if (!empty($filters["firstname"])) {
            $queryBuilder->andWhere("s.firstname LIKE :firstname")
                ->setParameter("firstname", '%' . $filters["firstname"] . '%');
        }

        if (!empty($filters["lastname"])) {
            $queryBuilder->andWhere("s.lastname LIKE :lastname")
                ->setParameter("lastname", '%' . $filters["lastname"] . '%');
        }

        if (!empty($filters["email"])) {
            $queryBuilder->andWhere("s.email LIKE :email")
                ->setParameter("email", '%' . $filters["email"] . '%');
        }

        return $queryBuilder;
    }

    public function getQuizByTrainingAndStudent($trainingId, $studentId)
    {
        $queryBuilder = $this->createQueryBuilder("s");
        $queryBuilder->join("s.inscriptions", "i");
        $queryBuilder->join("i.training", "t");
        $queryBuilder->join("t.quizzes", "q");
        $queryBuilder->andWhere("t.id = :trainingId")
            ->setParameter("trainingId", $trainingId);
        $queryBuilder->andWhere("s.id = :studentId")
            ->setParameter("studentId", $studentId);
        return $queryBuilder->getQuery()->getResult();
    }

    public function getQuizByTrainingAndGradeStudent($trainingId, $studentId)
    {
        $queryBuilder = $this->createQueryBuilder("s");
        $queryBuilder->join("s.grades", "g");
        $queryBuilder->join("g.inscriptions", "i");
        $queryBuilder->join("i.training", "t");
        $queryBuilder->join("t.quizzes", "q");
        $queryBuilder->andWhere("t.id = :trainingId")
            ->setParameter("trainingId", $trainingId);
        $queryBuilder->andWhere("s.id = :studentId")
            ->setParameter("studentId", $studentId);
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Recherche des élèves qui sont liés à un teacher via une classe
     *
     * @param Teacher $teacher
     */
    public function findStudentsWithGradeByTeacher(Teacher $teacher): array
    {
        return $this->createQueryBuilder("s")
            ->join("s.grades", "g")
            ->join("g.teacher", "te")
            ->where("te.id = :teacherId")
            ->setParameter("teacherId", $teacher->getId())
            ->getQuery()
            ->getResult();
    }

    /**
     * Recherche des élèves qui sont liés à un teacher via une inscription et une formation
     *
     * @param Teacher $teacher
     */
    public function findStudentsWithoutGradeByTeacher(Teacher $teacher): array
    {
        return $this->createQueryBuilder("s")
            ->join("s.inscriptions", "i")
            ->join("i.training", "t")
            ->join("t.teacher", "te")
            ->where("te.id = :teacherId")
            ->setParameter("teacherId", $teacher->getId())
            ->getQuery()
            ->getResult();
    }

    public function findStudentsByQuizAnswered($quizId)
    {
        return $this->createQueryBuilder("s")
            ->select("s")
            ->distinct()
            ->join("s.quizQuestionStudentAnswers", "qa")
            ->join("qa.quizQuestion", "qq")
            ->join("qq.quiz", "q")
            ->where("q.id = :quizId")
            ->setParameter("quizId", $quizId)
            ->getQuery()
            ->getResult();
    }

    public function isStudentInTrainingByQuiz($studentId, $quizId)
    {
        return $this->createQueryBuilder("s")
            ->join("s.inscriptions", "i")
            ->join("i.training", "t")
            ->join("t.quizzes", "q")
            ->where("s.id = :studentId")
            ->andWhere("q.id = :quizId")
            ->setParameter("studentId", $studentId)
            ->setParameter("quizId", $quizId)
            ->getQuery()
            ->getResult();
    }

    public function isGradeStudentInTrainingByQuiz($studentId, $quizId)
    {
        return $this->createQueryBuilder("s")
            ->join("s.grades", "g")
            ->join("g.inscriptions", "i")
            ->join("i.training", "t")
            ->join("t.quizzes", "q")
            ->where("s.id = :studentId")
            ->andWhere("q.id = :quizId")
            ->setParameter("studentId", $studentId)
            ->setParameter("quizId", $quizId)
            ->getQuery()
            ->getResult();
    }
}
