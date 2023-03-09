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
            rand(1, $student_count),
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
    try {
        $period_schedule->add_data([
            $i + 1,
            Random::day_from_int($i),
            6
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit(1);
    }
}
$period_schedule->generate_csv("PeriodSchedule.csv", ["ID", "DayOfWeek", "NumberOfPeriods"]);

$room = new CSV();
for ($i = 0; $i < $room_count; $i++)
{
    try {
        $room->add_data([
            $i + 1,
            Functions::add_quotes(Random::random_room()),
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
    $first_name = Random::random_name($first_names);
    $middle_name = Random::random_name($middle_names);
    $last_name = Random::random_name($last_names);

    try {
        $student->add_data([
            Functions::add_quotes($i + 1),
            Functions::add_quotes($first_name),
            Functions::add_quotes($middle_name),
            Functions::add_quotes($last_name),
            Functions::add_quotes(Functions::generate_initials($first_name, $middle_name, $last_name))
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit(1);
    }
}
$student->generate_csv("Student.csv", ["ID", "FirstName", "MiddleNames", "Surname", "Initials"]);

$subject = new CSV();
for ($i = 0; $i < $subject_count; $i++)
{
    try {
        $subject->add_data([
            $i + 1,
            Functions::add_quotes(Random::random_subject_name()),
            rand(7, 13),
            Functions::add_quotes(rand(1, 8)),
            rand(15, 31),
            Functions::array_to_quoted_string(Random::random_length_random_array())
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
    $first_name = Random::random_name($first_names);
    $middle_name = Random::random_name($middle_names);
    $last_name = Random::random_name($last_names);

    try {
        $teacher->add_data([
            $i + 1,
            Functions::add_quotes($first_name),
            Functions::add_quotes($middle_name),
            Functions::add_quotes($last_name),
            Functions::add_quotes(Functions::generate_initials($first_name, $middle_name, $last_name)),
            rand(1, $teacher_type_count),
            Functions::array_to_quoted_string(Random::random_length_random_array()),
            Functions::array_to_quoted_string(Random::random_length_random_array())
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit(1);
    }
}
$teacher->generate_csv("Teacher.csv", ["ID", "FirstName", "MiddleName", "Surname", "Initials", "TeacherTypeID", "SubjectTaughtIDs", "RoomTaughtIDs"]);

$teacher_type = new CSV();
for ($i = 0; $i < $teacher_type_count; $i++)
{
    try {
        $teacher_type->add_data([
            $i + 1,
            Functions::add_quotes(Random::random_teacher_type("name")),
            Functions::add_quotes(Random::random_teacher_type("displayName"))
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit(1);
    }
}
$teacher_type->generate_csv("TeacherType.csv", ["ID", "Name", "DisplayName"]);