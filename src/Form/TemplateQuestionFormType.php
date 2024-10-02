<?php

namespace App\Form;

use App\Entity\TemplateQuestion;
use App\Form\TemplateValueFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TemplateQuestionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('requires_audio', options: ['label' => 'Enregistrement d\'un audio'])
            ->add('requires_text', options: ['label' => 'Saisie d\'un texte'])
            ->add('is_included_in_total_score', options: ['label' => 'Le score obtenu à cette question doit être pris en compte dans le total'])
            ->add('is_mcq', options: ['label' => 'Est un questionnaire à choix multiples'])
            ->add('is_custom_score', options: ['label' => 'Saisie d\'un score (manuelle)'])
            ->add('instructions_fr', options: ['label' => 'Consigne (français)'])
            ->add('instructions_cr', options: ['label' => 'Consigne (créole)'])
            ->add('templateValues', CollectionType::class, [
                'entry_type' => TemplateValueFormType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TemplateQuestion::class,
        ]);
    }
}
