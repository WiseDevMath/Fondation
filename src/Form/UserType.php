<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Profile;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use function Symfony\Component\Translation\t;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{

    public function __construct(private FormListenerFactory $listenerFactory)
    {
        
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            /*->add('profile',EntityType::class, [
            'class' => Profile::class,
            'choice_label' => 'name'
            // pour faire des radios buttons 'expanded'=> true,
            ])*/
            ->add('username')
            ->add('email')
            ->add('thumbnailFile',FileType:: class, [
                'label'=>t('profilPhoto'),
                'required'=>false
            ])
            ->add('Save',SubmitType::class, [
                'label' => t('Save'),
                'attr'=> [
                    'class'=>'button-corail ',
                    'style'=>'margin-top:10px;'
                ]])
            ->addEventListener(FormEvents::POST_SUBMIT,$this->listenerFactory->timestamps())

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
