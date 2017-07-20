<?php 

namespace VT\LabsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use VT\TestsBundle\Repository\DepartmentMasterRepository;
use VT\VTCoreBundle\Services\Doctrine\VTEntityManager;

class TestCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('department', EntityType::class, array(
                'class'=> 'TestsBundle:DepartmentMaster',
                'placeholder' => 'Please select Department',
                'query_builder' => function (EntityRepository $er) {
                    return $er
                    	->createQueryBuilder('d')
                    	->where('d.deleted=0');
                },
                'mapped' => false,
                'choice_label' => 'name',
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('test', EntityType::class, array(
                'class'=> 'TestsBundle:TestMaster',
                'placeholder' => 'Please select Test',
                'query_builder' => function (EntityRepository $er) {
                    return $er
	                    ->createQueryBuilder('t')
	                    ->where('t.deleted=0')
	                    ->setMaxResults(1);
                },
                'choice_label' => 'name',
                'attr' => array(
                    'class' => 'form-control',
                    'disabled' => 'disabled'
                )
            ))
            ->add('cost', TextType::class, array(
                'label' => 'Cost',
                'attr' => array(
                    'placeholder' => 'Enter Test Cost',
                    'class' => 'form-control'
                )
            ));
    }
}