<?php

namespace App\Controller\Admin;

use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\AlimentRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAlimentController extends AbstractController
{
    #[Route('/admin/aliment', name: 'admin_aliments')]
    public function index(AlimentRepository $repository): Response
    {
      $aliments = $repository->findAll();
        return $this->render('admin/admin_aliment/adminAliments.html.twig', [
            'aliments' => $aliments,
        ]);
    }
    
    #[Route('/admin/aliment/new', name: 'admin_aliments_new')]
    #[Route('/admin/aliment/{id}', name: 'admin_aliments_edit', methods:['GET','POST'])]
    public function addAndEdit(Aliment $aliment = null, Request $request): Response
    {
      $manager = $this->getDoctrine()->getManager();
      if (!$aliment) {
        $aliment = new Aliment();
      }
      $form = $this->createForm(AlimentType::class, $aliment);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $edit = $aliment->getId() !== null;
        $manager->persist($aliment);
        $manager->flush();
        $this->addFlash("success", ($edit) ? "L'edition à été effectuée" : "L'aliment à été ajouté");
        return $this->redirectToRoute('admin_aliments');
      }
        return $this->render('admin/admin_aliment/newAndEditAliment.html.twig', [
            'aliment' => $aliment,
            'form' => $form->createView(),
            'edition'=> $aliment->getId() !== null
        ]);
    }

    #[Route('/admin/aliment/{id}', name: 'admin_aliments_delete', methods:['DELETE'])]
    public function suppression(Aliment $aliment, Request $request): Response
    {
      $manager = $this->getDoctrine()->getManager();
      if($this->isCsrfTokenValid('SUP' . $aliment->getId(), $request->get('_token'))){
        $manager->remove($aliment);
        $manager->flush();
        $this->addFlash("success","La suppression à été effectuée");

        return $this->redirectToRoute('admin_aliments');
      }
      
    }

}
