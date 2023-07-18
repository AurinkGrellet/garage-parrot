<?php

namespace App\Controller\Admin;

use App\Form\EditOpeningHoursFormType;
use App\Form\EditSummaryFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(Request $request): Response
    {
    /** 
     * Opening hours
     */
    $filepathHours = $this->getParameter('kernel.project_dir').
        '/templates/_openinghours.html.twig';
    $fileHours = new \stdClass();
    $fileHours->content = file_get_contents($filepathHours);
    $formOpening = $this->createForm(EditOpeningHoursFormType::class, $fileHours);
    $formOpening->handleRequest($request);

    /** 
     * Homepage summary
     */
    $filepathSummary = $this->getParameter('kernel.project_dir').
        '/templates/home/_summary.html.twig';
    $fileSummary = new \stdClass();
    $fileSummary->content = file_get_contents($filepathSummary);
    $formHomepage = $this->createForm(EditSummaryFormType::class, $fileSummary);
    $formHomepage->handleRequest($request);

    if ($formOpening->isSubmitted() && $formOpening->isValid())
    {
        // Save the file in templates/_openinghours.html.twig
        file_put_contents($filepathHours, $fileHours->content);

        // Clear cache (otherwise the changes won't be applied)
        $console = 'php '.$this->getParameter('kernel.project_dir').
            '/console';

        exec($console.' cache:clear --env=prod');
        exec($console.' cache:warmup --env=prod');

        return $this->redirect($this->generateUrl('admin'));
    }

    if ($formHomepage->isSubmitted() && $formHomepage->isValid())
    {
        // Save the file in templates/home/_summary.html.twig
        file_put_contents($filepathSummary, $fileSummary->content);

        // Clear cache (otherwise the changes won't be applied)
        $console = 'php '.$this->getParameter('kernel.project_dir').
            '/console';

        exec($console.' cache:clear --env=prod');
        exec($console.' cache:warmup --env=prod');

        return $this->redirect($this->generateUrl('admin'));
    }

    return $this->render('admin/admin.html.twig', [
        'formOpening' => $formOpening->createView(),
        'formHomepage' => $formHomepage->createView()
    ]);
    }
}
