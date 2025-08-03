<?php
$id = isset($_POST['id']) ? (int)$_POST['id'] : '';
$choice = isset($_POST['choise']) ? (int)$_POST['choise'] : null;

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
