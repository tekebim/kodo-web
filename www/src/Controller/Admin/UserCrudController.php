<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    /*
    public function createEntity(string $entityFqcn)
    {
        $entity = new User();
        $entity->setRoles(['ROLE_CONTRIBUTOR']);
        return $entity;
    }
    */


    public function configureFields(string $pageName): iterable
    {
        yield Field::new('id')->hideOnForm();
        yield Field::new('name');
        yield ChoiceField::new('roles', 'Rôles')->setChoices(['administrateur' => 'ROLE_ADMIN', 'contributeur' => 'ROLE_CONTRIBUTOR'])->allowMultipleChoices();
        yield Field::new('email');
        yield AssociationField::new('establishment', 'Établissement');
        yield Field::new('password')
            ->onlyWhenCreating()
            ->hideOnIndex();
    }

}
