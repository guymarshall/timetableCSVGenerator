<?php

class TeacherType {
    public function generate_csv(string $filename, array $field_headings, array $data): void {
        $file = fopen($filename, "w");
        if ($file === false) {
            die("Couldn't create $filename");
        }

        $headings = explode(",", rtrim(implode(",", $field_headings), ","));
        fputcsv($file, $headings);

        foreach ($data as $record) {
            $row = explode(",", rtrim(implode(",", $record), ","));
            fputcsv($file, $row);
        }

        fclose($file);
    }

    /*pub fn generate_teacher_type_csv(filename: &str, field_headings: Vec<&str>, data: Vec<Vec<(i32, String, String, String, String)>>) {
        let path: &Path = Path::new(filename);
        let mut file: File = match File::create(&path) {
            Err(why) => panic!("couldn't create {}: {}", path.display(), why),
            Ok(file) => file,
        };

        let headings_including_trailing_comma: String = field_headings.iter().map(|&heading| heading.to_string() + ",").collect();
        let headings: String = headings_including_trailing_comma[0..].to_string();
        if let Err(why) = writeln!(file, "{}", headings) {
            panic!("couldn't write to {}: {}", path.display(), why);
        }

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