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
  }

  .menu-title {
    font-size: 30px;
  }
 
  .button1 {
  margin-left: auto;
  font-size: 30px;
  margin-top:15px;
}

  .button1 svg{
    width: 100px; 
    height: 100px;
  }

.button {
  margin-left: auto;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 8px 12px 8px 16px;
  gap: 8px;
  height: 40px;
  width: 250px;
  border: none;
  background:white;
  border-radius: 20px;
  cursor: pointer;
}

.buttonNotif{
  position:absolute;
  right: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 8px 12px 8px 12px;
  gap: 8px;
  border: 1px solid rgba(78, 79, 81, 0.81);
  height: 40px;
  width: 60px;

  background:white;
  border-radius: 20px;
  cursor: pointer;
}

.buttonNotif:hover {
  background:rgba(88, 89, 92, 0.29);
}

.lable {
  font-size: 20px;
  color:black;
}

.button:hover {
  background:rgba(88, 89, 92, 0.29);
}

.container {
  margin-top: 100px;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  padding: 10px;
  background-color: white;
  box-sizing: border-box;
  min-height: 80vh;
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
$id = isset($_POST['ia']) ? (int)$_POST['ia'] : null;
$jsonString = file_get_contents("dipl.json");
$data = json_decode($jsonString, true);

if ($id !== null && isset($data['subjects']) && is_array($data['subjects'])) {
  $subjectFound = null;

  foreach ($data['subjects'] as $subject) {
    if ($subject['id'] == $id) {
      $subjectFound = $subject;
      break;
    }
  }

  if ($subjectFound) {
    echo '<div class="container">';
    echo '<div class="card">';
    echo '<strong>Τίτλος:</strong> ' . htmlspecialchars($subjectFound['name']) . '<br>';
    echo '<strong>Περιγραφή:</strong> ' . htmlspecialchars($subjectFound['description']) . '<br>';
    echo '<strong>Επιβλέπων:</strong> ' . htmlspecialchars($subjectFound['professor_surname']) . '<br>';
    echo '<strong>ΑΜ Φοιτητή:</strong> ' . htmlspecialchars($subjectFound['student_number']) . '<br>';
    echo '<strong>Κατάσταση:</strong> ' . htmlspecialchars($subjectFound['status']) . '<br>';
    echo '<button class="button" onclick="history.back()">Επιστροφή</button>';
    echo '</div>';
    echo '</div>';
  } else {
    echo "<div class='container'><p>Δεν βρέθηκε θέμα με ID: <strong>$id</strong>.</p></div>";
  }
} else {
  echo '<div class="container"><p>Δεν δόθηκε έγκυρο ID ή δεν υπάρχουν δεδομένα.</p></div>';
}
?>

</body>
</html>
