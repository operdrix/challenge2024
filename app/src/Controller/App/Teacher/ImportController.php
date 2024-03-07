<?php

namespace App\Controller\App\Teacher;

use App\Form\Type\ImportType;
use App\Service\Interface\ImportServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\School;

#[IsGranted('ROLE_TEACHER')]
class ImportController extends AbstractController
{
    #[Route('/import', name: 'app_import')]
    public function index(
        Request $request,
        ImportServiceInterface $importService
    ): Response {
        $form = $this->createForm(ImportType::class, [], ['teacher' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form->get('uploadedFile')->getData();
            /** @var School $school */
            $school = $form->get('school')->getData();

            $grade = $importService->importCSV(
                $uploadedFile,
                $this->getUser(),
                $school
            );

            dump($grade);

            return $this->redirectToRoute('teacher_grades_show', [
                'id' => $grade->getId(),
                'school_id' => $school->getId()
            ]);
        }

        return $this->render('import/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/import/dummy', name: 'app_import_dummy', methods: ['GET'])]
    public function dummy(): Response
    {
        dump($this->getParameter('kernel.project_dir') . '/public/dummy.csv');
        return $this->file(
            $this->getParameter('kernel.project_dir') . '/public/dummy.csv'
        );
    }
}
