<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserType
 * @package AppBundle\Form\Type
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Passwords don\'t match.',
                'required' => false,
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
            ->add('avatar', AvatarType::class, [
                'expanded' => true,
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => 'AppBundle\Entity\User',
            ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_user_type';
    }
}
