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

    $result = implode(", ", $output);
    return substr($result, 0, -2);
}

function generate_initials(string $first_name = '', string $middle_name = '', string $last_name = ''): string
{
    return $first_name[0].$middle_name[0].$last_name[0];
}

function generate_curriculum_csv($filename, $field_headings, $data) {
    $file = fopen($filename, "w");
    if ($file === false) {
        die("Couldn't create $filename");
    }

    $headings = implode(",", $field_headings);
    if (fwrite($file, $headings . "\n") === false) {
        die("Couldn't write to $filename");
    }

    foreach ($data as $record) {
        $line_including_trailing_comma = implode(",", $record);
        $line = rtrim($line_including_trailing_comma, ",");
        if (fwrite($file, $line . "\n") === false) {
            die("Couldn't write to $filename");
        }
    }

    fclose($file);
}