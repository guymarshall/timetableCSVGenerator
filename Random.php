<?php

class Random
{
    public static function random_name(array $names): string
    {
        $min = 0;
        $max = count($names) - 1;

        return $names[rand($min, $max)];
    }

    public static function day_from_int(int $day_int): string
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return $days[$day_int];
    }

    public static function random_room(): string
    {
        $rooms = ["Ma1", "Ma2", "Ma3", "Ma4", "Ma5", "Ma6", "Ma7", "Ma8", "Ma9", "DT1", "DT2", "DT3", "DT4", "DT5", "IT1", "IT2", "IT3", "La1", "La2", "La3", "La4", "La5", "History1", "History2", "History3", "Geography1", "Geography2", "Geography3", "Sc1", "Sc2", "Sc3", "Sc4", "Sc5", "Sc6", "Sc7", "Sc8", "Eng1", "Eng2", "Eng3", "Eng4", "Eng5", "Eng6", "Eng7", "Eng8", "Music1", "Music2", "Drama1", "Drama2", "PE"];

        $min = 0;
        $max = count($rooms) - 1;
        return $rooms[rand($min, $max)];
    }

    public static function random_length_random_array(): array
    {
        $length = rand(1, 11);
        $output = [];
        for ($i = 0; $i < $length; $i++)
        {
            $output[] = rand(1, 11);
        }
        return $output;
    }

    public static function random_teacher_type(string $type_type): string
    {
        $names = ["Teacher", "Cover Teacher", "Trainee Teacher", "Head of Department"];
        $display_names = ["Teacher", "Cover", "Trainee", "Head"];

        if ($type_type == 'name')
        {
            return $names[rand(0, count($names))];
        }
        else if ($type_type == 'displayName')
        {
            return $display_names[rand(0, count($display_names))];
        }
        else
        {
            return $names[0];
        }
    }

    public static function random_subject_name(): string
    {
        $subject_names = ["Maths", "Biology", "Chemistry", "Physics", "History", "Geography", "ICT", "German", "French", "DT", "PE", "English", "Personal Development", "RE"];

        $min = 0;
        $max = count($subject_names) - 1;
        return $subject_names[rand($min, $max)];
    }
}