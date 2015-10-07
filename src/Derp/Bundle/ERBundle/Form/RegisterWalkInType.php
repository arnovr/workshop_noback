<?php

namespace Derp\Bundle\ERBundle\Form;

use Derp\Application\RegisterWalkIn;
use Derp\Domain\Model\Sex;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterWalkInType extends AbstractType
{
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'register_walk_in';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', array('label' => 'firstName'))
            ->add('lastName', 'text', array('label' => 'lastName'))
            ->add(
                'sex',
                'choice',
                [
                    'label' => 'sex',
                    'choices' => [Sex::MALE => 'Male', Sex::FEMALE => 'Female', Sex::INTERSEX => 'Intersex']
                ]
            )
            ->add(
                'dateOfBirth',
                'date',
                [
                    'label' => 'Date of birth (if you don\'t know, guess)',
                    'years' => range(date('Y'), date('Y') - 120),
                    // Use this option to make the underlying format a string (instead of a DateTime object)
                    'input' => 'string'
                ]
            )
            ->add('indication', 'textarea', array('label' => 'textarea'))
            ->add('submit', 'submit');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RegisterWalkIn::class
        ]);
    }
}
