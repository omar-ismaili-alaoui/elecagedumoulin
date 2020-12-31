<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\AnnonceImage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image',HiddenType::class,array(
                'label' => 'Image active',
                'required' => true,
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('active',ChoiceType::class,array(
                'label' => 'Image active',
                'required' => true,
                'choices'  => [
                    "Oui" => 1,
                    "Non" => 0,
                ],
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('principal',ChoiceType::class,array(
                'label' => 'Image principale',
                'required' => true,
                'choices'  => [
                    "Oui" => 1,
                    "Non" => 0,
                ],
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control'
            )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnnonceImage::class,
        ]);
    }
}
