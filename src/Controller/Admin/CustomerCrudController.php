<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CustomerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }

    public function configureCrud(\EasyCorp\Bundle\EasyAdminBundle\Config\Crud $crud): \EasyCorp\Bundle\EasyAdminBundle\Config\Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Clients')
            ->setEntityLabelInPlural('Clients')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestion des clients')
            ->setPageTitle(Crud::PAGE_NEW, 'Créer un client')
            ->setSearchFields(['fullName', 'user.email']);
    }


    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id', 'Id')->onlyOnIndex();


        yield TextField::new('fullName', 'Client');
        yield  EmailField::new('email', 'Adresse email');
        yield TextField::new('company', 'Entreprise');


        yield TextField::new('user.fullName', 'Utilisateur')->onlyOnIndex();


        yield AssociationField::new('user', 'utilisateur')
            ->setFormTypeOption('choice_label', 'fullName')
            ->onlyOnForms();
    }
}
