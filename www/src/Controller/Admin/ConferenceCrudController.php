<?php

namespace App\Controller\Admin;

use App\Entity\Conference;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DomCrawler\Field\ChoiceFormField;

class ConferenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Conference::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            FormField::addPanel('Details'),
            TextField::new('name')->setLabel('Nom de la conférence'),
            TextField::new('location')->setLabel('Emplacement'),
            TextField::new('author')->setLabel('Auteur'),
            TextField::new('speakers')->setLabel('Intervenant(s)'),
            AssociationField::new('establishment'),

            // IntegerField::new('establishment', 'Etablissement'),
            AssociationField::new('establishment', 'Etablissement'),
            IntegerField::new('likes')->setValue(0),
            DateTimeField::new('date', 'Date de la conférence'),

            FormField::addPanel('Description'),
            TextEditorField::new('extract'),
            TextEditorField::new('description'),
        ];
    }
}
