<?php
$prof_id= isset($_POST['prof_id']) ? (int)$_POST['prof_id'] : 0;
$name= isset($_POST['name']) ? (string)$_POST['name'] :'';
$prof_surname= isset($_POST['prof_surname']) ? (string)$_POST['prof_surname']:''; 
$description= isset($_POST['description']) ? (string)$_POST['description'] :''; 
$jsonString = file_get_contents("dipl.json");
$data = json_decode($jsonString, true);
$subjects= $data["subjects"];
$new_id=uniqid();
$newSubject=[
    "id"=>$new_id,
    "name"=> $name,
    "description"=> $description,
    "professor_surname"=> $prof_surname,
    "professor_id"=> $prof_id,
    "student_number"=> 0,
    "status"=>"Διαθέσιμη",
    "assignment_date"=> null,
    "file"=>[],
    "committee"=>[],
    "pres_date"=>null
];

$data["subjects"][] = $newSubject;
file_put_contents('dipl.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo '<script>history.back();</script>';
?>