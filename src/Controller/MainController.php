<?php

namespace App\Controller;

use App\Entity\Appsubfunction;
use App\Repository\UserRepository;
use App\Security\Voter\AppsubfunctionVoter;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\AppsubfunctionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

class MainController extends AbstractController
{
    #[Route('/main/{slug}-{id}', name: 'app_main',requirements: ['id' => '\d+' ,'slug' => '[a-z0-9-]+'])]
    public function index(Request $request, string $slug,int $id, UserRepository $repository, Security $security, TranslatorInterface $translator ): Response
    {
       
        $userId=$security->getUser()->getId();
        $Appsubfunctions=$repository->findAuthorizationByUserAndSubFunction($userId,$id);
        // Vérifiez si l'utilisateur a accès en appelant le voter.
        
        if ($this->isGranted(AppsubfunctionVoter::LIST, $Appsubfunctions))  {
            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController',
            ]);
        }
        else    {
            $this->addFlash('success', $translator->trans('unAuthorizedAccess', []) );
            return $this->redirectToRoute('home');
        }
    }

}
