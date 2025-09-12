<?php
session_start();
if (!isset($_SESSION['Prof_id'])) {
    header('Location: loginScr.php'); exit;
}
$prof_id = $_POST['prof_id'] ?? $_SESSION['Prof_id'] ?? null;

$subj_id = $_POST['subj_id'] ?? $_POST['id'] ?? '';
if ($subj_id === '') {
    echo '<script>alert("Δεν προσδιορίστηκε το id του θέματος."); history.back();</script>';
    exit;
}

if (!isset($_POST['student_grade'])) {
    echo '<script>alert("Δεν στάλθηκε βαθμός."); history.back();</script>';
    exit;
}

$grade_raw = str_replace(',', '.', trim($_POST['student_grade']));
$grade = floatval($grade_raw);

if ($grade < 1 || $grade > 10) {
    echo '<script>alert("Μη έγκυρος βαθμός! Επιτρέπεται μόνο 1-10."); history.back();</script>';
    exit;
}

$path = "dipl.json";
$jsonString = @file_get_contents($path);
$data = json_decode($jsonString, true);
if (!is_array($data)) $data = [];
if (!isset($data['subjects']) || !is_array($data['subjects'])) $data['subjects'] = [];

$committee_size = 3;

$found = false;
foreach ($data['subjects'] as &$subject) {
    if ((string)($subject['id'] ?? '') === (string)$subj_id) {
        $found = true;
        if (!isset($subject['grades']) || !is_array($subject['grades'])) {
            $subject['grades'] = [];
        }

        $key = (string)($prof_id ?? 'unknown');
        $subject['grades'][$key] = $grade;

        $subject['grade'] = $grade;

        if (count($subject['grades']) >= $committee_size) {
            $avg = array_sum($subject['grades']) / count($subject['grades']);
            $subject['final_grade'] = round($avg, 2);
            $subject['grade'] = $subject['final_grade']; 
            $subject['status'] = "Περατωμένη";
        }

        break;
    }
}
unset($subject); 

if (!$found) {
    echo '<script>alert("Το θέμα δεν βρέθηκε στο dipl.json."); history.back();</script>';
    exit;
}

file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);

$stud_num = null;
foreach ($data['subjects'] as $s) {
    if ((string)($s['id'] ?? '') === (string)$subj_id) {
        $stud_num = $s['student_number'] ?? null;
        $subj_name = $s['name'] ?? '';
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

    $expPath = "export.json";
    $jsonString2 = @file_get_contents($expPath);
    $data2 = json_decode($jsonString2, true);
    if (!is_array($data2)) $data2 = [];
    if (!isset($data2['students']) || !is_array($data2['students'])) $data2['students'] = [];

    foreach ($data2['students'] as &$stud) {
        if ((string)($stud['student_number'] ?? '') === (string)$stud_num) {
            if (!isset($stud['notifications']) || !is_array($stud['notifications'])) $stud['notifications'] = [];
            $stud['notifications'][] = $newNotification;
            break;
        }
    }
    unset($stud);
    file_put_contents($expPath, json_encode($data2, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
}

echo '<script>alert("Ο βαθμός καταχωρήθηκε με επιτυχία!"); history.back();</script>';
exit;
?>
