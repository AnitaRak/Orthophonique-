<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Item;
use App\Entity\TemplateQuestion;
use App\Form\OptionResponseFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class QuestionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('active', null, [
                'label' => false,
            ])
            ->add('item', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'name_fr',
                'label' => false,
                'attr' => ['readonly' => true],
            ])
            ->add('templateQuestion', EntityType::class, [
                'class' => TemplateQuestion::class,
                'choice_label' => 'instructions_fr',
                'label' => false,
                'attr' => ['readonly' => true],
            ])
            ->add('optionResponses', CollectionType::class, [
                'entry_type' => OptionResponseFormType::class,
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
            'data_class' => Question::class,
        ]);
    }
}
