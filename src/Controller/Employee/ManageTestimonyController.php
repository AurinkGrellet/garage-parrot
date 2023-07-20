<?php

namespace App\Controller\Employee;

use App\Repository\TestimonyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageTestimonyController extends AbstractController
{
    #[Route('/dashboard/testimony', name: 'manage_testimony')]
    public function index(TestimonyRepository $repository, Request $request): Response
    {
        $action = 'load';
        $params = $request->query->all();
        if (array_key_exists('action', $params)) {
            $action = $params['action'];
        }
        $testimonials = $repository->findBy(['approved' => false]);
        return $this->render('employee/managetestimonials.html.twig', [
            'testimonials' => $testimonials,
            'action' => $action
        ]);
    }

    #[Route('/dashboard/testimony/{id}/approve', name: 'approve_testimony')]
    public function approveTestimony(TestimonyRepository $repository, string $id): Response {
        $repository->approveTestimony($id);
        return $this->redirectToRoute('manage_testimony', [
            'action' => 'approve'
        ]);
    }

    #[Route('/dashboard/testimony/{id}/delete', name: 'delete_testimony')]
    public function deleteTestimony(TestimonyRepository $repository, string $id): Response {
        $repository->deleteTestimony($id);
        return $this->redirectToRoute('manage_testimony', [
            'action' => 'delete'
        ]);
    }
}
