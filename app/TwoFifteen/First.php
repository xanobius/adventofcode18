<?php

namespace App\TwoFifteen;

use App\DayClass;

class First extends DayClass
{
    protected $filepath = '2015/day_01.example.txt';

    public function primary()
    {
        $input = $this->getInput();
        return $input;
    }
}