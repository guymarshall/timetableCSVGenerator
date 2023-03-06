#![forbid(unsafe_code)]

use std::ops::{Range, RangeInclusive};
use rand::prelude::*;
use rand::distributions::uniform::Uniform;

pub fn random_subject_name() -> String {
    let subjects: Vec<&str> = vec!["Maths", "Biology", "Chemistry", "Physics", "History", "Geography", "ICT", "German", "French", "DT", "PE", "English", "Personal Development", "RE"];
    let mut rng: ThreadRng = thread_rng();
    let index: usize = rng.gen_range(0..subjects.len());
    subjects[index].to_string()
}