<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 6/5/16
 * Time: 6:45 PM
 */

namespace VT\LoginBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VT\VTCoreBundle\Services\Utils;

class UserCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Lab Name',
                'attr' => array(
                    'placeholder' => 'Enter your Laboratory Name',
                    'class' => 'form-control'
                )
            ))
            ->add('mobileNo', TextType::class, array(
                'label' => 'Mobile no.',
                'attr' => array(
                    'placeholder' => 'Enter your Mobile No.',
                    'class' => 'form-control'
                )
            ))
            ->add('username', TextType::class, array(
                'label' => 'Username/Email',
                'attr' => array(
                    'placeholder' => 'Enter your Username/Email',
                    'class' => 'form-control',
                    'autocomplete' => 'off'
                )
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array(
                    'label' => 'Password',
                    'attr' => array(
                        'placeholder' => 'Enter your Password',
                        'class' => 'form-control',
                        'autocomplete' => 'off'
                    )),
                'second_options' => array(
                    'label' => 'Repeat Password',
                    'attr' => array(
                        'placeholder' => 'Confirm Password',
                        'class' => 'form-control'
                    )),
                )
            )
            ->add('package', HiddenType::class, array(
                "mapped" => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VT\LoginBundle\Entity\Login'
        ));
    }
}