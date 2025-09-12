<?php 
session_start();

if (!isset($_SESSION['Stud_id'])) {
    header('Location: loginScr.php');
    exit;
}
$id = $_SESSION['Stud_id'];
?>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Σύστημα Υποστήριξης Διπλωματικών Εργασιών Πανεπιστημίου Πατρών</title>
  <img src="upatrasLogo.jpg" alt="Centered Image" style="display: block; margin: 40px auto; width: 20em; max-width: 80%;">
  <hr style="border: 1px solid black; width: 50%; max-width: 90%;">
<style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
  }

  .form .btn {
    display: flex;
    justify-content: center;
    flex-direction: row;
    margin-top: 1em;
  }

  .button1 {
    padding: 0.6em 1.2em;
    margin:auto;
    min-width: 120px;
    border-radius: 5px;
    border: none;
    outline: none;
    transition: .4s ease-in-out;
    background-color: #252525;
    color: white;
    font-size: 1em;
    cursor: pointer;
  }

  .button1:hover {
    background-color: black;
    color: white;
  }

  .form {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 1.5em;
    background-color: white;
    border-radius: 10px;
    max-width: 400px;
    margin: 20px auto;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }

  #heading, #heading1 {
    text-align: center;
    color: black;
    font-size: 1em;
  }

  #heading1 {
    font-size: 1.8em;
    color: red;
  }

  .container {
    margin-top: 2em;
    display: flex;
    justify-content: center;
    padding: 10px;
    box-sizing: border-box;
    min-height: 70vh;
  }

  .card {
    position: relative;
    width: 600px;
    max-width: 95%;
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid #ccc;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(36, 190, 49, 0.81);
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    word-wrap: break-word;
  }

  .button {
    bottom: 15px;
    right: 15px;
    padding: 10px 16px;
    background-color: rgba(36, 190, 49, 0.81);
    color: black;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    align-self: flex-end;
    margin-top: 20px;
  }

  .button:hover {
    background-color: rgba(22, 127, 31, 0.81);
  }

  /* Responsivenes*/
  @media (max-width: 768px) {
    .card {
      padding: 12px;
      font-size: 0.95em;
    }

    .button {
      width: 100%;
      text-align: center;
    }
  }

  @media (max-width: 480px) {
    img {
      width: 70%;
    }

    .card {
      padding: 10px;
      font-size: 0.9em;
    }

    .button {
      font-size: 0.95em;
      padding: 12px;
    }
  }
</style>
</head>
<body>
<?php
$stud_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$jsonString = file_get_contents("export.json");
$data = json_decode($jsonString, true);
$students = $data["students"];
$professors = $data["professors"];

foreach($students as $student) {
  if($student["id"] == $stud_id) {
    $studentFound = $student;
    $stud_num=$student["student_number"];
  }
}

$jsonString2 = file_get_contents("dipl.json");
$data2 = json_decode($jsonString2, true);
$subjects = $data2["subjects"];

foreach($subjects as $subject) {
  if($subject["student_number"] == $stud_num) {
    $subjectFound = $subject;
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
    echo '<strong>Αίθουσα Παρουσίασης:</strong>'.htmlspecialchars($subjectFound['pres_class']) . '<br>' ;
    echo '<strong>Τριμελής Επιτροπή:</strong><br>' ;
    foreach($subjectFound['committee'] as $prof_id){
      foreach($professors as $professor) {
        if($professor['id'] == $prof_id) {
          echo $professor['surname'].' '.$professor['name'].'<br>Τομέας: '. $professor['department'].'<br><hr style="margin-left:0;border: 1px solid black; width: 20%;">'; 
        }
      }
    }    
    echo '<strong>Ημερομηνία Ανάθεσης:</strong> ' . htmlspecialchars($subjectFound['assignment_date']) . '<br>';
    echo '<strong>Βαθμός:</strong> ' . htmlspecialchars($subjectFound['grade']) . '<br>';
     if ($subjectFound['status'] === 'Περατωμένη') {
        echo '<p><a href="https://nemertes.library.upatras.gr/home" target="_blank">
              Δείτε το τελικό κείμενο στο αποθετήριο της βιβλιοθήκης</a></p>';
    }
    $exDate=$subjectFound['pres_date'];
    if($exDate){
      $today = date("Y-m-d");
      $todayDate = new DateTime($today);
      $exDateObj = new DateTime($exDate);
      if ($exDateObj > $todayDate) {
          $interval = $todayDate->diff($exDateObj);
          echo '<strong>Ημέρες για εξέταση:</strong> ' . htmlspecialchars($interval->days) . ' ημέρες<br>';
      } elseif ($exDateObj == $todayDate) {
          echo '<strong>Ημέρες για εξέταση:</strong> Η εξέταση είναι σήμερα!<br>';
      } else {
          echo '<strong>Ημέρες για εξέταση:</strong> Περασμένη ημερομηνία<br>';
      }
    }
    echo '<button class="button" onclick="history.back()">Επιστροφή</button>';
    echo '</div>';
    echo '</div>';
} 
?>
</body>
</html>
