<?php
namespace App\Http\Controllers;

use App\TwoEighteen\Fifth;

class Advent2018Controller extends Controller
{

    public function getDayResult($day, $second = false)
    {
        $days = [
            '5' => Fifth::class,
        ];

        $instance = new $days[$day]();

        if($second)
            return $instance->secondary();
        return $instance->primary();
    }
}