<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\ShoppingListRecipe;
use AppBundle\Form\DataTransformer\RecipeToNumberTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ShoppingListRecipeType
 * @package AppBundle\Form\Type
 */
class ShoppingListRecipeType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * ShoppingListRecipeType constructor.
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recipe', HiddenType::class, [
                'invalid_message' => 'That is not a valid recipe number',
            ])
            ->add('people', TextType::class)
        ;

        $builder->get('recipe')
            ->addModelTransformer(new RecipeToNumberTransformer($this->manager));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ShoppingListRecipe::class,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_shopping_list_recipe_type';
    }
}
