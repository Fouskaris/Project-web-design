<!DOCTYPE html>
<?php

session_start();

if (!isset($_SESSION['Prof_id'])) {
    header('Location: loginScr.php');
    exit;
}
$id = $_SESSION['Prof_id'];

?>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Σύστημα Υποστήριξης Διπλωματικών Εργασιών Πανεπιστημίου Πατρών</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .top-menu {
      background-color: whitesmoke;
      color: black;
      display: flex;
      align-items: center;
      padding: 10px 20px;
      position: fixed;
      top: 0;
      width: 100%;
      box-sizing: border-box;
    }

    .menu-title {
      font-size: 30px;
    }

    .button {
      margin-left: auto;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 8px 16px;
      gap: 8px;
      height: 40px;
      width: 250px;
      border: none;
      background: white;
      border-radius: 20px;
      cursor: pointer;
    }

    .buttonNotif {
      position: absolute;
      right: 1px;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 8px 12px;
      gap: 8px;
      border: 1px solid rgba(78, 79, 81, 0.81);
      height: 40px;
      width: 60px;
      background: white;
      border-radius: 20px;
      cursor: pointer;
    }

    .buttonNotif:hover,
    .button:hover,
    .submBu:hover {
      background: rgba(88, 89, 92, 0.29);
    }

    .lable {
      font-size: 20px;
      color: black;
    }
    .retbut{
      position: absolute;
      margin-top: 2em;
      margin-left: 2em;
      font-size: 1.5em;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 8px 12px;
      gap: 8px;
      border: 1px solid rgba(78, 79, 81, 0.81);
      background: white;
      border-radius: 20px;
      cursor: pointer;
    }
</style>
    </head>
<body>

<div class="top-menu">
  <img src="upatrasLogo.jpg" alt="Image" style="display: block; margin: 0px; width: 10em;">
  <div class="menu-title">Σύστημα Υποστήριξης Διπλωματικών Εργασιών</div>
    <button class="buttonNotif">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
      <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
    </svg>
    
  </button>
</div>
<?php
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$studentData = json_decode(file_get_contents("export.json"), true);
$students = $studentData['students'];
$stud_num = "";
foreach ($students as $student) {
    if ($student['id'] == $id) {
        $stud_num = $student['student_number'];
        break;
    }
}

$targetDir = ""; 


$uploadedFiles = [];

if (isset($_FILES['myfile'])) {
    foreach ($_FILES['myfile']['tmp_name'] as $index => $tmpName) {
        if ($tmpName == "") continue;

        $fname = basename($_FILES['myfile']['name'][$index]);
        $targetFile = $targetDir . $fname;

        if (move_uploaded_file($tmpName, $targetFile)) {
            $uploadedFiles[] = $fname;
        }
    }
}

if (!empty($uploadedFiles)) {
    $jsonfile = "dipl.json";
    $data = json_decode(file_get_contents($jsonfile), true);

    foreach ($data['subjects'] as &$entry) {
        if ($entry["student_number"] == $stud_num) {
            if (!isset($entry['file']) || !is_array($entry['file'])) {
                $entry['file'] = [];
            }

            foreach ($uploadedFiles as $file) {
                if (!in_array($file, $entry['file'])) {
                    $entry['file'][] = $file;
                }
            }

            break;
        }
    }

    file_put_contents($jsonfile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}


?>
<h1 style="margin-left:auto;margin-top:5em;">Επιτυχής Ανέβασμα Αρχείων</h1>  
<button class="retbut" onclick="history.back()">Επιστροφή</button>
</body>
</html>


