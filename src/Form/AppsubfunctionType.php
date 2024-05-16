<?php

namespace App\Form;

use App\Entity\Appfunction;
use App\Entity\Appsubfunction;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AppsubfunctionType extends AbstractType
{

    public function __construct(private FormListenerFactory $listenerFactory)
    {
        
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
            ])
            ->add('description',TextType::class, [
                'required'=> false,
                'attr' => [
                ]
            ])
            ->addEventListener(FormEvents::POST_SUBMIT,$this->listenerFactory->autoSlug('name'))
            ->addEventListener(FormEvents::POST_SUBMIT,$this->listenerFactory->timestamps())
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appsubfunction::class,
        ]);
    }
}
