<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Exception\RfcComplianceException;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $title = '';
        $param = $request->request->get('titre');
        if ($param) {
            $title = $param;
        }
        $garagePhone = $this->getParameter('app.phone');

        $contact = new Contact();
        $contact->setSubject($title);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $toEmail = $this->getParameter('app.contact');
            $subject = $form->get('subject')->getData();
            $fromEmail = $form->get('email')->getData();
            $lastname = $form->get('name')->getData();
            $firstname = $form->get('firstname')->getData();
            $phone = $form->get('phone')->getData();
            $message = $form->get('message')->getData();

            $email = (new TemplatedEmail())
            ->from(new Address($fromEmail|$toEmail, $firstname.' '.$lastname))
            ->to(new Address($toEmail, 'Garage V. Parrot'))
            ->subject($subject)
            ->htmlTemplate('emails/contactform.html.twig')
            ->context([
                'name' => $firstname.' '.$lastname,
                'mail' => $fromEmail,
                'phone' => $phone,
                'message' => $message
            ]);
            
            try {
                $email->from(new Address($fromEmail, $firstname.' '.$lastname));
            }
            catch (RfcComplianceException $e) {
                $email->from(new Address($toEmail, $firstname.' '.$lastname));
            }
            $email->context([
                'name' => $firstname.' '.$lastname,
                'mail' => $fromEmail,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($email);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('contact/contact.html.twig', [
            'title' => 'Nous contacter',
            'form' => $form,
            'phone' => $garagePhone
        ]);
    }
}
