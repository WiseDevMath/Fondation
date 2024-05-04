<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\PasswordStrength;
use Symfony\Contracts\Translation\TranslatorInterface;

use function Symfony\Component\Translation\t;

class ChangePasswordFormType extends AbstractType
{
    
    public function __construct(private TranslatorInterface $translator)
    {
    }

    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ],
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => $this->translator->trans('enterPassword', []),
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => $this->translator->trans('minLengthPassword1', []). ' {{ limit }} '.$this->translator->trans('minLengthPassword2', []),
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                        //new PasswordStrength(),
                        //new NotCompromisedPassword(),
                    ],
                    'label' => t('New password'),
                    'toggle' => true,
                    'hidden_label' => t('toogle_hidden_label'),
                    'visible_label' => t('toogle_visible_label'),
                ],
                'second_options' => [
                    'label' => t('Repeat Password'),
                    'toggle' => true,
                    'hidden_label' => t('toogle_hidden_label'),
                    'visible_label' => t('toogle_visible_label'),
                ],
                'invalid_message' =>  $this->translator->trans('passwordsMustMatch', []) ,
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
