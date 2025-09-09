<?php
$subj_id = isset($_POST['id']) ? $_POST['id'] : '';
$grade = isset($_POST['grade']) ? (int)$_POST['grade'] : null;

$jsonString = file_get_contents("dipl.json");
$data = json_decode($jsonString, true);
$subjects = &$data['subjects'];
foreach ($subjects as &$subject) {
    if ($subject['id'] == $subj_id) {
        $subject['grade'] = $grade;
        $prof_id=$subject['professor_id'] ;
        $stud_num=$subject['student_number'];
        date_default_timezone_set('Europe/Athens');
        $today = date("d-m-Y H:i:s");
        $subj_name = $subject['name'];
        $newNotification = [
        "id"=> 0,
        "message" => "O τελικός βαθμός για την εξέταση του θέματος $subj_name είναι $grade",
        "date" => $today,
        "by" => $prof_id,             
        "to" => $stud_num,
        "seen" => "no",
        "type"=>"text" 
    ];
        break;
    }
}
$jsonString2 = file_get_contents("export.json");
$data2 = json_decode($jsonString2, true);
$students = &$data2['students'];
foreach ($students as &$stud) {
    if ($stud['student_number']==$stud_num) {
        $newNotification['id'] = time() . rand(100, 999);
        $stud['notifications'][] = $newNotification;
        break;
    }
}
file_put_contents("dipl.json", json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
file_put_contents("export.json", json_encode($data2, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

?>