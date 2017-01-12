<?php

namespace AppBundle\Service\Grouper;

use AppBundle\Entity\ShoppingList;

/**
 * Class IngredientsGrouper
 * @package AppBundle\Service\Grouper
 */
class IngredientsGrouper
{
    /**
     * @param ShoppingList $shoppingList
     * @return array
     */
    public function groupFromShoppingList(ShoppingList $shoppingList)
    {
        $output = [];

        foreach ($shoppingList->getRecipes() as $shoppingListRecipe) {
            foreach ($shoppingListRecipe->getRecipe()->getIngredients() as $recipeIngredient) {

            }
        }

        return $output;
    }
}