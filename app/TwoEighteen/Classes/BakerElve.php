<?php

namespace App\TwoEighteen\Classes;

class BakerElve
{

    /**
     * @var RecipeListItem
     */
    private $startRecipe;
    /**
     * @var RecipeListItem
     */
    private $currentRecipe;

    public function __construct(RecipeListItem $startRecipe)
    {
        $this->startRecipe = $startRecipe;
        $this->currentRecipe = $startRecipe;
    }

    public function selectNextRecipe()
    {
        $loops = $this->getCurrentRecipe()->getValue() + 1;
        for($i = 0; $i < $loops; $i++){
            $this->currentRecipe = $this->currentRecipe->getAfter();
        }
    }

    /**
     * @return RecipeListItem
     */
    public function getStartRecipe(): RecipeListItem
    {
        return $this->startRecipe;
    }

    /**
     * @param RecipeListItem $startRecipe
     */
    public function setStartRecipe(RecipeListItem $startRecipe): void
    {
        $this->startRecipe = $startRecipe;
    }

    /**
     * @return RecipeListItem
     */
    public function getCurrentRecipe(): RecipeListItem
    {
        return $this->currentRecipe;
    }

    /**
     * @param RecipeListItem $currentRecipe
     */
    public function setCurrentRecipe(RecipeListItem $currentRecipe): void
    {
        $this->currentRecipe = $currentRecipe;
    }



}