<?php

namespace App\Form;

use App\Entity\Test;
use App\Entity\TestType;
use App\Entity\TemplateQuestion;
use App\Entity\TemplateValue;
use App\Repository\TestTypeRepository;
use App\Form\TemplateQuestionFormType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TestFormType extends AbstractType
{
    private TestTypeRepository $testTypeRepository;
    public function __construct(TestTypeRepository $testTypeRepository)
    {
        $this->testTypeRepository = $testTypeRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('active', options: ['label' => 'Épreuve disponible à l\'utilisation pour les profesionnels'])
            ->add('name', options: ['label' => 'Nom de l\'épreuve'])
            ->add('is_timed', options: ['label' => 'Items chronométrés'])
            ->add('timer', options: ['label' => 'Chronomètre (secondes)'])
            ->add('instructions_fr', options: ['label' => 'Consigne à donner (Français)'])
            ->add('instructions_cr', options: ['label' => 'Consigne à donner (Créole)'])
            ->add('implementation_advice', options: ['label' => 'Conseils de mise en oeuvre supplémentaires'])
            ->add('typeTest', EntityType::class, [
                'class' => TestType::class,
                'choice_label' => 'name',
                'label' => 'Type épreuve',
            ])
            ->add('templateQuestions', CollectionType::class, [
                'entry_type' => TemplateQuestionFormType::class,
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
            'data_class' => Test::class,
        ]);
    }
}
