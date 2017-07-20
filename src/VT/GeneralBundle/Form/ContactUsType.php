<?php

namespace VT\GeneralBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/06/17
 * Time: 10:27 AM
 */
class ContactUsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Name',
                'attr' => array(
                    'placeholder' => 'Enter your Name',
                    'class' => 'form-control'
                )
            ))
            ->add('phoneNumber', TextType::class, array(
                'label' => 'Phone Number',
                'attr' => array(
                    'placeholder' => 'Enter your Phone Number',
                    'class' => 'form-control'
                )
            ))
            ->add('emailId', TextType::class, array(
                'label' => 'Email Address',
                'attr' => array(
                    'placeholder' => 'Enter your Email Address',
                    'class' => 'form-control',
                    'autocomplete' => 'off'
                )
            ))
            ->add('message', TextareaType::class, array(
                'label' => 'Message',
                'attr' => array(
                    'placeholder' => 'Anything you want to say?',
                    'class' => 'form-control'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\VT\GeneralBundle\Form\Model\ContactUs'
        ));
    }
}