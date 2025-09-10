<?php
$prof_id = isset($_POST['prof_id']) ? (int)$_POST['prof_id'] : 0;
$name = isset($_POST['name']) ? (string)$_POST['name'] : '';
$prof_surname = isset($_POST['prof_surname']) ? (string)$_POST['prof_surname'] : ''; 
$description = isset($_POST['description']) ? (string)$_POST['description'] : ''; 
$jsonString = file_get_contents("dipl.json");
$data = json_decode($jsonString, true);
$new_id = uniqid();
$today = date("d-m-Y");

$newSubject = [
    "id" => $new_id,
    "name" => $name,
    "description" => $description,
    "professor_surname" => $prof_surname,
    "professor_id" => $prof_id,
    "student_number" => 0,
    "status" => "Διαθέσιμη",
    "assignment_date" => $today,
    "file" => [],
    "committee" => [],
    "pres_date" => null,
    "grade" => null
];

$data["subjects"][] = $newSubject;

file_put_contents('dipl.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo '<script>alert("Το θέμα καταχωρήθηκε με επιτυχία!"); history.back();</script>';
?>
