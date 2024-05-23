<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Profile;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use function Symfony\Component\Translation\t;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AdminUserType extends AbstractType
{

    public function __construct(private FormListenerFactory $listenerFactory)
    {
        
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('profile',EntityType::class, [
                'class' => Profile::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->where('p.isSuperadmin = 0');
                },
                // pour faire des radios buttons 'expanded'=> true,
            ])
            ->add('verified', CheckboxType::class, [
                'required' => false, // Le champ n'est pas obligatoire
                'mapped' => true, // Ne mappe pas directement au champ de l'entité
            ])
            ->add('Save',SubmitType::class, ['label' => t('Save')])
            ->addEventListener(FormEvents::POST_SUBMIT,$this->listenerFactory->timestamps())        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
