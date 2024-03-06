<?php

namespace App\Controller\App\Teacher;

use App\Entity\Resource;
use App\Form\Type\ResourceFilterType;
use App\Form\Type\ResourceType;
use App\Service\FilteredListService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Écran support de cours
 */
#[Route('/teacher/resources', name: "teacher_resources_")]
class ResourceController extends AbstractController
{
    /**
     * Liste
     */
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(
        FilteredListService $filteredListService,
        Request $request
    ): Response
    {
        $filters = [
            "teacher" => $this->getUser()
        ];

        [$pagination, $form] = $filteredListService->prepareFilteredList(
            $request,
            ResourceFilterType::class,
            Resource::class,
            $filters
        );

        return $this->render('teacher/resource/index.html.twig', [
            'pagination' => $pagination,
            "form" => $form
        ]);
    }

    /**
     * Formulaire
     */
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $em, ?Resource $resource = null): Response
    {
        if (empty($resource)) {
            $resource = new Resource();
        }
        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($resource);
            $em->flush();

            return $this->redirectToRoute('teacher_resources_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teacher/resource/edit.html.twig', [
            'resource' => $resource,
            'form' => $form,
        ]);
    }

    /**
     * Suppression
     */
    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Resource $resource, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resource->getId(), $request->request->get('_token'))) {
            $em->remove($resource);
            $em->flush();
        }

        return $this->redirectToRoute('teacher_resources_index', [], Response::HTTP_SEE_OTHER);
    }
}
