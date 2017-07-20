<?php 

namespace VT\LoginBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordAfterResetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('newPassword', RepeatedType::class, array(
            'type' => PasswordType::class,
            'first_options' => array(
                'label' => 'Password',
                'attr' => array(
                    'placeholder' => 'Enter your new password',
                    'class' => 'form-control',
                    'autocomplete' => 'off'
                    )),
            'second_options' => array(
                'label' => 'Repeat Password',
                'attr' => array(
                    'placeholder' => 'Confirm password',
                    'class' => 'form-control'
                    )),
            ));
    }
}