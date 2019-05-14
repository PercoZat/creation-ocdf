<?php
namespace App\Controller\Contact;

use App\Entity\Contact;
use App\Form\Contact\ContactFormType;
use App\Form\ContactType;
use App\Form\DevisType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController
{
    /**
     * Choix du contact :
     * - Devis (Contact avec entreprise)
     * - Contact simple (Contact sans entreprise)
     * - Etudiant (Student)
     * - Formateur (Training)
     * @return Response
     */
    public function preContact(): Response
    {
        return $this->render('contact/precontact.html.twig');
    }

    /**
     * Je suis une entreprise : je veux avoir un devis
     * @param Request $request
     * @return Response
     */
    public function contactDevis(Request $request, ObjectManager $manager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(DevisType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // Enregistrement contact
            $manager->persist($contact);
            $manager->flush();
            // Envoi de mail à Audrey
            // ##todo : récupérer service mail
            // Redirection
            return $this->redirectToRoute('postcontact');
        }

        return $this->render("contact/devis.html.twig", [
            'form' => $form->createView()
        ]);

    }
    /**
     * Je suis un internaute : je veux une info
     * @param Request $request
     * @return Response
     */
    public function contactPart(Request $request, ObjectManager $manager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // Enregistrement contact
            $manager->persist($contact);
            $manager->flush();
            // Envoi de mail à Audrey
            // ##todo : récupérer service mail
            // Redirection
            return $this->redirectToRoute('postcontact');
        }

        return $this->render("contact/contact.html.twig", [
            'form' => $form->createView()
        ]);

    }

    public function postContact()
    {
        return $this->render('contact/postcontact.html.twig');
    }


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
