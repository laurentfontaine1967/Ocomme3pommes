<?php

namespace App\Controller;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MesInfosController extends AbstractController
{
    /**
     * @Route("/mes-informations", name="mes-informations")
     */
    public function Info(UserRepository $userRepository):Response
    {
        $user = $this->getUser();
        if(!$user){
           return $this->redirectToRoute('app_login');
           }

    return $this->render('user/mypersonnal.html.twig', ['user' => $user]);
    }
}