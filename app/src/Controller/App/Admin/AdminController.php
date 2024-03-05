<?php

namespace App\Controller\App\Admin;

use App\Entity\Admin;
use App\Form\Type\AdminFilterType;
use App\Form\Type\AdminType;
use App\Service\FilteredListService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Écran administrateur
 */
#[Route('/admin/administrators', name: "admin_administrators_")]
class AdminController extends AbstractController
{
    /**
     * Liste
     */
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(
        FilteredListService $filteredListService,
        Request                $request
    ): Response
    {
        [$pagination, $form] = $filteredListService->prepareFilteredList(
            $request,
            AdminFilterType::class,
            Admin::class
        );

        return $this->render(
            'admin/administrator/index.html.twig',
            [
                'pagination' => $pagination,
                "form" => $form
            ]
        );
    }

    /**
     * Édition
     */
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        ?Admin $admin = null
    ): Response
    {
        $formOptions = [];
        if (empty($admin)) {
            $admin = new Admin();
            $formOptions["validation_groups"] = [
                "Default",
                "user_new"
            ];
        }

        $form = $this->createForm(AdminType::class, $admin, $formOptions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($admin->getPlainPassword())) {
                $admin->setPassword($passwordHasher->hashPassword($admin, $admin->getPlainPassword()));
                $admin->eraseCredentials();
            }

            $entityManager->persist($admin);
            $entityManager->flush();

            return $this->redirectToRoute('admin_administrators_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/administrator/edit.html.twig', [
            'admin' => $admin,
            'form' => $form,
        ]);
    }

    /**
     * Suppression
     */
    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Admin $admin, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $admin->getId(), $request->request->get('_token'))) {
            $entityManager->remove($admin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_administrators_index', [], Response::HTTP_SEE_OTHER);
    }
}
