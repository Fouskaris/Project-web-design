<?php
$subj_id = isset($_POST['id']) ? $_POST['id'] : '';
$grade = isset($_POST['student_grade']) ? (int)$_POST['student_grade'] : null;
$prof_id = isset($_POST['prof_id']) ? $_POST['prof_id'] : null; // ποιος καθηγητής βαθμολογεί

if ($grade === null || $grade < 1 || $grade > 10) {
    echo '<script>alert("Μη έγκυρος βαθμός! Επιτρέπεται μόνο 1-10."); history.back();</script>';
    exit;
}

$jsonString = file_get_contents("dipl.json");
$data = json_decode($jsonString, true);
$subjects = &$data['subjects'];

$stud_num = null;
$subj_name = '';
$committee_size = 3; 

foreach ($subjects as &$subject) {
    if ($subject['id'] == $subj_id) {
        if (!isset($subject['grades'])) {
            $subject['grades'] = [];
        }

        $subject['grades'][$prof_id] = $grade;

        $stud_num = $subject['student_number'];
        $subj_name = $subject['name'];

        if (count($subject['grades']) >= $committee_size) {
            $avg = array_sum($subject['grades']) / count($subject['grades']);
            $subject['final_grade'] = round($avg, 2);
            $subject['status'] = "Περατωμένη";
        }
        break;
    }
}

if ($stud_num !== null) {
    date_default_timezone_set('Europe/Athens');
    $today = date("d-m-Y H:i:s");
    $newNotification = [
        "id" => time() . rand(100, 999),
        "message" => "Καταχωρήθηκε νέος βαθμός για το θέμα '$subj_name' από μέλος της επιτροπής.",
        "date" => $today,
        "by" => $prof_id,
        "to" => $stud_num,
        "seen" => "no",
        "type" => "text"
    ];

    $jsonString2 = file_get_contents("export.json");
    $data2 = json_decode($jsonString2, true);
    $students = &$data2['students'];

    foreach ($students as &$stud) {
        if ($stud['student_number'] == $stud_num) {
            $stud['notifications'][] = $newNotification;
            break;
        }
    }
    file_put_contents("export.json", json_encode($data2, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

file_put_contents("dipl.json", json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo '<script>alert("Ο βαθμός καταχωρήθηκε με επιτυχία!"); history.back();</script>';
exit;
?>
