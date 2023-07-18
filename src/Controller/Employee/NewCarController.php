<?php

namespace App\Controller\Employee;

use App\Entity\Car;
use App\Form\CarType;
use App\ImageOptimizer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;

class NewCarController extends AbstractController
{
    #[Route('/dashboard/car', name: 'newCar', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $carAdded = false;
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // managing the image
            $imageDir = $this->getParameter('kernel.project_dir') . '/public/images/';
            $image = $form->get('image')->getData();
            $imageOriginalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFileName = $slugger->slug($imageOriginalName);
            $newFilename = $safeFileName.'-'.uniqid().'.'.$image->guessExtension();
            $image->move($imageDir, $newFilename);
            $optimizer = new ImageOptimizer();
            $optimizer->resize($newFilename);
            $car->setImage($newFilename);

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
