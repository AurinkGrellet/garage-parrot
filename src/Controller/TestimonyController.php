<?php

namespace App\Controller;

use App\Entity\Testimony;
use App\Form\TestimonyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestimonyController extends AbstractController
{
    private const EMPLOYEE = '[Employé]';

    #[Route('/testimony', name: 'testimony')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $testimony = new Testimony();
        $user = $this->getUser();
        $isEmployee = ($user && in_array('ROLE_EMPLOYEE', $user->getRoles(), true));
        if ($isEmployee) {
            $testimony->setName(self::EMPLOYEE.' '.$user->getFirstName().' '.$user->getLastName());
            $testimony->setApproved(true);
        }
        $form = $this->createForm(TestimonyType::class, $testimony);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($isEmployee) {
                // forces generic employee name
                $testimony->setName(self::EMPLOYEE.' '.$user->getFirstName().' '.$user->getLastName());
            }
            elseif (str_contains($testimony->getName(), self::EMPLOYEE)) {
                // prevents visitors from usurpating employee's identities
                    $newName = str_replace(self::EMPLOYEE, '', $testimony->getName());
                    $testimony->setName($newName);
            }
            $em->persist($testimony);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }
        return $this->render('testimony/testimony.html.twig', [
            'title' => 'Témoignages',
            'form' => $form
        ]);
    }
}
