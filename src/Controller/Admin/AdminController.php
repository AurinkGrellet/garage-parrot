<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Node\TextNode;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(Request $request): Response
    {
    // Opening hours template
    // TODO: exact same as homepage template, but using "DateType" instead
    
    
    // Homepage template
    $filepath = $this->getParameter('kernel.project_dir').
        '/templates/home/_summary.html.twig';

    // Object used in the form
    $file = new \stdClass();
    $file->content = file_get_contents($filepath);

    // Declare the form
    $form = $this->createFormBuilder($file)
        // A textarea for the file content.
        ->add('content', TextareaType::class, array(
            'label' => false,
            'attr' => array(
                'rows' => 16,
                'cols' => 112
            )
        ))
        ->add('submit', SubmitType::class, array(
            'label' => 'Save'
        ))
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid())
    {
        // Save the file in templates/home/_summary.html.twig
        file_put_contents($filepath, $file->content);

        // Clear cache (otherwise the changes won't be applied)
        $console = 'php '.$this->getParameter('kernel.project_dir').
            '/console';

        exec($console.' cache:clear --env=prod');
        exec($console.' cache:warmup --env=prod');

        return $this->redirect($this->generateUrl('admin'));
    }

    return $this->render('admin/index.html.twig', [
        'controller_name' => 'AdminController',
        'form' => $form->createView(),
    ]);
    }
}
