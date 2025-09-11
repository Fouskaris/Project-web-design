<?php
session_start();
if (!isset($_SESSION['Prof_id'])) { header('Location: loginScr.php'); exit; }
$prof_id = $_SESSION['Prof_id'];
$subj_id = $_POST['subj_id'] ?? null;
if (!$subj_id) { header('Location: subjHandling.php'); exit; }

$path = 'dipl.json';
$d = json_decode(file_get_contents($path), true) ?: [];

$subjects = $d['subjects'] ?? [];
$target = null;
foreach ($subjects as $s) { if ($s['id'] == $subj_id) { $target = $s; break; } }
if (!$target) { header('Location: subjHandling.php'); exit; }

if (empty($target['presentation_date']) || empty($target['presentation_time']) || empty($target['presentation_room'])) {
    header('Location: subjHandling.php'); exit;
}

$announcement_text = "Ανακοίνωση παρουσίασης διπλωματικής εργασίας\n\n";
$announcement_text .= "Τίτλος: " . ($target['name'] ?? '-') . "\n";
$announcement_text .= "Φοιτητής (AM): " . ($target['student_number'] ?? '-') . "\n";
$announcement_text .= "Ημερομηνία: " . $target['presentation_date'] . " " . $target['presentation_time'] . "\n";
$announcement_text .= "Χώρος: " . $target['presentation_room'] . "\n";
$announcement_text .= "Επιβλέπων: " . ($target['professor_surname'] ?? $prof_id) . "\n";

if (!isset($d['announcements'])) $d['announcements'] = [];
$d['announcements'][] = [
    'subj_id' => $subj_id,
    'text' => $announcement_text,
    'generated_by' => $prof_id,
    'date' => date('Y-m-d H:i:s')
];

file_put_contents($path, json_encode($d, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);

?>
<!DOCTYPE html>
<html lang="el">
<head><meta charset="utf-8"><title>Ανακοίνωση Παρουσίασης</title></head>
<body>
  <h2>Ανακοίνωση Παρουσίασης</h2>
  <pre><?php echo htmlspecialchars($announcement_text); ?></pre>
  <p><a href="subjHandling.php">Επιστροφή</a></p>
</body>
</html>
