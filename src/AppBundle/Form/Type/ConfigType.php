<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Config;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ConfigType
 * @package AppBundle\Form\Type
 */
class ConfigType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('voiceEnabled')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Config::class,
            ])
        ;
    }

    /**
     * @return string
     */
//    public function getName()
//    {
//        return 'appbundle_avatar_type';
//    }
}
