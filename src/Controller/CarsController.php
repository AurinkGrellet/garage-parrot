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
            'cars' => $cars,
        ]);
    }

    private function configAjaxResponse($cars): JsonResponse {
        $template = $this->render('cars/loop.html.twig', ['cars' => $cars])->getContent();
        $response = new JsonResponse();
        $response->setStatusCode(200);
        return $response->setData(['template' => $template]);
    }

    private function filterByPrice($request, $repository, $comparator) {
        $value = $request->request->all()['value'];
        $cars = $repository->filterByField('price', $value, $comparator);
        return $this->configAjaxResponse($cars);
    }

    private function filterByPriceBetween($request, $repository) {
        $valuelow = $request->request->all()['valuelow'];
        $valuehigh = $request->request->all()['valuehigh'];
        $cars = $repository->filterByFieldBetween('price', $valuelow, $valuehigh);
        return $this->configAjaxResponse($cars);
    }

    #[Route('/cars/filter/pricelow')]
    public function filterPriceLow(CarRepository $repository, Request $request): JsonResponse
    {
        return $this->filterByPrice($request, $repository, '>=');
    }

    #[Route('/cars/filter/pricehigh')]
    public function filterPriceHigh(CarRepository $repository, Request $request): JsonResponse
    {
        return $this->filterByPrice($request, $repository, '<=');
    }

    #[Route('/cars/filter/pricebetween')]
    public function filterPriceBetween(CarRepository $repository, Request $request): JsonResponse
    {
        return $this->filterByPriceBetween($request, $repository);
    }

    #[Route('/cars/filter/km')]
    public function filterKm(CarRepository $repository, Request $request): JsonResponse
    {
        $params = $request->request->all();
        $value = $params['value'];
        $comparator = $params['type'];
        $cars = $repository->filterByField('km', $value, $comparator);
        return $this->configAjaxResponse($cars);
    }

    #[Route('/cars/filter/year')]
    public function filterYear(CarRepository $repository, Request $request): JsonResponse
    {
        $value = $request->request->all()['value'];
        $cars = $repository->filterByField('year', $value, '=');
        return $this->configAjaxResponse($cars);
    }

    /*#[Route('/cars/{id}', name: ('cars_showone'))]
    public function showOne(): Response
    {
        return $this->render('cars/cars.html.twig', [
            'controller_name' => 'CarsController',
        ]);
    }*/
}
