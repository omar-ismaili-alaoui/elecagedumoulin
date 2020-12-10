<?php

namespace App\Form;

use App\Entity\Prix;
use App\Entity\Race;
use App\Entity\Sexe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrixType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prix',TextType::class,
            array(
                'label' => 'Prix de la race',
                'required' => true,
                'error_bubbling' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('race',EntityType::class,
                array('class' => Race::class,
                    'label' => ' La race',
                    'required' => true,
                    'error_bubbling' => true,
                    'attr' => array('class' => 'form-control')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prix::class,
        ]);
    }
}
