<?php

namespace App\Form;

use App\DTO\FilterDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use function Symfony\Component\Translation\t;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('filter1',TextType::class, [
            'empty_data' => ''
        ]
        )
        ->add('Envoyer',SubmitType::class, [
            'label'=>t('contactForm.submit')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FilterDTO::class,
        ]);
    }
}
