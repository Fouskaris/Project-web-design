<?php
$stud_id = isset($_POST['stud_id']) ? (int)$_POST['stud_id'] : 0;
$notif_id = isset($_POST['notif_id']) ? $_POST['notif_id'] : '';
echo $stud_id;
echo $notif_id;
$studentData = json_decode(file_get_contents("export.json"), true);
$students = &$studentData['students']; 
echo $students[1]['name'];
$foundstudent = null;

foreach ($students as &$student) {
    echo $student['id'];
    if ($student['id'] == $stud_id) {
        $foundstudent = &$student; 
        break;
    }
}

if ($foundstudent !== null) {
    foreach ($foundstudent['notifications'] as &$notification) {
        if ($notification['id'] == $notif_id) {
            $notification['id'] = -1; 
            break;
        }
    }
    file_put_contents("export.json", json_encode($studentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));


}
header('Location: profileScr.php');
exit; 
?>

