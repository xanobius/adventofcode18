<?php

namespace App\TwoEighteen;

use App\DayClass;

class Fifth extends DayClass
{
    protected $filepath = '2018/day_05.txt';
    private $recLimit = 400;

    public function primary()
    {
        // to high: 10599
        // Correct: 10598 (duuude, the first one already was, but with a whitespace)

        set_time_limit(60);
        $inputs = $this->getInput();
        return $this->handleInputs($inputs);
    }

    public function secondary()
    {
        /*
         * K:
         * L:
         * M:
         * N:
         * O:
         * P:
         * Q:
         * R:
         * S:
         * T:
         * U:
         * V:
         * W:
         * X:
         * Y:
         * Z:
         *
         *
         * J: 5312
         * C: 10136
         * E: 10150
         * G: 10158
         * H: 10162
         * A: 10174
         * D: 10174
         * B: 10180
         * F: 10184
         * I: 10200
         *
         */
        set_time_limit(120);
        $input = $this->getInput();
        for($i = 0; $i < count($input); $i++){
            $input[$i] = str_replace('j', '', str_replace('J', '', $input[$i]));
        }
        return $this->handleInputs($input);
    }

    private function handleInputs($inputs)
    {
        $str = '';
        foreach($inputs as $input){
            $poly = [$input, $this->recLimit];
            for($i = 0; $i < 200; $i++){
                $poly = $this->reducePolymere($poly[0]);
            }
            $str .= trim($poly[0]);
        }

        $fine = $this->recLimit;
        while($fine == $this->recLimit){
            $final = $this->reducePolymere($str);
            $fine = $final[1];
            $str = $final[0];
        }

        return strlen($final[0]);
    }

    private function reducePolymere($polymere, $count = 0)
    {
        $count++;
//        if($count > $this->recLimit * 0.9){
//            $start = rand(1, (int)(strlen($polymere) * 0.9));
//        }else{
            $start = 1;
//        }
        for($i = $start; $i < strlen($polymere); $i++){
            if(abs(ord($polymere[$i]) - ord($polymere[$i - 1])) ==  32){
                $a = substr($polymere, 0, $i-1);
                $b = substr($polymere, $i + 1);
                if($count == $this->recLimit){
                    return [$polymere, $count];
                }
                return $this->reducePolymere($a . $b, $count);
//                return substr()
            }
        }
        return [$polymere, $count];
    }
}