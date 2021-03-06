<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{

    /**
     *@Route("/admin/users", name="admin_user")
     *@IsGranted("ROLE_ADMIN")
     */
    public function adminShowUser(Request $request, PaginatorInterface $paginator, UserRepository $userRepository): Response
    {

        $data = $userRepository->findAll();

        $users = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );



        return $this->render("/admin/user.html.twig", [
            'users' => $users
        ]);
    }
}