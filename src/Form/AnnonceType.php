<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Race;
use App\Entity\Sexe;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class,array(
                'label' => 'Titre de l\'annonce texte',
                'required' => true,
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control ')
            ))
            ->add('datePublished', TextType::class,array(
                'label' => 'Date de naissance',
                'required' => false,
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control datepicker')
            ))
            ->add('content',TextareaType::class,array(
                'label' => 'Annonce texte',
                'required' => true,
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('vermifuge', ChoiceType::class,array(
                'label' => 'Vermifugé',
                'required' => true,
                'choices'  => [
                    "Oui" => 1,
                    "Non" => 0,
                ],
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('taouage', ChoiceType::class,array(
                'label' => 'Taouage',
                'required' => true,
                'choices'  => [
                    "Oui" => 1,
                    "Non" => 0,
                ],
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('vaccined', ChoiceType::class,array(
                'label' => 'Vaccinés',
                'required' => true,
                'choices'  => [
                    "Oui" => 1,
                    "Non" => 0,
                ],
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('loof', ChoiceType::class,array(
                'label' => 'LOF',
                'required' => true,
                'choices'  => [
                    "Oui" => 1,
                    "Non" => 0,
                ],
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('dateNaissance', TextType::class,array(
                'label' => 'Date de naissance',
                'required' => false,
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control datepicker')
            ))
            ->add('dateDispo', TextType::class,array(
                'label' => 'Date de disponibilité',
                'required' => false,
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control datepicker')
            ))
            ->add('portee',NumberType::class,
            array(
                'label' => 'Nombre dans la portée',
                'required' => false,
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('certificat', ChoiceType::class,
            array(
                'label' => 'Certificat de bonne santé',
                'required' => true,
                'choices'  => [
                    "Certificat de bonne santé disponible" => 1,
                    "Pas de certificat de bonne santé disponible" => 0,
                ],
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('nbTatouage',TextType::class,
            array(
                'label' => 'Le tatouage',
                'required' => false,
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('race',EntityType::class,
                array('class' => Race::class,
                    'label' => 'La race',
                    'required' => true,
                    'error_bubbling' => true,
                    'attr' => array('class' => 'form-control')
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
