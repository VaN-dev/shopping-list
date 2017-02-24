<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AvatarType
 * @package AppBundle\Form\Type
 */
class AvatarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//        $builder
//            ->add('avatar', ChoiceType::class, [
//                'choices' => [
//                    'boy' => 'boy',
//                ]
//            ])
//        ;
//    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                'boy' => 'boy',
            )
        ));
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

    /**
     * @return string
     */
//    public function getName()
//    {
//        return 'appbundle_avatar_type';
//    }
}
