<?php
session_start();
if (!isset($_SESSION['Prof_id'])) {
    header('Location: loginScr.php');
    exit;
}

$prof_id = $_SESSION['Prof_id'];
$subj_id = $_POST['subj_id'] ?? null;
if (!$subj_id) {
    header('Location: subjHandling.php');
    exit;
}

$diplPath = 'dipl.json';
$diplData = json_decode(file_get_contents($diplPath), true) ?: [];
$subjects = $diplData['subjects'] ?? [];

$target = null;
foreach ($subjects as $s) {
    if ($s['id'] == $subj_id) {
        $target = $s;
        break;
    }
}
if (!$target) {
    header('Location: subjHandling.php');
    exit;
}

if (empty($target['pres_date']) || empty($target['pres_class'])) {
    header('Location: subjHandling.php');
    exit;
}

$student_name = '';
$student_surname = '';

if (!empty($target['student_number'])) {
    $exportPath = 'export.json';
    $exportData = json_decode(file_get_contents($exportPath), true) ?: [];
    $students = $exportData['students'] ?? [];

    foreach ($students as $st) {
        if ($st['student_number'] == $target['student_number']) {
            $student_name = $st['name'];
            $student_surname = $st['surname'];
            break;
        }
    }
}

$announcement_text = "Η εξέταση της διπλωματικής εργασίας του φοιτητή "
    . ($student_name ? $student_name . " " . $student_surname : "ΑΓΝΩΣΤΟΣ ΦΟΙΤΗΤΗΣ")
    . " (AM " . ($target['student_number'] ?? '-') . ") "
    . "με τίτλο «" . ($target['name'] ?? '-') . "» "
    . "θα πραγματοποιηθεί την " . $target['pres_date']
    . " και ώρα " . ($target['pres_time'] ?? '-') 
    . " στην αίθουσα " . $target['pres_class'] . ".";

$annPath = 'announcements.json';
$annData = json_decode(@file_get_contents($annPath), true);

if (!$annData || !isset($annData['announcements'])) {
    $annData = [
        "code" => 1,
        "message" => "Retrieved successfully",
        "announcements" => []
    ];
}

$newId = 1;
if (!empty($annData['announcements'])) {
    $ids = array_column($annData['announcements'], 'id');
    $newId = max($ids) + 1;
}

$newAnnouncement = [
    "id" => $newId,
    "title" => "Εξέταση Διπλωματικής Εργασίας",
    "message" => $announcement_text,
    "date" => date("Y-m-d"),
    "type" => "info"
];

$annData['announcements'][] = $newAnnouncement;

file_put_contents($annPath, json_encode($annData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
?>
<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="utf-8">
  <title>Ανακοίνωση Παρουσίασης</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 2em; background:#f5f5f5; }
    .card { background:#fff; padding:20px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.2); max-width:700px; margin:auto; }
    h2 { text-align:center; color:#333; }
    pre { white-space:pre-wrap; font-size:1.1em; line-height:1.5; background:#fafafa; padding:15px; border-radius:8px; border:1px solid #ddd; }
    a.back { display:inline-block; margin-top:15px; padding:8px 16px; background:#24be31; color:white; text-decoration:none; border-radius:6px; }
    a.back:hover { background:#16801f; }
  </style>
</head>
<body>
  <div class="card">
    <h2>Ανακοίνωση Παρουσίασης</h2>
    <pre><?php echo htmlspecialchars($announcement_text, ENT_QUOTES, 'UTF-8'); ?></pre>
    <div style="text-align:center;">
      <a class="back" href="subjHandling.php">Επιστροφή</a>
    </div>
  </div>
</body>
</html>
