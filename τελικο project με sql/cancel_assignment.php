<?php
session_start();
if (!isset($_SESSION['Prof_id'])) { header('Location: loginScr.php'); exit; }
$prof_id = $_SESSION['Prof_id'];

$subj_id = $_POST['subj_id'] ?? null;
$gs_num = trim($_POST['gs_num'] ?? '');
$gs_year = trim($_POST['gs_year'] ?? '');
$reason = $_POST['reason'] ?? 'από Διδάσκοντα';

if (!$subj_id || !$gs_num || !$gs_year) {
    header('Location: subjHandling.php'); exit;
}

$path = 'dipl.json';
$d = json_decode(file_get_contents($path), true) ?: [];

$d['subjects'] = $d['subjects'] ?? [];
$d['invites'] = $d['invites'] ?? [];
$d['cancellations'] = $d['cancellations'] ?? [];

foreach ($d['subjects'] as &$s) {
    if ($s['id'] == $subj_id) {
        $s['student_number'] = 0;
        $s['status'] = 'Διαθέσιμη';
        unset($s['assignment_date']);
        unset($s['assignment_record']);
        break;
    }
}
unset($s);

$newInv = [];
foreach ($d['invites'] as $inv) {
    if ($inv['subj_id'] != $subj_id) $newInv[] = $inv;
}
$d['invites'] = $newInv;

$d['cancellations'][] = [
    'subj_id' => $subj_id,
    'by_prof_id' => $prof_id,
    'reason' => $reason,
    'gs_num' => $gs_num,
    'gs_year' => $gs_year,
    'date' => date('Y-m-d H:i:s')
];

file_put_contents($path, json_encode($d, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
header('Location: subjHandling.php');
exit;
