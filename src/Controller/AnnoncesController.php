<?php

namespace App\Controller;
use App\Entity\Images;
use App\Entity\Annonces;
use App\Form\AnnoncesType;
use App\Repository\AnnoncesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 /**
  * @Route("/annonces")
 */
class AnnoncesController extends AbstractController
{
    /**
     * @Route("/", name="annonces_index", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function index(AnnoncesRepository $annoncesRepository): Response
    {
        return $this->render('annonces/index.html.twig', [
            'annonces' => $annoncesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="annonces_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        //gestion images
         $images=$form->get('images')->getData();
         foreach ($images as $image) {
         $fichier=md5(uniqid()).'.'.$image->guessExtension();
         $image->move(
            $this->getParameter('images_directory'),
            $fichier

         );
       //stcokage en base dd ( nom)
         $img = new Images();
         $img->setName($fichier);
         $annonce->addImage($img);

         }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonces_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonces/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="annonces_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(Annonces $annonce): Response
    {
        return $this->render('annonces/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="annonces_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Annonces $annonce): Response
    {
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
              //gestion images
              $images=$form->get('images')->getData();
             foreach ($images as $image) {
             $fichier=md5(uniqid()).'.'.$image->guessExtension();
             $image->move(
             $this->getParameter('images_directory'),
             $fichier

                        );
             //stcokage en base dd ( nom)
             $img=new Images();
            $img->setName( $fichier);
            $annonce->addImage($img);

                                     }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('annonces_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonces/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="annonces_delete", methods={"POST"})
     */
    public function delete(Request $request, Annonces $annonce): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annonces_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
    * @Route("/supprime/image/{id}", name="annonces_delete_image")
    */
    public function deleteImage(Images $image,Request $request){
    //   $data = json_decode($request->getContent(),true);
    //     if($this->isCsrfTokenValid('delete'.$image->getId(),$data,['_token'])){
     $nom= $image->getName(); 
       unlink($this->getParameter('images_directory').'/'.$nom);
      $em =$this->getDoctrine()->getManager();
        $em->remove($image);
     $em->flush();
    //     return new JsonResponse(['success' => 1]);
    //    }else{
    //         return new JsonResponse(['error' =>'Token Invalide'],400);
    // }
    return $this->redirectToRoute('annonces_index', [], Response::HTTP_SEE_OTHER);
       }
       
    }