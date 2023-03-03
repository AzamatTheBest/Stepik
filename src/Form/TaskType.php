<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
        
            ->add('course', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Type your order...',
                ],
            ])
            ->add('order', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Type your order...',
                ]
            ])
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Type your title...',
                ]
            ])
            ->add('text', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Type your text...',
                ]
            ])
            ->add('type', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Type your type...',
                ]
            ])
            ->add('correctAnswer', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Type your correct answer...',
                ]
            ])
            ->add('variantsAsString', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Type your variants...',
                ]
            ])
            ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Task::class,
            ]);
    }
}