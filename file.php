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