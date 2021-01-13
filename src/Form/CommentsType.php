<?php

namespace App\Form;

use App\Entity\Comments;
use App\Entity\Race;
use App\Entity\Subject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->type = $options["current_form_type"];
        $builder
            ->add('pseudo',TextType::class,
                array(
                    'label' => 'Pseudo',
                    'required' => true,
                    'error_bubbling' => true,
                    'attr' => array('class' => 'form-control')
                ))
            ->add('ville',TextType::class,
                array(
                    'label' => 'Ville',
                    'required' => true,
                    'error_bubbling' => true,
                    'attr' => array('class' => 'form-control')
                ))
            ->add('titre',TextType::class,
                array(
                    'label' => 'Titre',
                    'required' => true,
                    'error_bubbling' => true,
                    'attr' => array('class' => 'form-control')
                ))
            ->add('comment',TextareaType::class,
                array(
                    'label' => 'Commentaire',
                    'required' => true,
                    'error_bubbling' => true,
                    'attr' => array('class' => 'form-control')
                ))
            ->add('published', DateType::class,array(
                'label' => 'Date de publication',
                'required' => true,
                'error_bubbling' => true,
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'model_timezone' => 'Europe/Paris',
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control datepicker')
            ))
            ->add('lived', DateType::class,array(
                'label' => 'Date de vécu',
                'required' => true,
                'error_bubbling' => true,
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'model_timezone' => 'Europe/Paris',
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control datepicker')
            ));

            if($this->type != 'INACTIVE') {
                $builder->add('active', ChoiceType::class, array(
                    'label' => 'Active',
                    'required' => false,
                    'choices' => [
                        "Oui" => 1,
                        "Non" => 0,
                    ],
                    'error_bubbling' => true,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('rating',ChoiceType::class,
                    array(
                        'label' => 'Note',
                        'required' => true,
                        'error_bubbling' => true,
                        'attr' => array('class' => 'form-control')
                ));
            }else{
                $builder->add('rating',HiddenType::class,
                    array(
                        'label' => 'Note',
                        'required' => true,
                        'error_bubbling' => true,
                        'attr' => array('id'=> 'ratingInsert','class' => 'form-control')
                    ));
            }

            $builder->add('subject',EntityType::class,
                array('class' => Subject::class,
                    'label' => 'Le sujet',
                    'required' => true,
                    'error_bubbling' => true,
                    'attr' => array('class' => 'form-control')
                ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
            'current_form_type' => null,
        ]);
    }
}
