<?php

namespace App\TwoFifteen;

use App\DayClass;

class Second extends DayClass
{
    protected $filepath = '2015/day_02.txt';

    public function primary()
    {
        $input = $this->getInput();
        $surface = 0;
        foreach($input as $line){
            preg_match('/(\d+)x(\d+)x(\d+)/', $line, $dims);
            $a = $dims[1] * $dims[2];
            $b = $dims[1] * $dims[3];
            $c = $dims[2] * $dims[3];

            $add = ($a <= $b && $a <= $c) ? $a :
                (($b <= $a && $b <= $c) ? $b : $c);

            $surface = $surface + (2 * ($a + $b + $c) + $add);
        }
        return $surface;
    }

    public function secondary()
    {

        $input = $this->getInput();
        $ribbon = 0;
        foreach($input as $line){
            preg_match('/(\d+)x(\d+)x(\d+)/', $line, $dims);
            $a = $dims[1];
            $b = $dims[2];
            $c = $dims[3];


            $toMutch = ($a >= $b && $a >= $c) ? $a :
                (($b >= $a && $b >= $c) ? $b : $c);

            $ribbon = $ribbon + ($a * $b * $c) + 2 * ($a + $b + $c - $toMutch);
        }
        return $ribbon;
    }
}