<?php

function generate_csv(string $filename, array $field_headings, array $data): void
{
    // $field_headings - remove trailing comma
    // $data - remove trailing comma
    // make separate function for each csv (without passing $filename, hardcode it in function instead)
    $file = fopen($filename, 'w');

    fputcsv($file, $field_headings);

    foreach ($data as $row)
    {
        fputcsv($file, $row);
    }

    fclose($file);
}

function add_quotes(string $input): string
{
    return '"'.$input.'"';
}

function array_to_string_with_quotes(array $input): string {
    $output = array_map(function ($value) {
        return add_quotes(strval($value));
    }, $input);

    return implode(", ", $output);
}

function generate_initials(string $first_name = '', string $middle_name = '', string $last_name = ''): string
{
    return $first_name[0].$middle_name[0].$last_name[0];
}