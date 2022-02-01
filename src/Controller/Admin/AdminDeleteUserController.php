<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDeleteUserController extends AbstractController
{

    /**
     *@Route("/admin/users_delete/{id}", name="admin_delete_user")
     *@IsGranted("ROLE_ADMIN")
     */
    public function adminDeleteUser(int $id, UserRepository $userRepository, EntityManagerInterface $em): RedirectResponse
    {

        $user = $this->getUser();

        $userIdentity = $userRepository->find($id);


        if (!$userIdentity)
        {

          return $this->redirectToRoute('admin_home');
        } 
        else if ($userIdentity===$user)
        {
            
             $this->addFlash('danger','L\'Administrateur ne peut pas se supprimer!!!!');
            return $this->redirectToRoute('admin_user');
        }
       


        $em->remove($userIdentity);
        $em->flush();
        $this->addFlash('success', 'cet utilisateur a bien ete supprimé');
        return $this->redirectToRoute('admin_user');
   
}
}