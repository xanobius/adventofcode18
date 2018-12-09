<?php

namespace App\TwoEighteen;

use App\DayClass;
use App\TwoEighteen\Classes\LinkedListElement;
use phpDocumentor\Reflection\DocBlock\Tags\Link;
use Symfony\Component\Console\Command\ListCommand;

class Ninth extends DayClass
{
//    protected $filepath = '2018/day_09.txt';
//    protected $filepath = '2018/day_09.example.txt';

    public function primary()
    {
        // 428 players; last marble is worth 72061 points
        // 116381 -> to low

        /*
         * 10 players; last marble is worth 1618 points: high score is 8317
            13 players; last marble is worth 7999 points: high score is 146373
            17 players; last marble is worth 1104 points: high score is 2764
            21 players; last marble is worth 6111 points: high score is 54718
            30 players; last marble is worth 5807 points: high score is 37305
         */

        set_time_limit(60);

        // TESTS:
//        print 'TEST 0: ' . ($this->startGame(9, 25) == 32 ? 'SUCCESS' : 'FAILED');
//        print "<br>" . chr(10);
//        print 'TEST 1: ' . ($this->startGame(10, 1618) == 8317 ? 'SUCCESS' : 'FAILED');
//        print "<br>" . chr(10);
//        print 'TEST 2: ' . ($this->startGame(13, 7999) == 146373 ? 'SUCCESS' : 'FAILED');
//        print "<br>" . chr(10);
//        print 'TEST 3: ' . ($this->startGame(17, 1104) == 2764 ? 'SUCCESS' : 'FAILED');
//        print "<br>" . chr(10);
//        print 'TEST 4: ' . ($this->startGame(21, 6111) == 54718 ? 'SUCCESS' : 'FAILED');
//        print "<br>" . chr(10);
//        print 'TEST 5: ' . ($this->startGame(30, 5807) == 37305 ? 'SUCCESS' : 'FAILED');
//        print "<br>" . chr(10);


        $start = microtime(true);
        return [
            'Result: ' . $this->startGame(428, 72061),
            'Runtime: ' . microtime(true) - $start
        ];
    }

    public function secondary()
    {
        // last one 100 times larger : 428, 7'206'100
        // one time  : 409832
        // two times : 409832

        set_time_limit(120);
//        return $this->startGame(428, 72061);

        // 241 : 313147 (last item)
        // max:  409832 -> NOT the last item!

        // 100k : 65 secs
        // 110k : 82 secs
        // 120k : 98 secs /wo score : 97 secs ... no win (RES: 1'072'021)
        $start = microtime(true);

        return [
            $this->startListGame(428, 720610),
            microtime(true) - $start
        ];
    }

    private function startListGame($players, $marbles, $index = -1)
    {

        $scores = [];
        $multipleOf = 23;
        $cp = 0; // current player
        $currentElement = new LinkedListElement(0);
        for ($i = 1; $i <= $marbles; $i++) {
            $cp = $cp == $players ? 1 : $cp + 1;
            // place marble
            if ($i % $multipleOf == 0) {
                // the special case!
                if( ! array_key_exists($cp, $scores)){
                    $scores[$cp] = 0;
                }

                $currentElement = $currentElement
                    ->getBefore()
                    ->getBefore()
                    ->getBefore()
                    ->getBefore()
                    ->getBefore()
                    ->getBefore();

//                dd($currentElement->getBefore()->getValue());

                $scores[$cp] += $currentElement->getBefore()->getValue() + $i;
                $currentElement->getBefore()->remove();
            } else {
                // the normal case
                $currentElement = $currentElement->getAfter()->insertAfter($i);
            }
        }

        $max = 0;
        foreach($scores as $s){
            $max = $max < $s ? $s : $max;
        }

        return $max;
    }

    private function startGame($players, $marbles, $index = -1)
    {
        $gameBoard = [0];
        $scores = [];
        $cmp = 0; // current marble Position
        $cp = 0; // current player
        $multipleOf = 23;
        $leftPlaces = 7;
        for ($i = 1; $i <= $marbles; $i++) {
            // Go to next player
            $cp = $cp == $players ? 1 : $cp + 1;

            // place marble
            if ($i % $multipleOf == 0) {
                // the special case!
                if( ! array_key_exists($cp, $scores)){
                    $scores[$cp] = 0;
                }
                $scores[$cp] += $i;
                $cmp = $cmp - $leftPlaces;
                $cmp = $cmp >= 0 ? $cmp : count($gameBoard) + $cmp;
                $scores[$cp] += $gameBoard[$cmp];
                array_splice($gameBoard, $cmp, 1);
            } else {
                // the normal case

                // Enough space on the left?
                if ($cmp < count($gameBoard) - 1) {
                    $cmp = $cmp + 2;
                } else {
                    // Nope? well, index 1
                    $cmp = 1;
                }
                array_splice($gameBoard, $cmp, 0, [$i]);
            }

        }

        if($index == -1){
            $max = 0;
            foreach($scores as $s){
                $max = $max < $s ? $s : $max;
            }

            return $max;
        }else{
            return $scores[$index];
        }
    }

}