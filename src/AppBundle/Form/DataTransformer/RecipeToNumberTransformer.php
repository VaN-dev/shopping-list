<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Recipe;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class RecipeToNumberTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (recipe) to a string (number).
     *
     * @param  Recipe|null $recipe
     * @return string
     */
    public function transform($recipe)
    {
        if (null === $recipe) {
            return '';
        }

        return $recipe->getId();
    }

    /**
     * Transforms a string (number) to an object (recipe).
     *
     * @param  string $recipeNumber
     * @return Recipe|null
     * @throws TransformationFailedException if object (recipe) is not found.
     */
    public function reverseTransform($recipeNumber)
    {
        // no recipe number? It's optional, so that's ok
        if (!$recipeNumber) {
            return;
        }

        $recipe = $this->manager
            ->getRepository('AppBundle:Recipe')
            // query for the recipe with this id
            ->find($recipeNumber)
        ;

        if (null === $recipe) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An recipe with number "%s" does not exist!',
                $recipeNumber
            ));
        }

        return $recipe;
    }
}