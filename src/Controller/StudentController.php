<?php


namespace App\Controller;


use App\Entity\Student;
use App\Form\StudentType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends AbstractController
{
    public function contactStudent(Request $request, ObjectManager $manager): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // FIX : sélection formulaire => une formation
            // FIX : dans l'entité je peux en choisir plusieurs (Collection)
            $student->addTraining($student->getTrainingChoice());

            // Enregistrement contact
            $manager->persist($student);
            $manager->flush();
            // Envoi de mail à Audrey
            // ##todo : récupérer service mail
            // Redirection
            return $this->redirectToRoute('postcontact');
        }

        return $this->render("contact/contact_student.html.twig", [
            'form' => $form->createView()
        ]);

    }
}