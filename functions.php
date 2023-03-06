<?php

function get_random_name(string $filename) {
    $contents = file_get_contents($filename);
    $first_names = explode("\n", $contents);

    $key = array_rand($first_names);
    $first_name = $first_names[$key];
    return $first_name;
}

function generate_csv(string $filename, array $field_headings, array $data) {
    $file = fopen($filename, 'w');

    fputcsv($file, $field_headings);

    foreach ($data as $row) {
        fputcsv($file, $row);
    }

    fclose($file);
}

function generate_initials(string $first_name = '', string $middle_name = '', string $last_name = '') {
    return $first_name[0].$middle_name[0].$last_name[0];
}