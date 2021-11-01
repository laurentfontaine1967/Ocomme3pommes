<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminHomeController extends AbstractController
{
    /**
     *@Route("admin/admin_home", name="admin/admin_home")
     *@IsGranted("ROLE_ADMIN")
     */
    public function home(): Response
    {
        return $this->render('admin/home.html.twig', []);
    }
}