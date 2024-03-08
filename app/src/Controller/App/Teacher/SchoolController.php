<?php

namespace App\Controller\App\Teacher;

use App\Constant\AppConstant;
use App\Entity\Grade;
use App\Entity\School;
use App\Entity\Student;
use App\Form\Type\GradeFilterType;
use App\Form\Type\SchoolFilterType;
use App\Form\Type\SchoolType;
use App\Form\Type\StudentFilterType;
use App\Service\Interface\FileServiceInterface;
use App\Service\Interface\FilteredListServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/teacher/schools', name: 'teacher_schools_')]
#[IsGranted("ROLE_TEACHER")]
class SchoolController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(
        FilteredListServiceInterface $filteredListService,
        Request $request
    ): Response {
        $filters = [
            "teacher" => $this->getUser()
        ];

        [$pagination, $form] = $filteredListService->prepareFilteredList(
            $request,
            SchoolFilterType::class,
            School::class,
            $filters
        );

        return $this->render('teacher/school/index.html.twig', [
            "pagination" => $pagination,
            "form" => $form
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    #[IsGranted('edit', 'school')]
    public function edit(
        Request $request,
        ?School $school,
        EntityManagerInterface $entityManager,
        FileServiceInterface $fileService
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

            return $this->redirectToRoute('teacher_schools_show', ['id' => $school->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teacher/school/edit.html.twig', [
            'school' => $school,
            'form' => $form,
        ]);
    }

    #[Route("/{id}/show", name: "show", methods: ["GET"])]
    public function show(
        School              $school,
        FilteredListServiceInterface $filteredListService,
        Request             $request
    ) {
        $filtersGrade = [
            "teacher" => $this->getUser(),
            "school" => $school
        ];

        [$paginationGrade, $formGrade] = $filteredListService->prepareFilteredList(
            $request,
            GradeFilterType::class,
            Grade::class,
            $filtersGrade
        );

        $filtersStudent = [
            "school" => $school,
        ];

        [$paginationStudent, $formStudent] = $filteredListService->prepareFilteredList(
            $request,
            StudentFilterType::class,
            Student::class,
            $filtersStudent
        );

        return $this->render('teacher/school/show.html.twig', [
            'school' => $school,
            "paginationGrade" => $paginationGrade,
            "formGrade" => $formGrade,
            "paginationStudent" => $paginationStudent,
            "formStudent" => $formStudent
        ]);
    }
}
