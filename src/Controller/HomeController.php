<?php

namespace App\Controller;

use App\Repository\TestimonyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(TestimonyRepository $repository): Response
    {
        $testimonials = $repository->findBy(['approved' => true]);
        return $this->render('home/homepage.html.twig', [
            'testimonials' => $testimonials
        ]);
    }
}
