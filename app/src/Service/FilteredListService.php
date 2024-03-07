<?php

namespace App\Service;

use App\Service\Interface\FilteredListServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Service de préparation des listes filtrées
 */
class FilteredListService implements FilteredListServiceInterface
{
    /**
     * Constructor
     */
    public function __construct(
        private readonly FormFactoryInterface $formFactory,
        private readonly PaginatorInterface $paginator,
        private readonly EntityManagerInterface $em,
    ) {
    }

    /**
     * Recupère la liste des éléments formatés
     */
    public function prepareFilteredList(
        Request $request,
        string $formClass,
        string $entity,
        array $filters = [],
        array $formOptions = []
    ): array {
        $form = $this->formFactory->create($formClass, $filters, $formOptions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filters = $form->getData();
        }

        $pagination = $this->getPagination($request, $entity, $filters);

        return [
            $pagination,
            $form,
        ];
    }

    /**
     * Récupère la pagination
     */
    public function getPagination(Request $request, string $entity, array $filters): PaginationInterface
    {
        $queryBuilder = $this->em->getRepository($entity)->getBaseQueryBuilder($filters);

        return $this->paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt("page", 1),
            20
        );
    }
}
