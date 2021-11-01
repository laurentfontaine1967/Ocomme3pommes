<?php

namespace App\Controller;
use App\Form\ChangeMailType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ModifyMailController extends AbstractController
{
    /**
     * @Route("auteur/modifier-mail", name="modifier-mail")
     */
    public function ModifyMail(UserRepository $user,EntityManagerInterface $em,Request $request):Response
    {   
       if(!$user)
       {
           return $this->redirectToRoute('home');
       }

        $user = $this->getUser();
        
        $form = $this->createForm(ChangeMailType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newmail = $form->get('email')->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user->setEmail($newmail));
            $entityManager->flush();

            $this->addFlash('success', 'Votre mail a été modifié avec success');
            return $this->redirectToRoute('app_login');
        }

        
    return $this->render('user/mypersonnalMail.html.twig', [
        'form' => $form->createView(),
         'user' => $user,

    ]);

    }

}