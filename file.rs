#![forbid(unsafe_code)]

use std::fs::File;
use std::io::{BufRead, BufReader, Error};

pub fn get_names(filename: &str) -> Vec<String> {
    file_to_vector(filename).unwrap_or_else(|error| {
        eprintln!("An error occurred when trying to open the file: {}", error);
        std::process::exit(1);
    })
}