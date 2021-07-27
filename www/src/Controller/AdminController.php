<?php
namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;

class AdminController extends EasyAdminController
{
    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        if (null === $dqlFilter) {
            $dqlFilter = sprintf('entity.user = %s', $this->getUser()->getId());
        } else {
            $dqlFilter .= sprintf(' AND entity.user = %s', $this->getUser()->getId());
        }

        return parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);
    }
}
