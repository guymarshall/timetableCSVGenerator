<?php

function random_name(array $names): string
{
    $min = 0;
    $max = count($names) - 1;

    return $names[rand($min, $max)];
}