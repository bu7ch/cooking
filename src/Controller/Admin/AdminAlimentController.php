<?php

namespace App\Controller\Admin;

use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\AlimentRepository;
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
    #[Route('/admin/aliment/{id}', name: 'admin_aliments_edit')]
    public function edition(Aliment $aliment): Response
    {
      $form = $this->createForm(AlimentType::class, $aliment);
        return $this->render('admin/admin_aliment/editAliment.html.twig', [
            'aliment' => $aliment,
            'form' => $form->createView()
        ]);
    }
}
