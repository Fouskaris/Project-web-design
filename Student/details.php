<!DOCTYPE html>  
<html lang="el">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Σύστημα Υποστήριξης Διπλωματικών Εργασιών Πανεπιστημίου Πατρών</title>
<style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f9f9f9;
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
    z-index: 1000;
    flex-wrap: wrap;
  }

  .top-menu img {
    max-width: 160px;
    height: auto;
    flex-shrink: 0;
  }

  .menu-title {
    font-size: clamp(16px, 2.5vw, 26px);
    font-weight: bold;
    margin-left: 15px;
    flex: 1;
    min-width: 200px;
    word-wrap: break-word;
  }

  .buttonNotif {
    margin-left: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 8px;
    border: 1px solid rgba(78, 79, 81, 0.81);
    height: 40px;
    width: 60px;
    background: white;
    border-radius: 20px;
    cursor: pointer;
  }

  .buttonNotif:hover {
    background: rgba(88, 89, 92, 0.29);
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
    max-width: 95%;
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid #ccc;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(36, 190, 49, 0.81);
    display: flex;
    flex-direction: column;
    gap: 12px;
    justify-content: space-between;
    line-height: 1.6;
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

  @media (max-width: 480px) {
    .top-menu {
      flex-direction: column;
      align-items: center;
      text-align: center;
    }
    .top-menu img {
      max-width: 100px;
      margin-bottom: 8px;
    }
    .menu-title {
      margin: 0;
      font-size: 16px;
    }
    .buttonNotif {
      position: absolute;
      top: 10px;
      right: 10px;
    }
  }
</style>
</head>

<body>

<div class="top-menu">
  <img src="upatrasLogo.jpg" alt="Λογότυπο Πανεπιστημίου Πατρών">
  <div class="menu-title">Σύστημα Υποστήριξης Διπλωματικών Εργασιών</div>
  <button class="buttonNotif">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
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

    $jsonProfessors = json_decode(file_get_contents("export.json"), true);
    $professorsList = $jsonProfessors["professors"];
    echo '<strong>Τριμελής Επιτροπή:</strong> ';
    if (!empty($subjectFound['committee'])) {
        $surnames = [];
        foreach ($subjectFound['committee'] as $memberId) {
            foreach ($professorsList as $prof) {
                if ((int)$prof['id'] === (int)$memberId) {
                    $surnames[] = $prof['surname'];
                    break;
                }
            }
        }
        echo htmlspecialchars(implode(", ", $surnames)) . '<br>';
    } else {
        echo 'Δεν έχουν οριστεί.<br>';
    }

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
