<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function profil(Request $request, EntityManagerInterface $em, Security $security)
    {
                
        $user=$security->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form = $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success','Modification Sauvegardée avec Succès');
            return $this->redirectToRoute('home');
        }

        return $this->render('user/profil.html.twig',[
            'user' => $user,
            'form' => $form
        ]);
    
    }
}
