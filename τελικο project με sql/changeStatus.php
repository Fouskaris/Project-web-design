<?php
$id = isset($_POST['id']) ? $_POST['id'] : null;
$choice = isset($_POST['choice']) ? trim($_POST['choice']) : null;
$reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';

if ($id === null || $choice === null) {
    die("Λείπουν δεδομένα.");
}

$jsonString = file_get_contents("dipl.json");
$data = json_decode($jsonString, true);
$subjects = &$data['subjects'];

$status = null;
switch ($choice) {
    case 'Διαθέσιμη':
        $status = 'Διαθέσιμη';
        break;
    case 'Ενεργή':
        $status = 'Ενεργή';
        break;
    case 'Υπό Εξέταση':
        $status = 'Υπό Εξέταση';
        break;
    case 'Ακύρωση':
        $status = 'Ακυρωμένη από Καθηγητή';
        break;
    default:
        die("Μη έγκυρη επιλογή.");
}

$today = date("d-m-Y");

foreach ($subjects as &$subject) {
    if ($subject['id'] == $id) {
        $subject['status'] = $status;

        if ($status === 'Υπό Εξέταση') {
            $subject['exam_request_date'] = $today;
        }
        if ($status === 'Ακυρωμένη από Καθηγητή' && $reason !== '') {
            $subject['cancellation_reason'] = $reason;
            $subject['cancellation_date'] = $today;
        }
        break;
    }
}

file_put_contents("dipl.json", json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo '<script>alert("Η κατάσταση ενημερώθηκε με επιτυχία!"); history.back();</script>';
exit;
?>
