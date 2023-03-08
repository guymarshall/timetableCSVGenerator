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
    if (!ctype_digit($_GET[$key])) {
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

// fix below
$curriculum_data = [];
for ($i = 0; $i < $_GET["curriculumCount"]; $i++)
{
    $curriculum_data[] = [
        (string) $i,
        random_number(1, $_GET["subjectCount"] + 1),
        random_number(1, 9)
    ];
}
generate_csv("Curriculum.csv", ["studentID", "subjectID", "numberOfLessonsPerWeek"], $curriculum_data);

$period_schedule_data = [];
for ($i = 0; $i < $_GET["periodScheduleCount"]; $i++)
{
    $period_schedule_data[] = [
        random_day(),
        random_number(1, 6)
    ];
}
generate_csv("PeriodSchedule.csv", ["dayOfWeek", "numberOfPeriods"], $period_schedule_data);

$room_data = [];
for ($i = 0; $i < $_GET["roomCount"]; $i++)
{
    $room_data[] = [
        random_room(),
        random_number(15, 31)
    ];
}
generate_csv("Room.csv", ["name", "maximumClassSize"], $room_data);

$student_data = [];
for ($i = 0; $i < $_GET["studentCount"]; $i++)
{
    $first_name = get_random_name("first-names.txt");
    $middle_name = get_random_name("middle-names.txt");
    $last_name = get_random_name("middle-names.txt");

    $student_data[] = [
        $first_name,
        $middle_name,
        $last_name,
        generate_initials($first_name, $middle_name, $last_name)
    ];
}
generate_csv("Student.csv", ["firstName", "middleNames", "surname", "initials"], $student_data);

$subject_data = [];
for ($i = 0; $i < $_GET["subjectCount"]; $i++)
{
    $subject_data[] = [
        get_random_name("middle-names.txt"),
        random_number(7, 13),
        random_number(1, 8),
        random_number(15, 31),
        random_number(1, 8)
    ];
}
generate_csv("Subject.csv", ["subjectName", "subjectYear", "set", "maximumClassSize", "roomsTaught"], $subject_data);

$teacher_data = [];
for ($i = 0; $i < $_GET["teacherCount"]; $i++)
{
    $first_name = get_random_name("first-names.txt");
    $middle_name = get_random_name("middle-names.txt");
    $last_name = get_random_name("middle-names.txt");

    $teacher_data[] = [
        $first_name,
        $middle_name,
        $last_name,
        generate_initials($first_name, $middle_name, $last_name),
        random_number(0, 100),
        generate_random_length_random_array(),
        generate_random_length_random_array()
    ];
}
generate_csv("Teacher.csv", ["firstName", "middleName", "surname", "initials", "teacherTypeID", "subjectTaughtIDs", "roomTaughtIDs"], $teacher_data);

$teacher_type_data = [];
for ($i = 0; $i < $_GET["teacherTypeCount"]; $i++)
{
    $teacher_type_data[] = [
        random_teacher_type("name"),
        random_teacher_type("displayName")
    ];
}
generate_csv("TeacherType.csv", ["name", "displayName"], $teacher_type_data);

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