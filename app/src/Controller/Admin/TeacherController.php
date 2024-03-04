<?php

namespace App\Controller\Admin;

use App\Entity\Teacher;
use App\Form\Type\TeacherType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/teachers', name: "admin_teachers_")]
class TeacherController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(
        EntityManagerInterface $em,
        PaginatorInterface     $paginator,
        Request                $request,
    ): Response
    {
        $query = $em->getRepository(Teacher::class)->getBaseQueryBuilder();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        return $this->render('admin/teacher/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request                     $request,
        EntityManagerInterface      $em,
        UserPasswordHasherInterface $passwordHasher,
        ?Teacher                    $teacher = null
    ): Response
    {
        $formOptions = [];
        if (empty($teacher)) {
            $teacher = new Teacher();
            $formOptions["validation_groups"] = [
                "Default",
                "user_new"
            ];
        }
        $form = $this->createForm(TeacherType::class, $teacher, $formOptions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($teacher->getPlainPassword())) {
                $teacher->setPassword($passwordHasher->hashPassword($teacher, $teacher->getPlainPassword()));
                $teacher->eraseCredentials();
            }

            $em->persist($teacher);
            $em->flush();

            return $this->redirectToRoute('admin_teachers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/teacher/edit.html.twig', [
            'teacher' => $teacher,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Teacher $teacher, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $teacher->getId(), $request->request->get('_token'))) {
            $em->remove($teacher);
            $em->flush();
        }

        return $this->redirectToRoute('admin_teachers_index', [], Response::HTTP_SEE_OTHER);
    }
}
