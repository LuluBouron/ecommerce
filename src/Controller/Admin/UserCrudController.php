<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Component\Form\FormEvents;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Form\FormBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        public UserPasswordHasherInterface $userPasswordHasher
    ) {}

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions{
        return $actions 
    
        ->add(Crud::PAGE_EDIT, Action::INDEX) // -> permet de revenir à la page index depuis la page edit d'un user
        ->add(Crud::PAGE_INDEX, Action::DETAIL)// -> permet de pouvoir voir le détail d'un user depuis la page index
        ->add(Crud::PAGE_EDIT, Action::DETAIL) // -> permet de pouvoir voir le détail d'un user depuis la page edit
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('full_name'),
            ChoiceField::new('civility')->setChoices([
                'Monsieur' => 'Mr',
                'Madame' => 'Mme',
                'Mademoiselle' => 'Mlle',
            ]),
            EmailField::new('email'),
            TextField::new('password')
                ->setFormType(RepeatedType::class)
                ->setFormTypeOptions([ 
                    'type' => PasswordType::class,
                    'first_options' => [
                        'label' => 'Password',
                        'row_attr' => [
                            'class' => "col-md-6 col-xxl-5"

                        ],
                    ],
                    'second_options' => [
                        'label' => 'Confirm Password',
                        'row_attr' => [
                            'class' => "col-md-6 col-xxl-5"

                        ],
                    ],
                    'mapped' => false,
                    // ne pas mapper les infos du mot de passe direct)
                ])
                ->setRequired($pageName === Crud::PAGE_NEW)
                // est ce qu'on est sur la page de création ? alors mot de passe requis
                ->onlyOnForms()
                //->hideWhenUpdating()
                ->hideOnIndex(),

            
        ];
    }
    
    // déclancher automatiquement quand on va cliquer sur "Create"
    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);
        return $this->addPasswordEventListener($formBuilder);
    }

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);
        return $this->addPasswordEventListener($formBuilder);
    }

    // ajoute un évenemnt sous le formBuilder 
    public function addPasswordEventListener(FormBuilderInterface $formBuilder) {
        return $formBuilder->addEventListener(FormEvents::POST_SUBMIT, $this->hashPassword());

    }

    public function hashPassword(){
        return function($event){
            $form = $event->getForm();
            if(!$form->isValid()){
                return;
            }

            $password = $form->get('password')->getData();

            if($password === null){
                return;
            }

            $hash = $this->userPasswordHasher->hashPassword($this->getUser(), $password);
            $form->getData()->setPassword($hash);
        };
    }
}

