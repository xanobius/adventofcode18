<?php

namespace App\TwoEighteen;

use App\DayClass;
use App\TwoEighteen\Classes\BakerElve;
use App\TwoEighteen\Classes\RecipeListItem;
use Illuminate\Support\Collection;
use Symfony\Component\Translation\Tests\Writer\BackupDumper;

class Fourteenth extends DayClass
{

    public function primary()
    {
        ini_set('xdebug.max_nesting_level', 1000);
        ini_set('memory_limit', '4G');
        set_time_limit(120);
        gc_disable();

        $firstRecipe = new RecipeListItem(3, null, null, true);
        $firstRecipe->insertAfter(7);

        $elves = collect([new BakerElve($firstRecipe), new BakerElve($firstRecipe->getAfter())]);


//        return $this->getRecipesAfter($elves, 9) == '5158916779' ? 'SUCCESS' : 'FAIL';
//        return $this->getRecipesAfter($elves, 5) == '0124515891' ? 'SUCCESS' : 'FAIL';
//        return $this->getRecipesAfter($elves, 18) == '9251071085' ? 'SUCCESS' : 'FAIL';
//        return $this->getRecipesAfter($elves, 2018) == '5941429882' ? 'SUCCESS' : 'FAIL';

        return $this->getRecipesAfter($elves, 824501);
    }

    public function secondary()
    {
        ini_set('xdebug.max_nesting_level', 1000);
        ini_set('memory_limit', '4G');
        set_time_limit(300);
        gc_disable();

        $firstRecipe = new RecipeListItem(3, null, null, true);
        $firstRecipe->insertAfter(7);

        $elves = collect([new BakerElve($firstRecipe), new BakerElve($firstRecipe->getAfter())]);

//        return $this->getRecipesAfterRounds($elves, '51589');
//        return $this->getRecipesAfterRounds($elves, '51589') == 9 ? 'SUCCESS' : 'FAIL';
//        return $this->getRecipesAfterRounds($elves, '01245') == 5 ? 'SUCCESS' : 'FAIL';
//        return $this->getRecipesAfterRounds($elves, '92510') == 18 ? 'SUCCESS' : 'FAIL';
//        return $this->getRecipesAfterRounds($elves, '59414');
//        return $this->getRecipesAfterRounds($elves, '59414') == 2018 ? 'SUCCESS' : 'FAIL';

        // first appereance of 501: 777'613

        return $this->getRecipesAfterRounds($elves, '01');
        return $this->getRecipesAfterRounds($elves, '450');
        return $this->getRecipesAfterRounds($elves, '24501');
        return $this->getRecipesAfterRounds($elves, '824501');
    }

    private function printRecipeLine(RecipeListItem $recipeListItem)
    {
        $item = $recipeListItem->getFirst();
        while (!$item->isLast()) {
            print $item->getValue() . ' - ';
            $item = $item->getAfter();
        }
        print $item->getValue();
    }

    /**
     * @param Collection
     * @param $rounds
     * @return string
     */
    private function getRecipesAfter($elves, $rounds)
    {
        $recipeItem = $elves->first()->getCurrentRecipe();
        $recipeItem = $recipeItem->getFirst();


        $start = microtime(true);

        $total = $recipeItem->getFirst()->getTotal();

        $recipeItem = $recipeItem->getLast();
        while ($total < ($rounds + 10)) {
            $newRecipes = $elves->sum(function (BakerElve $bakerElve) {
                return $bakerElve->getCurrentRecipe()->getValue();
            });

            $newRecipes = strval($newRecipes);
            for ($j = 0; $j < strlen($newRecipes); $j++) {
                $recipeItem = $recipeItem->insertAfter((int)($newRecipes[$j]));
                $total++;
            }
//            $this->printRecipeLine($recipeItem);
//            print chr(10);

            $elves->each(function (BakerElve $bakerElve) {
                $bakerElve->selectNextRecipe();
            });
        }


        /**
         * $startpoint = $recipeItem->getElementX($rounds);
         * /*
         */
        $recipeItem = $recipeItem->getLast();
        $str = $recipeItem->getValue();
        for ($i = 0; $i < 9; $i++) {
            $recipeItem = $recipeItem->getBefore();
            $str = $recipeItem->getValue() . $str;
        }

        return $str;
    }


    /**
     * @param Collection
     * @param $rounds
     * @return string
     */
    private function getRecipesAfterRounds($elves, $rounds)
    {
        $recipeItem = $elves->first()->getCurrentRecipe();
        $recipeItem = $recipeItem->getFirst();
        $alwaysFirst = $recipeItem;
        $roundsSize = strlen($rounds);


        $start = microtime(true);

        $total = $recipeItem->getFirst()->getTotal();

        $recipeItem = $recipeItem->getLast();
        while ($total < 50000) {
            $newRecipes = $elves->sum(function (BakerElve $bakerElve) {
                return $bakerElve->getCurrentRecipe()->getValue();
            });

            $newRecipes = strval($newRecipes);
            for ($j = 0; $j < strlen($newRecipes); $j++) {
                $recipeItem = $recipeItem->insertAfter((int)($newRecipes[$j]));
                $total++;
            }

//
//            $starter = $recipeItem->getLast();
//            $str = $starter->getValue();
//            for ($i = 0; $i < $roundsSize - 1; $i++) {
//                $starter = $starter->getBefore();
//                $str = $starter->getValue() . $str;
//            }
//            if($str == $rounds) return $total - $roundsSize ;

            $starter = $recipeItem->getLast();
            if ($starter->getValue() == $rounds[$roundsSize - 1]) {
                for ($i = 0; $i < $roundsSize - 1; $i++) {

//                    // Alternativ algorithm
                    $starter = $starter->getBefore();
                    if ($rounds[$roundsSize - 2 - $i] != $starter->getValue()) {
                        break;
                    }
                    if ($i == ($roundsSize - 2)) {
//                        $this->printRecipeLine($alwaysFirst);
                        print $total . chr(10);
//                        return chr(10) . ($total - $roundsSize);
                    }
                }
            }


//            $this->printRecipeLine($recipeItem);
//            print chr(10);

            $elves->each(function (BakerElve $bakerElve) {
                $bakerElve->selectNextRecipe();
            });
        }

        return 'not found :( Time: ' . (microtime(true) - $start);
    }

}