<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\Training;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trainingChoice', EntityType::class, [
                'class' => Training::class,
                'label' => "Quelle formation voulez-vous rejoindre ?",
                'multiple' => false,
                "required" => true
            ])
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('telephone')
            ->add('address')
            ->add('city')
            ->add('postalCode')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
