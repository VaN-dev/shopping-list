<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RegistrationType
 * @package AppBundle\Form\Type
 */
class RegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
                'label' => 'Username',
                'attr' => [
                    'placeholder' => 'Username',
                ]
            ])
            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'invalid_message' => 'E-mails don\'t match.',
                'first_options'  => array(
                    'label' => 'E-mail',
                    'attr' => array(
                        'placeholder' => 'E-mail',
                    ),
                ),
                'second_options'  => array(
                    'label' => 'Confirm e-mail',
                    'attr' => array(
                        'placeholder' => 'Confirm e-mail',
                    ),
                ),
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Passwords don\'t match.',
                'first_options'  => array(
                    'label' => 'Password',
                    'attr' => array(
                        'placeholder' => 'Password',
                    ),
                ),
                'second_options'  => array(
                    'label' => 'Confirm password',
                    'attr' => array(
                        'placeholder' => 'Confirm password',
                    ),
                ),
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver); // TODO: Change the autogenerated stub
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'van_userbundle_usertype';
    }
}
