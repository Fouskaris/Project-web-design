<?php
session_start();
if (!isset($_SESSION['Prof_id'])) { header('Location: loginScr.php'); exit; }
$prof_id = $_SESSION['Prof_id'];
$subj_id = $_POST['subj_id'] ?? null;
$note = trim($_POST['note'] ?? '');

if (!$subj_id || $note === '') {
    header('Location: subjHandling.php'); exit;
}
if (mb_strlen($note) > 300) $note = mb_substr($note,0,300);

$path = 'dipl.json';
$s = file_get_contents($path);
$d = json_decode($s, true) ?: [];
if (!isset($d['notes'])) $d['notes'] = [];

$d['notes'][] = [
    'subj_id' => $subj_id,
    'prof_id' => $prof_id,
    'text' => $note,
    'date' => date('Y-m-d H:i:s')
];

file_put_contents($path, json_encode($d, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
header('Location: subjHandling.php');
exit;
