<?php


namespace App\Controller;

use App\Entity\Teacher;
use App\Form\TeacherType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TeacherController extends AbstractController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {

        $this->passwordEncoder = $passwordEncoder;
    }

    public function contactTeacher(Request $request, ObjectManager $manager): Response
    {
        $teacher = new Teacher();
        $form = $this->createForm(TeacherType::class, $teacher);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $plainPassword = md5("fdsfdsfdsds");

            // Password teacher
            $teacher->setPassword(
                $this->passwordEncoder->encodePassword(
                    $teacher,
                    $plainPassword
                )
            );
            $teacher->setPlainPassword($plainPassword);

            // Enregistrement contact

            $manager->persist($teacher);
            $manager->flush();
            // Envoi de mail à Audrey
            // ##todo : récupérer service mail
            // Redirection
            return $this->redirectToRoute('postcontact');
        }

        return $this->render("contact/contact_teacher.html.twig", [
            'form' => $form->createView()
        ]);

    }
}