<?php

namespace App\Controller\App\Teacher;

use App\Constant\AppConstant;
use App\Entity\School;
use App\Form\Type\SchoolType;
use App\Repository\SchoolRepository;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/teacher/school', name: 'teacher_school_')]
#[IsGranted("ROLE_TEACHER")]
class SchoolController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(SchoolRepository $schoolRepository): Response
    {
        return $this->render('teacher/school/index.html.twig', [
            'schools' => $schoolRepository->findBy(['teacher' => $this->getUser()]),
        ]);
    }

    #[Route('/{id}/show', name: 'show', methods: ['GET'])]
    #[IsGranted('view', 'school')]
    public function show(School $school): Response
    {
        return $this->render('school/show.html.twig', [
            'school' => $school,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    #[IsGranted('edit', 'school')]
    public function edit(
        Request $request,
        ?School $school,
        EntityManagerInterface $entityManager,
        FileService $fileService
    ): Response {
        if (is_null($school)) {
            $school = new School();
        }

        $school->setTeacher($this->getUser());

        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logo = $form->get('logo')->getData();

            // Téléversement du logo 
            if ($logo) {
                $logoFilename = $fileService->upload(
                    $logo,
                    $this->getParameter(AppConstant::DIRECTORY_SCHOOL),
                    $school->getLogoFilename()
                );

                $school->setLogoFilename($logoFilename);
            }

            $entityManager->persist($school);
            $entityManager->flush();

            $this->addFlash('success', 'L\'organisme ' . $school->getName() . ' est enregistré avec succès');

            return $this->redirectToRoute('school_show', ['id' => $school->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teacher/school/edit.html.twig', [
            'school' => $school,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    #[IsGranted('delete', 'school')]
    public function delete(
        Request $request,
        School $school,
        EntityManagerInterface $entityManager,
        FileService $fileService
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $school->getId(), $request->request->get('_token'))) {
            // Supprimer le logo des fichiers de l'application 
            $fileService->remove($school->getLogoFilename(), AppConstant::DIRECTORY_SCHOOL);

            $entityManager->remove($school);
            $entityManager->flush();
        }

        return $this->redirectToRoute('school_index', [], Response::HTTP_SEE_OTHER);
    }
}
