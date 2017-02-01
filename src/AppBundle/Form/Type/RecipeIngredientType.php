<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\DataTransformer\IngredientToStringTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RecipeIngredientType
 * @package AppBundle\Form\Type
 */
class RecipeIngredientType extends AbstractType
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
            ->add('ingredient', TextType::class, [
            ])
            ->add('quantity')
            ->add('unit', EntityType::class, [
                'class' => 'AppBundle\Entity\Unit',
                'choice_label' => 'name',
            ])
        ;

        $builder->get('ingredient')
            ->addModelTransformer(new IngredientToStringTransformer($this->manager))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\RecipeIngredient',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_recipe_ingredient_type';
    }
}
