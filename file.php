<?php

function file_to_array(string $filename): array|false {
    $file = fopen($filename, "r");
    if ($file === false) {
        return false;
    }

    $words = [];
    while (($word = fgets($file)) !== false) {
        $words[] = trim($word);
    }
    fclose($file);

    return $words;
}

function get_names(string $filename): array
{
    $names = file_to_array($filename);
    if ($names === false) {
        echo "An error occurred when trying to open the file.";
        exit(1);
    }

    return $names;
}