<?php

function random_name(array $names): string
{
    $min = 0;
    $max = count($names) - 1;

    return $names[rand($min, $max)];
}

function day_from_int(int $day_int): string
{
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    return $days[$day_int];
}