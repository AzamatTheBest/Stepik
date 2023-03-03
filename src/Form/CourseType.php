<?php

namespace App\Form;

use App\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Type your name...',
                ]
            ])
            ->add('description', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Type your description...',
                ]
            ])
            ->add('image', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Type your image...',
                ]
            ])
            ->add('slug', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Type your slug...',
                ]
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Course::class,
            ]);
    }
}