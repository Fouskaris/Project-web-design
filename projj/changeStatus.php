<?php
$id = isset($_POST['id']) ? $_POST['id'] : null;
$choice = isset($_POST['choice']) ? (int)$_POST['choice'] : null;

$jsonString = file_get_contents("dipl.json");
$data = json_decode($jsonString, true);
$subjects = &$data['subjects'];
        echo $choice;
        echo $id;
switch ($choice) {
    case 1:
        $status = 'Διαθέσιμη';
        break;
    case 2:
        $status = 'Ενεργή';
        break;
    case 3:
        $status = 'Υπό Εξέταση';
        break;
    case 4:
        $status = 'Ακυρωμένη Από καθηγητή';
        break;
        default:
    die("Μη έγκυρη επιλογή.");
    };
    foreach ($subjects as &$subject) {
    if ($subject['id'] == $id) {
        $subject['status'] = $status;
        echo $status;
        echo $subject['name'];
        break;
    }
}

file_put_contents("dipl.json", json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
?>
