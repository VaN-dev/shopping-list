<?php

namespace AppBundle\Service\Comparator;

use AppBundle\Entity\RecipeIngredient;

/**
 * Class IngredientComparator
 * @package AppBundle\Service\Comparator
 */
class IngredientsComparator
{
    /**
     * @param RecipeIngredient $ingredient1
     * @param RecipeIngredient $ingredient2
     * @return bool
     */
    public function isSame(RecipeIngredient $ingredient1, RecipeIngredient $ingredient2)
    {
        return (
            $ingredient1->getIngredient()->getId() == $ingredient2->getIngredient()->getId()
            && $ingredient1->getQuantity() == $ingredient2->getQuantity()
        );
    }
}