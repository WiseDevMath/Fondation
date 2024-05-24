<?php

namespace App\Form;

use App\Entity\Appfunction;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use function Symfony\Component\Translation\t;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AppfunctionType extends AbstractType
{
    public function __construct(private FormListenerFactory $listenerFactory,private TranslatorInterface $translator )
    {
        
    }   
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('appsubfunctions', CollectionType::class, [
                'entry_type' => AppsubfunctionType::class,
                'label'=>false,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => [
                    'label'=> false
                ]
            ])
            ->addEventListener(FormEvents::POST_SUBMIT,$this->listenerFactory->timestamps())
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
                'placeholder' => t('Select an icon'), // Optionnel, affiche un texte par défaut
                'required' => true,
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appfunction::class,
        ]);
    }
}
