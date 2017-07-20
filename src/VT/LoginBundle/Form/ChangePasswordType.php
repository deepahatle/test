<?php 

namespace VT\LoginBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('oldPassword', PasswordType::class, array(
            'attr' => array(
                'placeholder' => 'Enter your old password',
                'class' => 'form-control',
                'autocomplete' => 'off'
                )
            ))
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

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VT\LoginBundle\Form\Model\ChangePassword',
        ));
    }

    public function getName()
    {
        return 'change_passwd';
    }
}