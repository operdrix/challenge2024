<?php

namespace App\Controller\App\Student;

use App\Entity\Student;
use App\Form\Type\StudentRegisterFirstStepType;
use App\Form\Type\StudentRegisterLastStepType;
use App\Service\Interface\StudentServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/student/register/', name: 'student_register_')]
#[IsGranted('PUBLIC_ACCESS')]
class StudentRegisterController extends AbstractController
{
    #[Route('first-step', name: 'first_step', methods: ['GET', 'POST'])]
    public function firstStep(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(StudentRegisterFirstStepType::class, null, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $student = $entityManager->getRepository(Student::class)->findOneBy(['email' => $email]);

            return $this->redirectToRoute(
                'app_student_register_last_step',
                ['id' => $student->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->render('student/student_register/first_step.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('last-step/{id}', name: 'last_step', methods: ['GET', 'POST'])]
    public function lastStep(
        Request $request,
        Student $student,
        UserPasswordHasherInterface $hasher,
        Security $security,
        StudentServiceInterface $studentService,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(StudentRegisterLastStepType::class, $student, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $student->setPassword($hasher->hashPassword(
                $student,
                $student->getPlainPassword()
            ));
            $student->eraseCredentials();

            $entityManager->flush();

            // Génération de message pour chaque inscription / classe reliée
            $messages = $studentService->generateRegistrationFlashMessages($student);
            foreach ($messages as $level => $value) {
                $this->addFlash($level, $value);
            }

            $security->login($student);

            return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student/student_register/last_step.html.twig', [
            'form' => $form,
            'student' => $student
        ]);
    }
}
