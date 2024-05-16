<?php

namespace App\Controller;

use App\DTO\FilterDTO;
use App\Form\FilterType;
use App\Entity\Appfunction;
use App\Form\AppfunctionType;
use App\Entity\Appsubfunction;
use App\Entity\Appauthorization;
use Symfony\UX\Turbo\TurboBundle;
use App\Repository\UserRepository;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AppfunctionRepository;
use App\Security\Voter\AppsubfunctionVoter;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\AppsubfunctionRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AppauthorizationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/main/{slug}-{sfid}/index', name: 'app_main_index',requirements: ['sfid' => '\d+' ,'slug' => '[a-z0-9-]+'])]
    public function index(Request $request, string $slug,int $sfid, 
            UserRepository $UserRepository,
            AppfunctionRepository $AppfunctionRepository, 
            ProfileRepository $ProfileRepository, 
            AppsubfunctionRepository $AppsubfunctionRepository,
            Security $security, TranslatorInterface $translator ): Response
    {
       
        $userId=$security->getUser()->getId();
        $Appsubfunction=$UserRepository->findAuthorizationByUserAndSubFunction($userId,$sfid);
        // Vérifiez si l'utilisateur a accès en appelant le voter.
        
        if (1==1) {

            if ($slug=='utilisateurs') {

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
                    'level' => $Appsubfunction->level,
                    'slug' => $slug,
                    'sfid' => $sfid
                    //'form' => $form
                ]);

            }   
           
            if ($slug=='fonctions') {
            
                $currentPage=$request->query->getInt('page',1);
                $functions=$AppfunctionRepository->paginatedAppfunctions($currentPage);

                return $this->render('main/function/index.html.twig',[
                    'functions' => $functions,
                    'level' => $Appsubfunction->level,
                    'slug' => $slug,
                    'sfid' => $sfid                ]);

            }   

            if ($slug=='profils') {
            
                $currentPage=$request->query->getInt('page',1);
                $profiles=$ProfileRepository->paginatedProfiles($currentPage);

                return $this->render('main/profile/index.html.twig',[
                    'profiles' => $profiles,
                    'level' => $Appsubfunction->level,
                    'slug' => $slug,
                    'sfid' => $sfid                ]);
            }   
            
            if ($slug=='autorisations-par-profil') {
            
                $profiles=$ProfileRepository->findAllProfiles();
                $Appsubfunctions=$AppsubfunctionRepository->findAllAppsubfunctions();
                $authorizations=$AppsubfunctionRepository->findAllAuthorizations();

                return $this->render('main/autorisation/index.html.twig',[
                    'authorizations' => $authorizations,
                    'appsubfunctions' => $Appsubfunctions,
                    'profiles' => $profiles,
                    'slug' => $slug,
                    'sfid' => $sfid                ]);
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

    #[Route('/main/{slug}-{sfid}/edit/{id}', name: 'app_main_edit',methods: ['GET','POST'],requirements: ['sfid' => '\d+' ,'id' => '\d+' ,'slug' => '[a-z0-9-]+'])]
    public function edit(Request $request, string $slug,int $sfid,int $id, UserRepository $UserRepository,AppfunctionRepository $AppfunctionRepository, ProfileRepository $ProfileRepository, Security $security, TranslatorInterface $translator, EntityManagerInterface $em ): Response
    {
        $userId=$security->getUser()->getId();
        $Appsubfunction=$UserRepository->findAuthorizationByUserAndSubFunction($userId,$sfid);
        // Vérifiez si l'utilisateur a accès en appelant le voter.
        
        if ($this->isGranted(AppsubfunctionVoter::EDIT, $Appsubfunction))  {

            if ($slug=='fonctions') {

                $Appfunction=$AppfunctionRepository->findOneById($id);

                $form = $this->createForm(AppfunctionType::class, $Appfunction);
                $form = $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $em->flush();
                    $this->addFlash('success','Modification Sauvegardée avec Succès');
                    return $this->redirectToRoute('app_main_index',['slug'=>$slug,'sfid'=>$sfid]);
                }

                return $this->render('main/function/edit.html.twig',[
                    'Appfunction' => $Appfunction,
                    'form' => $form
                ]);
        
            }
        }

    }

    #[Route('/main/{slug}-{sfid}/modify/{profileid}/{appsubfunctionid}', name: 'app_main_modify',methods: ['GET','POST'],requirements: ['sfid' => '\d+' ,'id' => '\d+' ,'slug' => '[a-z0-9-]+'])]
    public function modify(Request $request, string $slug,int $sfid,int $profileid,int $appsubfunctionid, UserRepository $UserRepository,AppsubfunctionRepository   $AppsubfunctionRepository ,AppauthorizationRepository $AppauthorizationRepository, ProfileRepository $ProfileRepository, Security $security, TranslatorInterface $translator, EntityManagerInterface $em ): Response
    {
        $userId=$security->getUser()->getId();
        $Appsubfunction=$UserRepository->findAuthorizationByUserAndSubFunction($userId,$sfid);
        // Vérifiez si l'utilisateur a accès en appelant le voter.
        
        if ($this->isGranted(AppsubfunctionVoter::EDIT, $Appsubfunction))  {

            if ($slug=='autorisations-par-profil') {

                $profile=$ProfileRepository->findOneById($profileid);
                $Appsubfunction=$AppsubfunctionRepository->findOneById($appsubfunctionid);
                $Appauthorization=$AppauthorizationRepository->findOneByProfileIdAndAppsubfunctionId($profile,$Appsubfunction);

                if ($Appauthorization) {
                    if ($Appauthorization->getLevel()=='VIEW') {
                        $Appauthorization->setLevel('EDIT');
                        $em->flush();
                        $level='edit';
                        $icon='check-circle-fill';
                    }
                    else if ($Appauthorization->getLevel()=='EDIT') {
                        $em->remove($Appauthorization);
                        $em->flush(); 
                        $level='off';   
                        $icon='check-circle';
                    }                   
                }
                else{ 
                    $Appauthorization= new Appauthorization();
                    $Appauthorization->setProfile($profile);
                    $Appauthorization->setAppsubfunction($Appsubfunction);
                    $Appauthorization->setLevel("VIEW");
                    $em->persist($Appauthorization);
                    $em->flush();
                    $level='view';   
                    $icon='check-circle-fill';
                }


                    // If the request comes from Turbo, set the content type as text/vnd.turbo-stream.html and only send the HTML to update
                    $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
                    return $this->render('main/autorisation/detail.html.twig', ['profileid'=>$profileid,'appsubfunctionid'=>$appsubfunctionid,'icon'=>$icon,'level'=>$level]);

            }
        
        }

    }

    #[Route('/main/{slug}-{sfid}/delete/{id}', name: 'app_main_delete',methods: ['DELETE'],requirements: ['sfid' => '\d+' ,'id' => '\d+' ,'slug' => '[a-z0-9-]+'])]
    public function delete(Request $request, string $slug,int $sfid,int $id, UserRepository $UserRepository,AppfunctionRepository $AppfunctionRepository, ProfileRepository $ProfileRepository, Security $security, TranslatorInterface $translator ): Response
    {
        dd('delete');
    }


}
