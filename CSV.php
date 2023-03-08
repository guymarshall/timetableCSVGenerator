<?php

class CSV
{
    private array $data;

    /**
     * @throws Exception
     */
    public function add_data($newData): void
    {
        if (!is_array($newData)) {
            throw new Exception('Invalid data type. Only arrays can be appended.');
        }
        $this->data[] = $newData;
    }
    public function generate_csv(string $filename, array $field_headings, array $data): void
    {
        $file = fopen($filename, "w");
        if ($file === false)
        {
            die("Couldn't create $filename");
        }

        $headings = explode(",", rtrim(implode(",", $field_headings), ","));
        fputcsv($file, $headings);

        foreach ($data as $record)
        {
            $row = explode(",", rtrim(implode(",", $record), ","));
            fputcsv($file, $row);
        }

        fclose($file);
    }
}