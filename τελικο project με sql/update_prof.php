<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: profileScr.php");
    exit;
}

if (!isset($_POST['student_number'], $_POST['name'], $_POST['surname'], $_POST['email'])) {
    echo "<script>alert('Σφάλμα: Ελλιπή δεδομένα.'); history.back();</script>";
    exit;
}

$student_number = trim($_POST['student_number']);
$new_name = trim($_POST['name']);
$new_surname = trim($_POST['surname']);
$new_email = trim($_POST['email']);

if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Σφάλμα: Μη έγκυρο email.'); history.back();</script>";
    exit;
}

$json_file = 'export.json';
if (!file_exists($json_file)) {
    echo "<script>alert('Σφάλμα: Δεν βρέθηκε το αρχείο δεδομένων.'); history.back();</script>";
    exit;
}

$data = json_decode(file_get_contents($json_file), true);
if ($data === null) {
    echo "<script>alert('Σφάλμα: Αδύνατη ανάγνωση JSON.'); history.back();</script>";
    exit;
}

$students = &$data['students'];
$updated = false;

foreach ($students as &$student) {
    if ($student['student_number'] == $student_number) {
        $student['name'] = $new_name;
        $student['surname'] = $new_surname;
        $student['email'] = $new_email;
        $updated = true;
        break;
    }
}

if ($updated) {
    file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "<script>alert('Το προφίλ ενημερώθηκε με επιτυχία.'); window.location.href='profileScr.php';</script>";
} else {
    echo "<script>alert('Σφάλμα: Ο φοιτητής δεν βρέθηκε.'); history.back();</script>";
}

