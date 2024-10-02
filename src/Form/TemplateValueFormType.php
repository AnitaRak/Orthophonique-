<?php

namespace App\Form;

use App\Entity\TemplateValue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemplateValueFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options: ['label' => 'Nom de la valeur (abréviation pour export)'])
            ->add('complete_name',  options: ['label' => 'Nom complet de la valeur, détails'])
            ->add('score',  options: ['label' => 'Nombre de points, score']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TemplateValue::class,
        ]);
    }
}
