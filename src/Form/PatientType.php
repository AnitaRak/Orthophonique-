<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\SchoolGrade;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name',TextType::class , [
                "label"=> "Prénom "
            ])
            ->add('last_name',TextType::class , [
                "label"=> "Nom ",
                
            ])
            ->add('birth_date',DateType::class,[
                "label"=> "Date de naissance",
                'years' => range(1990, date('Y'))
            ])
            ->add('school_grade', EntityType::class, [
                "label" => "Niveau scolaire",
                "class" => SchoolGrade::class,
                "choice_label" => 'name',
                ])
            ->add('gender',ChoiceType::class, [
                "label"=> "genre" , 
                'choices'  => [
                    'Homme'=>'H',
                    'Femme'=>'F',
                    'Autre'=>'NB' 
                ],
            ])
            ->add("enregistrer",SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
