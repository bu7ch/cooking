<?php

namespace App\Controller\Admin;

use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\AlimentRepository;
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
    #[Route('/admin/aliment/{id}', name: 'admin_aliments_edit')]
    public function addAndEdit(Aliment $aliment = null, Request $request): Response
    {
      $manager = $this->getDoctrine()->getManager();
      if (!$aliment) {
        $aliment = new Aliment();
      }
      $form = $this->createForm(AlimentType::class, $aliment);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $manager->persist($aliment);
        $manager->flush();
        return $this->redirectToRoute('admin_aliments');
      }
        return $this->render('admin/admin_aliment/editAliment.html.twig', [
            'aliment' => $aliment,
            'form' => $form->createView(),
            'edition'=> $aliment->getId() !== null
        ]);
    }
}
