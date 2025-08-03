<?php
$prof_id= isset($_POST['prof_id']) ? (int)$_POST['prof_id'] : 0;
$stud_num= isset($_POST['stud_num']) ? (int)$_POST['stud_num'] : 0;
$decision = isset($_POST['decision']) ? $_POST['decision'] : '';
$jsonString = file_get_contents("export.json");
$data = json_decode($jsonString, true);
$students = $data["students"];
echo $stud_num;
$professors = &$data["professors"];
$jsonString2 = file_get_contents("dipl.json");
$data2 = json_decode($jsonString2, true);
$subjects = &$data2["subjects"];
foreach ($professors as $professor) {
    if ($professor["id"] == $prof_id) {
        $surname = $professor["surname"];
    }
}
foreach ($subjects as $subject) {
    if ($subject["student_number"] == $stud_num) {
        $subj_name = $subject["name"];
    }
    
}


date_default_timezone_set('Europe/Athens');
$today = date("d-m-Y H:i:s");
if ($decision == 'reject'){
    $newNotification = [
        "id"=> 0,
        "message" => "O κύριος $surname δεν αποδέχτηκε το αίτημα συμμετοχής στην τριμελή επιτροπή για την εξέταση του θέματος $subj_name. ",
        "date" => $today,
        "by" => $prof_id,             
        "to" => $stud_num,
        "seen" => "no",
        "type"=>"text" 
    ];
}else if ($decision == 'accept'){
    $newNotification = [
        "id"=> 0,
        "message" => "O κύριος $surname αποδέχτηκε το αίτημα συμμετοχής στην τριμελή επιτροπή για την εξέταση του θέματος $subj_name. ",
        "date" => $today,
        "by" => $prof_id,             
        "to" => $stud_num,
        "seen" => "no",
        "type"=>"text" 
    ];
    foreach ($subjects as &$subject) {
    if ($subject["student_number"] == $stud_num) {
        $subject["requests"][] = $prof_id;
        break;
    }
}
}
$students=&$data['students'];
foreach ($students as &$stud) {
    if ($stud['student_number']==$stud_num) {
        $newNotification['id'] = uniqid();
        $stud['notifications'][] = $newNotification;
        break;
    }
}
file_put_contents('export.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
file_put_contents('dipl.json', json_encode($data2, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
$notif_id = isset($_POST['notif_id']) ? $_POST['notif_id'] : '';
$foundprof = null;
foreach ($professors as &$professor) {
    if ($professor['id'] == $prof_id) {
        $foundprof = &$professor;
    }
}
if ($foundprof != null) {
    foreach ($foundprof['notifications'] as &$notiff){
        if ($notiff['id'] == $notif_id) {
            $notiff['id'] = -1;
            break;
        }
    }
    file_put_contents("export.json", json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
echo '<script>history.back();</script>';
?>
