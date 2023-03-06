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

function random_room(): string
{
    $rooms = ["Ma1", "Ma2", "Ma3", "Ma4", "Ma5", "Ma6", "Ma7", "Ma8", "Ma9", "DT1", "DT2", "DT3", "DT4", "DT5", "IT1", "IT2", "IT3", "La1", "La2", "La3", "La4", "La5", "History1", "History2", "History3", "Geography1", "Geography2", "Geography3", "Sc1", "Sc2", "Sc3", "Sc4", "Sc5", "Sc6", "Sc7", "Sc8", "Eng1", "Eng2", "Eng3", "Eng4", "Eng5", "Eng6", "Eng7", "Eng8", "Music1", "Music2", "Drama1", "Drama2", "PE"];

    $min = 0;
    $max = count($rooms) - 1;
    return $rooms[rand($min, $max)];
}

function random_length_random_array(): array
{
    $length = rand(1, 11);
    $output = [];
    for ($i = 0; $i < $length; $i++) {
        $output[] = rand(1, 11);
    }
    return $output;
}

function random_teacher_type(string $type_type): string
{
    $names = ["Teacher", "Cover Teacher", "Trainee Teacher", "Head of Department"];
    $display_names = ["Teacher", "Cover", "Trainee", "Head"];

    switch ($type_type)
    {
        case 'name':
            $min = 0;
            $max = count($names) - 1;

            return $names[rand($min, $max)];
        case 'display_name':
            $min = 0;
            $max = count($display_names) - 1;

            return $display_names[rand($min, $max)];
        default:
            return $names[0];
    }
}