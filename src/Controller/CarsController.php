<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarsController extends AbstractController
{
    #[Route('/cars', name: 'cars')]
    public function index(CarRepository $repository): Response
    {
        $cars = $repository->findAll();

        return $this->render('cars/cars.html.twig', [
            'title' => 'Voitures',
            'cars' => $cars,
        ]);
    }

    private function configAjaxResponse($cars): JsonResponse {
        $template = $this->render('cars/loop.html.twig', ['cars' => $cars])->getContent();
        $response = new JsonResponse();
        $response->setStatusCode(200);
        return $response->setData(['template' => $template]);
    }

    #[Route('/cars/filter')]
    public function filter(CarRepository $repository, Request $request): JsonResponse
    {
        $fields = [];
        $lowerValues = [];
        $higherValues = [];
        
        $filters = $request->request->all();
        $valueA = 0;
        foreach ($filters as $id=>$value) {
            if(str_contains($id, 'km')) $field = "km";
            else if(str_contains($id, 'price')) $field = "price";
            else if(str_contains($id, 'year')) $field = "year";
            
            if (!in_array($field, $fields)) {
                array_push($fields, $field);
                $valueA = $value;
            }
            else {
                if ($valueA <= $value) {
                    array_push($lowerValues, $valueA);
                    array_push($higherValues, $value);
                }
                else {
                    array_push($lowerValues, $value);
                    array_push($higherValues, $valueA);
                }
            }
        }

        $cars = $repository->filterByFieldsBetween($fields, $lowerValues, $higherValues);
        return $this->configAjaxResponse($cars);
    }
}
