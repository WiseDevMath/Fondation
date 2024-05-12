<?php

namespace App\Controller;

use App\DTO\FilterDTO;
use App\Form\FilterType;
use App\Entity\Appsubfunction;
use App\Repository\AppfunctionRepository;
use App\Repository\UserRepository;
use App\Security\Voter\AppsubfunctionVoter;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\AppsubfunctionRepository;
use App\Repository\ProfileRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/main/{slug}-{id}', name: 'app_main',requirements: ['id' => '\d+' ,'slug' => '[a-z0-9-]+'])]
    public function index(Request $request, string $slug,int $id, UserRepository $UserRepository,AppfunctionRepository $AppfunctionRepository, ProfileRepository $ProfileRepository, Security $security, TranslatorInterface $translator ): Response
    {
       
        $userId=$security->getUser()->getId();
        $Appsubfunctions=$UserRepository->findAuthorizationByUserAndSubFunction($userId,$id);
        // Vérifiez si l'utilisateur a accès en appelant le voter.
        
        if ($this->isGranted(AppsubfunctionVoter::LIST, $Appsubfunctions))  {


            if ($slug=='gestion-des-utilisateurs') {

                /* Solution filtre spécifique 
                $data = new FilterDTO();
                $data->filter1='';
                $form = $this->createForm(FilterType::class, $data);
                $form = $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) { 
                }
                */
            
                $currentPage=$request->query->getInt('page',1);
                $users=$UserRepository->paginatedUsers($currentPage);

                return $this->render('main/user/index.html.twig',[
                    'users' => $users,
                    //'form' => $form
                ]);

            }   
           
            if ($slug=='gestion-des-fonctions') {
            
                $currentPage=$request->query->getInt('page',1);
                $functions=$AppfunctionRepository->paginatedAppfunctions($currentPage);

                return $this->render('main/function/index.html.twig',[
                    'functions' => $functions,
                ]);

            }   

            if ($slug=='gestion-des-profils') {
            
                $currentPage=$request->query->getInt('page',1);
                $profiles=$ProfileRepository->paginatedProfiles($currentPage);

                return $this->render('main/profile/index.html.twig',[
                    'profiles' => $profiles,
                ]);

            }   
            
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
