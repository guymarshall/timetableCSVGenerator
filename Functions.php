<?php

class Functions
{
    public static function add_quotes(string $input): string
    {
        return '"'.$input.'"';
    }

    public static function array_to_quoted_string(array $input): string
    {
        $output = array_map(function ($value)
        {
            return self::add_quotes(strval($value));
        }, $input);

        $result = implode(", ", $output);
        return substr($result, 0, -2);
    }

    public static function generate_initials(string $first_name = '', string $middle_name = '', string $last_name = ''): string
    {
        return $first_name[0].$middle_name[0].$last_name[0];
    }
}