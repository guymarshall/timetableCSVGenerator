<?php

/**
 * @throws Exception
 */
function file_to_array(string $filename): array {
    $file = fopen($filename, "r");
    if ($file === false) {
        throw new Exception("Unable to open file: $filename");
    }

    $words = [];
    while (($word = fgets($file)) !== false) {
        $words[] = trim($word);
    }
    fclose($file);

    return $words;
}

function get_names(string $filename): array {
    try {
        $names = file_to_array($filename);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit(1);
    }

    return $names;
}