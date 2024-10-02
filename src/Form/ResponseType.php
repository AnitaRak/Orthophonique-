<?php

namespace App\Form;

use App\Entity\Evaluation;
use App\Entity\Item;
use App\Entity\Patient;
use App\Entity\Response;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text',TextType::class)
            /* ->add('audio')
            ->add('created_at',DateTimeType::class)
            ->add('evaluation',EntityType::class,[
                "class" => Evaluation::class,
                ])
            ->add('patient',EntityType::class,[
                "class" => Patient::class,
                ])
            ->add('item',EntityType::class,[
                "class" => Item::class,
                ]) */
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Response::class,
        ]);
    }
}
