<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Country;
use App\Entity\Training;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choiceCfg = [
            "choices" => ["choix 1" => 1, "choix 2" => 2]
        ];

        $builder
            ->add('name', TextType::class)
            ->add('status', TextType::class)
            ->add('email', EmailType::class)
            ->add('country', EntityType::class, [
                "class" => Country::class,
                "choice_label" => "name"
            ])
            ->add('training', EntityType::class, [
                "class" => Training::class,
                "choice_label" => "title",
                "multiple" => true
            ])
            //->add('testChoice', ChoiceType::class, $choiceCfg)
            ->add('save', SubmitType::class, ["label" => "Enregistrer"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
