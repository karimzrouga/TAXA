<?php

namespace App\Controller\Admin;

use App\Entity\Adventure;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdventureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adventure::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('titre'),
            TextField::new('description'),
            ImageField::new('image')
            ->setBasePath('/img')
            ->setUploadDir('public/img'),
            TextField::new('prix'),
            DateField::new('date'),
            AssociationField :: new('destination'),
        ];
    }
}
