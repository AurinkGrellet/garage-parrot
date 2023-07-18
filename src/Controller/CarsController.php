<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarsController extends AbstractController
{
    #[Route('/cars', name: 'cars')]
    public function index(): Response
    //TODO
    {
        return $this->render('cars/cars.html.twig', [
            'controller_name' => 'CarsController',
        ]);
    }

    #[Route('/cars/{id}', name: ('cars_showone'))]
    public function showOne(): Response
    {
        //TODO
        return $this->render('cars/cars.html.twig', [
            'controller_name' => 'CarsController',
        ]);
    }
}
