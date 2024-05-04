<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ChangePasswordController extends AbstractController
{
    #[Route('/changepassword', name: 'changepassword')]
    public function change(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager , Security $security): Response
    {

        $user=$security->getUser();
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode(hash) the plain password, and set it.
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('reset_password/reset.html.twig', [
            'type'=>'change',
            'resetForm' => $form,
        ]);
    }


}
