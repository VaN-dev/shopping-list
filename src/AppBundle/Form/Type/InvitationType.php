<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class InvitationType
 * @package AppBundle\Form\Type
 */
class InvitationType extends AbstractType
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * InvitationType constructor.
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mails', null, [
                'label' => 'Inviter des amis à rejoindre shopping-list :',
                'attr' => [
                    'placeholder' => 'jean-michel@gmail.com, micheline@yahoo.fr',
                ],
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
                'action' => $this->router->generate('app.friend.invitation'),
            ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_invitation_type';
    }
}
