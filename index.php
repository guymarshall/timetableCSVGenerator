<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV Generator</title>
</head>
<body>
    <form action="index.php" method="get">
        <label for="curriculumCount">Curriculum Count:</label>
        <input type="number" name="curriculumCount" id="curriculumCount">
        <br>
        <label for="periodScheduleCount">PeriodSchedule Count:</label>
        <input type="number" name="periodScheduleCount" id="periodScheduleCount">
        <br>
        <label for="roomCount">Room Count:</label>
        <input type="number" name="roomCount" id="roomCount">
        <br>
        <label for="studentCount">Student Count:</label>
        <input type="number" name="studentCount" id="studentCount">
        <br>
        <label for="subjectCount">Subject Count:</label>
        <input type="number" name="subjectCount" id="subjectCount">
        <br>
        <label for="teacherCount">Teacher Count:</label>
        <input type="number" name="teacherCount" id="teacherCount">
        <br>
        <label for="teacherTypeCount">Teacher Type Count:</label>
        <input type="number" name="teacherTypeCount" id="teacherTypeCount">
        <br>
        <input type="submit" value="Generate">
    </form>
</body>
</html>

<?php

require_once "CSV.php";
require_once "File.php";
require_once "Functions.php";
require_once "Random.php";

$required_keys = ["curriculumCount", "periodScheduleCount", "roomCount", "studentCount", "subjectCount", "teacherCount", "teacherTypeCount"];
foreach ($required_keys as $key)
{
    if (!isset($_GET[$key]))
    {
        exit("All fields must be filled in.");
    }
    if ($_GET[$key] <= 0)
    {
        exit("All values must be more than 0.");
    }
    if (!ctype_digit($_GET[$key]))
    {
        exit("Invalid input. Only numbers are allowed.");
    }
}

$curriculum_count = $_GET['curriculumCount'];
$period_schedule_count = $_GET['periodScheduleCount'];
$room_count = $_GET['roomCount'];
$student_count = $_GET['studentCount'];
$subject_count = $_GET['subjectCount'];
$teacher_count = $_GET['teacherCount'];
$teacher_type_count = $_GET['teacherTypeCount'];

$first_names = File::get_names("first_names.txt");
$middle_names = File::get_names("middle_names.txt");
$last_names = File::get_names("last_names.txt");

