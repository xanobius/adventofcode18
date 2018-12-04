<?php
namespace App\Http\Controllers;


use App\TwoFifteen\First;

class AdventController extends Controller
{

    public function getDayResult($day, $second = 0)
    {
        $days = [
            '1' => First::class
        ];

        $instance = new $days[$day]();
        return $instance->primary();
    }
}
