//den trexei swsta
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_number = $_POST['student_number'];
    $new_name = $_POST['name'];
    $new_surname = $_POST['surname'];
    $new_email = $_POST['email'];

    $json_file = 'export.json';
    $data = json_decode(file_get_contents($json_file), true);

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
} else {
    echo "<script>alert('Μη έγκυρο αίτημα.'); history.back();</script>";
}
?>
