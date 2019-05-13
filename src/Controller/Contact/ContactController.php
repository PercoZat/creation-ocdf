<?php
namespace App\Controller\Contact;

use App\Form\Contact\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController
{
    public function contact(Request $request, \Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $form->getData();
            $this->sendMail($datas, $mailer);
        }
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }

    public function sendMail($datas, \Swift_Mailer $mailer)
    {
        $message = new \Swift_Message();
        $message->setSubject($datas['object']);
        $message->setFrom('noreply@ocdf.fr');
        $message->setTo($datas['email']);
        $message->setBody(
            $this->renderView('contact/modele.html.twig', [
                'datas' => $datas
            ]),
            'text/html'
        );
        $mailer->send($message);
    }
}
