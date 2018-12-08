<?php

namespace App\TwoEighteen;

use App\DayClass;

class Eight extends DayClass
{
//    protected $filepath = '2018/day_08.txt';
    protected $filepath = '2018/day_08.example.txt';

    public function primary()
    {
        // to high: 10599
        // Correct: 10598 (duuude, the first one already was, but with a whitespace)

        set_time_limit(60);
        $inputs = $this->getInput()[0];
        $splited = explode(' ', $inputs);
        return $splited;
    }

    public function secondary()
    {
        $input = $this->getInput();
        return;
    }

}