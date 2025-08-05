<!DOCTYPE html>
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
      z-index: 1;
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
    .container {
      margin-top: 1em;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      padding: 10px;
      background-color: white;
      box-sizing: border-box;
      min-height: 80vh;
      z-index: 0;
    }

    .card {
      position: relative;
      width: 600px;
      background: rgba(255, 255, 255, 0.9);
      border: 1px solid #ccc;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(36, 190, 49, 0.81);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      z-index: 0;
      margin:auto;
    }

    .button {
      position: absolute;
      bottom: 15px;
      right: 15px;
      padding: 8px 14px;
      background-color: rgba(36, 190, 49, 0.81);
      color: black;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
    }

    .button:hover {
      background-color: rgba(22, 127, 31, 0.81);
    }

    .Pageheader{
      margin-top:3em;
      font-size:2em;
      margin-left: 7em;
    }

    .inp{
      border:none;
      font-size: 1em;  
      width: 300px;
    }

    .delNotif{
      padding: 8px 14px;
      color: black;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      border:black;
      background-color: white;
      width: 5%;
      margin:auto;
      font-size: 1.5em;
      margin-left: auto;
      display: block;
    }

    .delNotif:hover{
      color:red;
    }

    .back-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 2;
    }
  </style>
</head>
<body>

<div class="top-menu">
  <img src="upatrasLogo.jpg" alt="Image" style="display: block; margin: 0px; width: 10em;">
  <div class="menu-title">Σύστημα Υποστήριξης Διπλωματικών Εργασιών</div>
    <button class="buttonNotif"onclick="document.getElementById('bottom').scrollIntoView({ behavior: 'smooth' });">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
      <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
    </svg>
  </button>
</div>

<h1 class="Pageheader">Προφίλ</h1>

<?php
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$studentData = json_decode(file_get_contents("export.json"), true);
$students = &$studentData['students'];
$stud_num = "";
foreach ($students as &$student) {
    if ($student['id'] == $id) {
      $studentFound=&$student;
      break;
    }
}
if ($studentFound) {
      echo '<div class="card">';
      echo '<form action="update_prof.php" method="post">';
      echo '<input type="hidden" name="student_number" value="' . htmlspecialchars($studentFound['student_number']) . '">';

      echo '<label><strong>Όνομα:</strong></label><br>';
      echo '<input class="inp" type="text" name="name" value="' . htmlspecialchars($studentFound['name']) . '"><br><br>';

      echo '<label><strong>Επίθετο:</strong></label><br>';
      echo '<input class="inp" type="text" name="surname" value="' . htmlspecialchars($studentFound['surname']) . '"><br><br>';

      echo '<label><strong>Αριθμός Μητρώου:</strong></label><br>';
      echo '<input class="inp" type="text" value="' . htmlspecialchars($studentFound['student_number']) . '" disabled><br><br>';

      echo '<label><strong>Email:</strong></label><br>';
      echo '<input class="inp" type="email" name="email" value="' . htmlspecialchars($studentFound['email']) . '"><br><br>';

      echo '<button type="submit" class="button">Αποθήκευση</button> ';

      echo '</form>';
      echo '</div>';
  } else {
    echo "<div class='container'><p>Δεν βρέθηκε θέμα με ID: <strong>$id</strong>.</p></div>";
  }
?> 

<h1 class="Pageheader" id="bottom">Ειδοποιήσεις</h1>

<?php
if (empty($student['notifications'])) {
    echo "Δεν υπάρχουν Ειδοποιήσεις";
} else {
  echo '<div class="card">';
  foreach ($studentFound["notifications"] as&$notif) {
    if ($notif["seen"] == "no") {$notif["seen"] = "yes";}
    $profData = json_decode(file_get_contents("export.json"), true);
    $professors = $profData['professors'];
  foreach ($professors as $professor) {
    if ($professor["id"] == $notif["by"]) {
      $sender = $professor["surname"]." ".$professor["name"];
    }
  }
  if ($notif["id"] == -1) {}else{ 
    echo "<form method='POST' action='delete_notification.php' style='display:inline;'>";  
    echo "<h1 style='margin-top:3px;font-size: 1em;' >" . htmlspecialchars($notif["date"]) ."<strong>"." ". htmlspecialchars($sender) .  "</strong>:</h1> ";
    echo htmlspecialchars($notif["message"]) . "<br>";
    echo "<input type='hidden' name='stud_id' value='" . htmlspecialchars($id) . "'>";
    echo "<input type='hidden' name='notif_id' value='" . htmlspecialchars($notif["id"]) . "'>";
    echo "<button  class='delNotif'><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
    <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z'/>
    <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z'/>
    </svg></button> ";
    echo "</form>";
    echo "<hr style='border: 1px solid black; width: 100%;'>";
  }
}
  echo '</div>';
}   
file_put_contents("export.json", json_encode($studentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
?>

<button type="button" class="button back-btn" onclick="history.back()">Επιστροφή</button>

</body>
</html>
