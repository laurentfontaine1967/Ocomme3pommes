<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminEventController extends AbstractController
{
    /**
     *@Route("admin/admin_event", name="admin/admin_event")
     *@IsGranted("ROLE_ADMIN")
     */
    public function home(): Response
    {
        return $this->render('admin/event.html.twig', []);
    }
}