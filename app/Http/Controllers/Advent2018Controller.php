<?php
namespace App\Http\Controllers;

use App\TwoEighteen\Fifth;
use App\TwoEighteen\Seventh;
use App\TwoEighteen\Sixth;

class Advent2018Controller extends Controller
{

    public function getDayResult($day, $second = false)
    {
        $days = [
            '5' => Fifth::class,
            '6' => Sixth::class,
            '7' => Seventh::class,
        ];

        $instance = new $days[$day]();

        if($second)
            return $instance->secondary();
        return $instance->primary();
    }
}