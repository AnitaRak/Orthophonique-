<?php

namespace App\Form;

use App\Entity\Test;
use App\Entity\Item;
use App\Entity\Question;
use App\Entity\TemplateQuestion;
use App\Form\QuestionFormType;
use App\Entity\SchoolGrade;
use App\Repository\TestRepository;
use App\Repository\TemplateQuestionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ItemFormType extends AbstractType
{

    private TemplateQuestionRepository $templateQuestionRepository;
    private TestRepository $testRepository;

    public function __construct(TemplateQuestionRepository $templateQuestionRepository, TestRepository $testRepository)
    {
        $this->templateQuestionRepository = $templateQuestionRepository;
        $this->testRepository = $testRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_fr', options: ['label' => 'Nom français'])
            ->add('name_cr', options: ['label' => 'Nom créole'])
            ->add('test', EntityType::class, [
                'class' => Test::class,
                'choice_label' => 'name',
                'label' => 'Épreuve',
                'group_by' => 'type_test.name',
            ])
            ->add('school_grade', EntityType::class, [
                'class' => SchoolGrade::class,
                'choice_label' => 'name',
                'label' => 'Niveau scolaire minimal pour cet item',
            ])
            ->add('templateQuestion', EntityType::class, [
                'class' => TemplateQuestion::class,
                'choice_label' => 'instructions_fr',
                'mapped' => false,
            ])
            ->add('illustrations', FileType::class, [
                'label' => 'Image(s)',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
            ])
            ->add('questions', CollectionType::class, [
                'entry_type' => QuestionFormType::class,
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
            'data_class' => Item::class,
        ]);
    }
}
