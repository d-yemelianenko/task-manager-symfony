<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\TaskStatus;
use App\Repository\TaskStatusRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TaskForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Tytuł'
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => 5],
                'label' => 'Opis'
            ])
            ->add('dueDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Termin wykonania',
                'required' => false
            ])
            ->add('status', EntityType::class, [
                'class' => TaskStatus::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'form-select'],
                'label' => 'Status',
                'placeholder' => 'Wybierz status',
                'query_builder' => function (TaskStatusRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.id', 'ASC');
                }
            ]);
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
