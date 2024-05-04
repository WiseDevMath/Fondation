<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Security\EmailVerifier;
use App\Security\AppAuthenticator;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{

    public function __construct(private EmailVerifier $emailVerifier)
    {
    }

    #[Route('/profil', name: 'profil')]    
    /**
     * @var user
     */
    public function profil(Request $request, EntityManagerInterface $em, Security $security, TranslatorInterface $translator )
    {
        $user=$security->getUser();
        $email=$user->getEmail();
        $form = $this->createForm(UserType::class, $user);
        $form = $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {

            if ($user->getEmail()!=$email)  {

                // generate a signed url and email it to the user
                $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('contact@wisedev.fr', 'Contact Wisedev'))
                    ->to($user->getEmail())
                    ->subject($translator->trans('mailConfirmSubject', []))
                    ->htmlTemplate('registration/confirmation_email.html.twig')
                );

            // do anything else you need here, like send an email

            $user->setVerified(false);
            $em->flush();

            $this->addFlash('success', $translator->trans('verificationMailSent', []) );
            return $security->login($user, AppAuthenticator::class, 'main');

            }

            else    {

                $em->flush();

                $this->addFlash('success','Modification Sauvegardée avec Succès');
                return $this->redirectToRoute('home');

            }

        }

        return $this->render('user/profil.html.twig',[
            'user' => $user,
            'form' => $form
        ]);
    
    }
}
