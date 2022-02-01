<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminChangeRoleController extends AbstractController
{

    /**
     *@Route("/admin/users_role/{id}", name="admin_change_role")
     *@IsGranted("ROLE_ADMIN")
     */
    public function ChangeRole(int $id, UserRepository $userRepository, EntityManagerInterface $em):Response
    {
        $user = $userRepository->find($id);
        $useridentity = $this->getUser();

        if(!$user)
        {
            return $this -> redirectToRoute('home');
        }

    
        if($user === $useridentity ){
         
            $this->addFlash('danger', 'Vous ne pouvez pas changer votre role');
            return $this->redirectToRoute('admin_user');   
        }

        $role =$user->getRoles();
        if ($role[0] == "ROLE_ADMIN"){

        $user->setRoles([]);
        $em->flush();
        $this->addFlash('success', 'Le role a été changé avec succès');
        return $this->redirectToRoute('admin_user');

        }
        else {
        $user->setRoles([]);
        $user->setRoles(["ROLE_ADMIN"]);
         $em->flush();
         $this->addFlash('success', 'Le role a été changé avec succès');
         
         return $this->redirectToRoute('admin_user');
        }
      
    
 
     }
 
 }   