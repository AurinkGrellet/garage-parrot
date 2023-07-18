<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarsController extends AbstractController
{
    #[Route('/cars', name: 'cars')]
    public function index(CarRepository $repository): Response
    {
        $cars = $repository->findAll();

        return $this->render('cars/cars.html.twig', [
            'cars' => $cars,
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