$curriculum = new CSV();
for ($i = 0; $i < $curriculum_count; $i++)
{
    try {
        $curriculum->add_data([
            $i + 1,
            rand(1, $subject_count + 1),
            rand(1, 9)
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit(1);
    }
}
$curriculum->generate_csv("Curriculum.csv", ["ID", "StudentID", "SubjectID", "NumberOfLessonsPerWeek"]);

$period_schedule = new CSV();
for ($i = 0; $i < $period_schedule_count; $i++)
{
    $period_schedule->add_data([
        $i + 1,
        Random::day_from_int($i),
        rand(1, 6)
    ]);
}
$period_schedule->generate_csv("PeriodSchedule.csv", ["ID", "DayOfWeek", "NumberOfPeriods"]);

$room = new CSV();
for ($i = 0; $i < $room_count; $i++)
{
    try {
        $room->add_data([
            $i + 1,
            Random::random_room(),
            rand(15, 31)
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit(1);
    }
}
$room->generate_csv("Room.csv", ["ID", "Name", "MaximumClassSize"]);

$student = new CSV();
for ($i = 0; $i < $student_count; $i++)
{
    $first_name = $first_names[rand(0, count($first_names) - 1)];
    $middle_name = $middle_names[rand(0, count($middle_names) - 1)];
    $last_name = $last_names[rand(0, count($last_names) - 1)];

    $student->add_data([
        $i + 1,
        $first_name,
        $middle_name,
        $last_name,
        Functions::generate_initials($first_name, $middle_name, $last_name)
    ]);
}
$student->generate_csv("Student.csv", ["ID", "FirstName", "MiddleNames", "Surname", "Initials"]);

$subject = new CSV();
for ($i = 0; $i < $subject_count; $i++)
{
    try {
        $subject->add_data([
            $i + 1,
            Random::random_subject_name(),
            rand(7, 13),
            rand(1, 8),
            rand(15, 31),
            rand(1, 8)
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit(1);
    }
}
$subject->generate_csv("Subject.csv", ["ID", "SubjectName", "SubjectYear", "Set", "MaximumClassSize", "RoomsTaught"]);

$teacher = new CSV();
for ($i = 0; $i < $teacher_count; $i++)
{
    $first_name = $first_names[rand(0, count($first_names) - 1)];
    $middle_name = $middle_names[rand(0, count($middle_names) - 1)];
    $last_name = $last_names[rand(0, count($last_names) - 1)];

    $teacher->add_data([
        $i + 1,
        $first_name,
        $middle_name,
        $last_name,
        Functions::generate_initials($first_name, $middle_name, $last_name),
        rand(0, 100),
        Random::random_length_random_array(),
        Random::random_length_random_array()
    ]);
}
$teacher->generate_csv("Teacher.csv", ["ID", "FirstName", "MiddleName", "Surname", "Initials", "TeacherTypeID", "SubjectTaughtIDs", "RoomTaughtIDs"]);

$teacher_type = new CSV();
for ($i = 0; $i < $teacher_type_count; $i++)
{
    try {
        $teacher_type->add_data([
            $i + 1,
            Random::random_teacher_type("name"),
            Random::random_teacher_type("displayName")
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit(1);
    }
}
$teacher_type->generate_csv("TeacherType.csv", ["ID", "Name", "DisplayName"]);

/*
println!("CSV Generator - Enter counts for the following prompts to generate your .CSV file.");
let curriculum_count: i32 = user_input::input("Curriculum Count:");
let period_schedule_count: i32 = user_input::input("Period Schedule Count:");
let room_count: i32 = user_input::input("Room Count:");
let student_count: i32 = user_input::input("Student Count:");
let subject_count: i32 = user_input::input("Subject Count:");
let teacher_count: i32 = user_input::input("Teacher Count:");
let teacher_type_count: i32 = user_input::input("Teacher Type Count:");

let first_name_list: Vec<String> = get_names("first_names.txt");
let middle_name_list: Vec<String> = get_names("middle_names.txt");
let last_name_list: Vec<String> = get_names("last_names.txt");

let mut curriculum_data: Vec<Vec<i32>> = vec![];
for i in 0..curriculum_count {
    curriculum_data.push(vec![
        i + 1,
        random_number(1, student_count + 1),
        random_number(1, subject_count + 1),
        random_number(1, 9)
    ]);
}
generate_curriculum_csv(
    "Curriculum.csv",
    vec!["ID", "StudentID", "SubjectID", "NumberOfLessonsPerWeek"],
    curriculum_data
);

let mut period_schedule_data: Vec<Vec<(i32, String, i32)>> = vec![];
for i in 0..period_schedule_count {
    period_schedule_data.push(vec![(
        i + 1,
        day_from_i32(i),
        random_number(1, 6)
    )])
}
generate_period_schedule_csv(
    "PeriodSchedule.csv",
    vec!["ID", "DayOfWeek", "NumberOfPeriods"],
    period_schedule_data
);

let mut room_data: Vec<Vec<(i32, &str, i32, String, String)>> = vec![];
for i in 0..room_count {
    room_data.push(vec![(
        i + 1,
        random_room(),
        random_number(15, 31),
        vector_to_string_with_quotes(&random_length_random_vector()),
        vector_to_string_with_quotes(&random_length_random_vector())
    )]);
}
generate_room_csv(
    "Room.csv",
    vec!["ID", "Name", "MaximumClassSize", "SubjectsTaught", "Teachers"],
    room_data
);

let mut student_data: Vec<Vec<(String, String, String, String, String)>> = vec![];
for i in 0..student_count {
    let first_name: String = random_name(&first_name_list);
    let middle_name: String = random_name(&middle_name_list);
    let last_name: String = random_name(&last_name_list);

    let first_name_for_initials: String = first_name.clone();
    let middle_name_for_initials: String = middle_name.clone();
    let last_name_for_initials: String = last_name.clone();

    student_data.push(vec![(
        add_quotes(&(i + 1).to_string()),
        first_name,
        middle_name,
        last_name,
        generate_initials(first_name_for_initials, middle_name_for_initials, last_name_for_initials)
    )]);
}

generate_student_csv(
    "Student.csv",
    vec!["ID", "FirstName", "MiddleNames", "Surname", "Initials"],
    student_data
);

let mut subject_data: Vec<Vec<(i32, String, i32, String, i32, String, String)>> = vec![];
for i in 0..subject_count {
    subject_data.push(vec![(
        i + 1,
        random_subject_name(),
        random_number(7, 13),
        add_quotes(random_number(1, 8).to_string().as_str()),
        random_number(15, 31),
        vector_to_string_with_quotes(&random_length_random_vector()),
        vector_to_string_with_quotes(&random_length_random_vector())
    )]);
}
generate_subject_csv(
    "Subject.csv",
    vec!["ID", "SubjectName", "SubjectYear", "Set", "MaximumClassSize", "Teachers", "RoomsTaught"],
    subject_data
);

let mut teacher_data: Vec<Vec<(i32, String, String, String, String, i32, String, String)>> = vec![];
for i in 0..teacher_count {
    let first_name: String = random_name(&first_name_list);
    let middle_name: String = random_name(&middle_name_list);
    let last_name: String = random_name(&last_name_list);

    let first_name_for_initials: String = first_name.clone();
    let middle_name_for_initials: String = middle_name.clone();
    let last_name_for_initials: String = last_name.clone();

    teacher_data.push(vec![(
        i + 1,
        first_name,
        middle_name,
        last_name,
        generate_initials(first_name_for_initials, middle_name_for_initials, last_name_for_initials),
        random_number(1, teacher_type_count + 1),
        vector_to_string_with_quotes(&random_length_random_vector()),
        vector_to_string_with_quotes(&random_length_random_vector())
    )]);
}
generate_teacher_csv(
    "Teacher.csv",
    vec!["ID", "FirstName", "MiddleName", "Surname", "Initials", "TeacherTypeID", "SubjectTaughtIDs", "RoomTaughtIDs"],
    teacher_data
);

let mut teacher_type_data: Vec<Vec<(i32, String, String, String, String)>> = vec![];
for i in 0..teacher_type_count {
    teacher_type_data.push(vec![(
        i + 1,
        random_teacher_type("name"),
        random_teacher_type("displayName"),
        vector_to_string_with_quotes(&random_length_random_vector()),
        vector_to_string_with_quotes(&random_length_random_vector())
    )]);
}
generate_teacher_type_csv(
    "TeacherType.csv",
    vec!["ID", "Name", "DisplayName", "SubjectsTaught", "Teachers"],
    teacher_type_data
);
*/