<?php
namespace App\Http\Controllers;

use App\TwoEighteen\Fifteenth;
use App\TwoEighteen\Eight;
use App\TwoEighteen\Eleventh;
use App\TwoEighteen\Fifth;
use App\TwoEighteen\Fourteenth;
use App\TwoEighteen\Ninth;
use App\TwoEighteen\Seventh;
use App\TwoEighteen\Sixth;
use App\TwoEighteen\Tenth;
use App\TwoEighteen\Thirdteenth;
use App\TwoEighteen\Twelveth;

class Advent2018Controller extends Controller
{

    public function getDayResult($day, $second = false)
    {
        $days = [
            '5' => Fifth::class,
            '6' => Sixth::class,
            '7' => Seventh::class,
            '8' => Eight::class,
            '9' => Ninth::class,
            '10' => Tenth::class,
            '11' => Eleventh::class,
            '12' => Twelveth::class,
            '13' => Thirdteenth::class,
            '14' => Fourteenth::class,
            '15' => Fifteenth::class,
        ];

        $instance = new $days[$day]();

        if($second)
            return $instance->secondary();
        return $instance->primary();
    }
}