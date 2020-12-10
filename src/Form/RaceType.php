<?php

namespace App\Form;

use App\Entity\Race;
use App\Entity\Sexe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class RaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class,
            array(
                'label' => 'Nom de la race',
                'required' => true,
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('couleur',TextType::class,
            array(
                'label' => 'Couleur de la race',
                'required' => true,
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('sexe',EntityType::class,
            array('class' => Sexe::class,
                'label' => 'Sexe de la race',
                'required' => true,
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('active', ChoiceType::class,
            array(
                'label' => 'Race active',
                'required' => true,
                'choices'  => [
                    "Active" => 1,
                    "Inactive" => 0,
                ],
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control')

            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Race::class,
        ]);
    }
}
