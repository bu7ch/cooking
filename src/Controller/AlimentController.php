<?php

namespace App\Controller;

use App\Repository\AlimentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AlimentController extends AbstractController
{
    #[Route('/', name: 'aliments')]
    public function index(AlimentRepository $repository): Response
    {
      $aliments = $repository->findAll();
        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => false,
            'isGlucide' => false,
            
        ]);
    }
    #[Route('/aliments/calorie/{calorie}', name: 'aliments_by_calories')]
    public function aliments_less_calories(AlimentRepository $repository, $calorie): Response
    {
      $aliments = $repository->getAlimentsByProperties('calorie', '<', $calorie); 
        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => true,
            'isGlucide' => false,

            
        ]);
    }
    #[Route('/aliments/glucide/{glucide}', name: 'aliments_by_glucide')]
    public function aliments_less_glucide(AlimentRepository $repository, $glucide): Response
    {
      $aliments = $repository->getAlimentsByProperties('glucide', '<', $glucide); 
        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => false,
            'isGlucide' => true,

            
        ]);
    }
}
