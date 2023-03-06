#![forbid(unsafe_code)]

use std::ops::{Range, RangeInclusive};
use rand::prelude::*;
use rand::distributions::uniform::Uniform;

pub fn random_teacher_type(type_type: &str) -> String {
    let names: [&str; 4] = ["Teacher", "Cover Teacher", "Trainee Teacher", "Head of Department"];
    let display_names: [&str; 4] = ["Teacher", "Cover", "Trainee", "Head"];

    let mut rng: ThreadRng = thread_rng();
    let range: Range<usize> = 0..names.len();

    match type_type {
        "name" => (&names[rng.gen_range(range)]).to_string(),
        "displayName" => (&display_names[rng.gen_range(range)]).to_string(),
        _ => (&names[0]).to_string(),
    }
}

pub fn random_subject_name() -> String {
    let subjects: Vec<&str> = vec!["Maths", "Biology", "Chemistry", "Physics", "History", "Geography", "ICT", "German", "French", "DT", "PE", "English", "Personal Development", "RE"];
    let mut rng: ThreadRng = thread_rng();
    let index: usize = rng.gen_range(0..subjects.len());
    subjects[index].to_string()
}