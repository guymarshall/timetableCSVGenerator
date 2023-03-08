<?php

class Room {
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

    /*pub fn generate_room_csv(filename: &str, field_headings: Vec<&str>, data: Vec<Vec<(i32, &str, i32, String, String)>>) {
        for record in data {
            let line_including_trailing_comma: String = record
            .iter()
            .map(|cell| format!("{}, {}, {}", cell.0, cell.1, cell.2))
            .collect::<Vec<String>>()
            .join(",");
            let line: String = line_including_trailing_comma[0..].to_string();
            if let Err(why) = writeln!(file, "{}", line) {
                panic!("couldn't write to {}: {}", path.display(), why);
            }
        }
    }*/
}