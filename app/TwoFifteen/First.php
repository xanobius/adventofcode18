<?php

namespace App\TwoFifteen;

use App\DayClass;

class First extends DayClass
{
    protected $filepath = '2015/day_01.txt';

    public function primary()
    {
        $input = $this->getInput()[0];
        $res = 0;
        for($i = 0; $i < strlen($input); $i++){
            $res += $input[$i] == '(' ? 1 : -1;
        }
        return $res;
    }

    public function secondary()
    {
        $input = $this->getInput()[0];
        $res = 0;
        for($i = 0; $i < strlen($input); $i++){
            $res += $input[$i] == '(' ? 1 : -1;
            if($res == -1) return $i + 1;
        }
        return $res;
    }
}