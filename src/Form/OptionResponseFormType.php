<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\OptionResponse;
use App\Entity\TemplateValue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OptionResponseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options: ['label' => 'Nom'])
            ->add('question', EntityType::class, [
                'class' => Question::class,
                'choice_label' => 'templateQuestion.instructions_fr',
                'label' => 'Question',
                'attr' => [
                    'class' => 'question-select',
                ],
            ])
            ->add('templateValue', EntityType::class, [
                'class' => TemplateValue::class,
                'choice_label' => 'name',
                'label' => 'Valeur associée',
                'attr' => [
                    'class' => 'template-value-select',
                ],
            ])
            ->add('optionResponsesMedias', FileType::class, [
                'label' => 'Médias',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'media-value-select',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OptionResponse::class,
        ]);
    }
}
