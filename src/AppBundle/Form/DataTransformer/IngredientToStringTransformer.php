<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Ingredient;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class IngredientToStringTransformer
 * @package AppBundle\Form\DataTransformer
 */
class IngredientToStringTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * IngredientToStringTransformer constructor.
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (ingredient) to a string (number).
     *
     * @param  Ingredient|null $ingredient
     * @return string
     */
    public function transform($ingredient)
    {
        if (null === $ingredient) {
            return '';
        }

        return $ingredient->getName();
    }

    /**
     * Transforms a string (number) to an object (ingredient).
     *
     * @param  string $ingredientName
     * @return Ingredient|null
     * @throws TransformationFailedException if object (ingredient) is not found.
     */
    public function reverseTransform($ingredientName)
    {
        // no ingredient number? It's optional, so that's ok
        if (!$ingredientName) {
            return;
        }

        $ingredient = $this->manager
            ->getRepository('AppBundle:Ingredient')
            // query for the ingredient with this id
            ->findOneBy(['name' => $ingredientName])
        ;

        if (null === $ingredient) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
//            throw new TransformationFailedException(sprintf(
//                'An ingredient with name "%s" does not exist!',
//                $ingredientName
//            ));

            $ingredient = new Ingredient();
            $ingredient
                ->setName($ingredientName)
            ;

//            $this->manager->persist($ingredient);
        }

        return $ingredient;
    }
}