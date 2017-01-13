<?php

namespace AppBundle\Service\Grouper;

use AppBundle\Entity\ShoppingList;
use AppBundle\Service\Comparator\IngredientsComparator;

/**
 * Class IngredientsGrouper
 * @package AppBundle\Service\Grouper
 */
class IngredientsGrouper
{
    /**
     * @var IngredientsComparator
     */
    private $ingredientsComparator;

    /**
     * IngredientsGrouper constructor.
     * @param IngredientsComparator $ingredientsComparator
     */
    public function __construct(IngredientsComparator $ingredientsComparator)
    {
        $this->ingredientsComparator = $ingredientsComparator;
    }

    /**
     * @param ShoppingList $shoppingList
     */
    public function groupFromShoppingList(ShoppingList $shoppingList)
    {
        foreach ($shoppingList->getRecipes() as $shoppingListRecipe) {
            foreach ($shoppingListRecipe->getRecipe()->getIngredients() as $recipeIngredient) {
                $exists = false;

                foreach ($shoppingList->getGroupedIngredients() as &$groupedIngredient) {
                    $exists = $this->ingredientsComparator->isSame($groupedIngredient, $recipeIngredient);

                    if ($exists) {
                        $groupedIngredient->setQuantity($groupedIngredient->getQuantity() + $recipeIngredient->getQuantity());
                        break;
                    }
                }

                if (false === $exists) {
                    $shoppingList->addGroupedIngredient(clone $recipeIngredient);
                }
            }
        }
    }
}