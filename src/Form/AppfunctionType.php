<?php

namespace App\Form;

use App\Entity\Appfunction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use function Symfony\Component\Translation\t;

class AppfunctionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('icon', ChoiceType::class, [
                'choices' => [
                    'Gear Fill' => 'gear-fill',
                    'Columns' => 'columns',
                    'Currency Exchange' => 'currency-exchange',
                    'Book Fill' => 'book-fill',
                    'Bug Fill' => 'bug-fill',
                    'Check2 Square' => 'check2-square',
                    'Chevron Bar Contract' => 'chevron-bar-contract',
                    'Chevron Bar Down' => 'chevron-bar-down',
                    'Chevron Bar Expand' => 'chevron-bar-expand',
                    'Chevron Bar Left' => 'chevron-bar-left',
                    'Chevron Bar Right' => 'chevron-bar-right',
                    'Chevron Bar Up' => 'chevron-bar-up',
                    'Chevron Compact Down' => 'chevron-compact-down',
                    'Chevron Compact Left' => 'chevron-compact-left',
                    'Chevron Compact Right' => 'chevron-compact-right',
                    'Chevron Compact Up' => 'chevron-compact-up',
                    'Chevron Contract' => 'chevron-contract',
                    'Chevron Double Down' => 'chevron-double-down',
                    'Chevron Double Left' => 'chevron-double-left',
                    'Chevron Double Right' => 'chevron-double-right',
                    'Chevron Double Up' => 'chevron-double-up',
                    'Chevron Down' => 'chevron-down',
                    'Chevron Expand' => 'chevron-expand',
                    'Chevron Left' => 'chevron-left',
                    'Cloud Arrow Up' => 'cloud-arrow-up',
                    'Exclamation Triangle' => 'exclamation-triangle',
                    'Exclamation Triangle Fill' => 'exclamation-triangle-fill',
                    'Exclude' => 'exclude',
                    'Eye' => 'eye',
                    'Eye Fill' => 'eye-fill',
                    'File Fill' => 'file-fill',
                    'File Font' => 'file-font',
                    'Gear Wide' => 'gear-wide',
                    'Gear Wide Connected' => 'gear-wide-connected',
                    'Hr' => 'hr',
                    'Hr Fill' => 'hr-fill',
                    'Image' => 'image',
                    'Image Alt' => 'image-alt',
                    'Image Fill' => 'image-fill',
                    'Images' => 'images',
                    'Images Alt' => 'images-alt',
                    'Images Alt' => 'images-alt',
                    'Journal X' => 'journal-x',
                    'Journal' => 'journal',
                    'Journal Arrow Down' => 'journal-arrow-down',
                    'Journal Arrow Up' => 'journal-arrow-up',
                    'Journal Bookmark' => 'journal-bookmark',                    
                ],
                'placeholder' => 'Sélectionner une icône', // Optionnel, affiche un texte par défaut
                'required' => true,
                'label' => false
            ])
            ->add('Save',SubmitType::class, [
                'label' => t('Save'),
                'attr'=> [
                    'class'=>'button-corail ',
                    'style'=>'margin-top:10px;'
                ]])
            ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appfunction::class,
        ]);
    }
}
