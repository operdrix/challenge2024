<?php

namespace App\Service\Interface;

use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Request;

interface FilteredListServiceInterface
{
    /**
     * Récupère la liste des éléments formatés
     */
    public function prepareFilteredList(
        Request $request,
        string $formClass,
        string $entity,
        array $filters = [],
        array $formOptions = []
    ): array;

    /**
     * Récupère la pagination
     */
    public function getPagination(
        Request $request,
        string $entity,
        array $filters
    ): PaginationInterface;
}
