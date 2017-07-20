<?php

namespace VT\UsersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use VT\TestsBundle\Repository\LabTestRepository;
use VT\VTCoreBundle\Services\Doctrine\VTEntityManager;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use VT\VTCoreBundle\Services\Utils;

class PatientCreateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                $builder->create('userVisit', FormType::class, array(
                    'label' => false
                ))
                ->add(
                    $builder->create('user', FormType::class, array(
                        'label' => false
                    ))
                    ->add('mobile', TextType::class, array(
                        'attr' => array(
                            'placeholder' => 'Enter Mobile',
                            'class' => 'form-control input-sm'
                        )
                    ))
                    ->add('name', TextType::class, array(
                        'attr' => array(
                            'placeholder' => 'Enter Name',
                            'class' => 'form-control input-sm'
                        )
                    ))
                    ->add('email', EmailType::class, array(
                        'attr' => array(
                            'placeholder' => 'Enter Email',
                            'class' => 'form-control input-sm'
                        )
                    ))
                    ->add('address', TextareaType::class, array(
                        'attr' => array(
                            'placeholder' => 'Enter Address',
                            'class' => 'form-control input-sm'
                        )
                    ))
                    ->add('city', TextType::class, array(
                        'attr' => array(
                            'placeholder' => 'Enter City',
                            'class' => 'form-control input-sm'
                        )
                    ))
                    ->add('gender', ChoiceType::class, array(
                        'choices' => array('Male' => 'm', 'Female' => 'f'),
                        'placeholder' => 'Select Gender',
                        'attr' => array(
                            'class' => 'form-control input-sm'
                        )
                    ))
                    ->add('dob', DateType::class, array(
                        'label' => 'Date of birth',
                        'widget' => 'single_text',
                        'html5' => false,
                        'format' => 'dd-MM-yyyy',
                        'attr' => array(
                            'class' => 'js-masked-date-dash form-control input-sm',
                            'placeholder' => "dd-mm-yyyy",
                        ),
                    ))
                )
                ->add('totalAmount', TextType::class, array(
                    'label' => false,
                    'attr' => array(
                        'class' => 'form-control input-sm',
                        'readonly' => 'readonly'
                    )
                ))
                ->add('discount', TextType::class, array(
                    'label' => false                    
                ))
                ->add('netAmount', TextType::class, array(
                    'label' => false,
                    'attr' => array(
                        'class' => 'form-control input-sm',
                        'readonly' => 'readonly'
                    )
                ))
                ->add('paidAmount', TextType::class, array(
                    'label' => false                    
                ))
                ->add('doctor', EntityType::class, array(
                    'class'=> 'UsersBundle:Doctor',
                    'placeholder' => 'Select Doctor',
                    'query_builder' => function (EntityRepository $er) {
                        return $er
                            ->createQueryBuilder('d')
                            ->where('d.deleted=0')
                            ->andWhere("d.lab='" . Utils::getLabID() . "'");
                    },
                    'choice_label' => 'name',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
            )
            ->add('labTest', HiddenType::class, array())
                       
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VT\UsersBundle\Entity\UserVisitTests',
            'allow_extra_fields' => true
        ));
    }
}
