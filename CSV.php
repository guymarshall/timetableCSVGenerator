<?php

class CSV
{
    private array $data;

    /**
     * @throws Exception
     */
    public function add_data($new_data): void
    {
        if (!is_array($new_data)) {
            throw new Exception("Invalid data type. Only arrays can be appended.");
        }
        $this->data[] = $new_data;
    }
    public function generate_csv(string $filename, array $field_headings): void
    {
        $file = fopen($filename, "w");
        if ($file === false)
        {
            die("Couldn't create $filename");
        }

        $headings = explode(",", rtrim(implode(",", $field_headings), ","));
        fputcsv($file, $headings);

        foreach ($this->data as $record)
        {
            $row = explode(",", rtrim(implode(",", $record), ","));
            fputcsv($file, $row);
        }

        fclose($file);
    }
}