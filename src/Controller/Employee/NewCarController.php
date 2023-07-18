<?php

namespace App\Controller\Employee;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

class NewCarController extends AbstractController
{
    #[Route('/dashboard/car', name: 'newCar')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $carAdded = false;
        $car = new Car();
        $form = $this->createFormBuilder($car)
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'required' => true
            ])
            ->add('image', FileType::class, [
                'label' => 'Photo',
                'required' => true
            ])
            ->add('year', DateType::class, [
                'label' => 'Année de mise en service',
                'required' => true,
                'years' => range(date('Y')-50, date('Y'))
            ])
            ->add('km', IntegerType::class, [
                'label' => 'Kilomètres',
                'required' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($car);
            $em->flush();
            $carAdded = true;
        }
        
        return $this->render('employee/newcar.html.twig', [
            'form' => $form,
            'carAdded' => $carAdded
        ]);
    }
}
