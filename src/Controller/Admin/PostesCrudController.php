<?php

namespace App\Controller\Admin;

use App\Entity\Postes;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Postes::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField :: new('user')->onlyOnIndex(),
            TextField::new('description'),
            ImageField::new('image')
            ->setBasePath('/img')
            ->setUploadDir('public/img')
            ,
            DateField::new('date')->onlyOnIndex(),
        ];
    }
    
}
