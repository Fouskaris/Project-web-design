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
    
    .title{
        margin: auto;
        text-align: center;
        margin-top: 5em;
    } 
     table {
    border-collapse: collapse;
    width: 80%;
    margin:auto;
    margin-top:2em;
    
  }

  th, td {
    border: 1px solid #000;
    padding: 10px;
    text-align: left;
  }
  td{
    white-space: normal;
  word-wrap: break-word;
  }
  th {
    background-color: #f2f2f2;
  }
  .listButton{
    background-color:white;
    color:rgba(36, 190, 49, 0.81);
    border:none;
  }
  .listButton:hover{
    color:rgba(22, 127, 31, 0.81);
    border: #000;
  }
  .tabletitle{
    margin:auto;
    margin-top: 5em;
    text-align: center;
  }
  .tabletitle2{
    margin:auto;
    margin-top: 5em;
    text-align: center;
  }
  .inp{
  border:none;
  font-size: 1em;  
  width: 300px;
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
  margin-top: 2em;
}

.card {
  margin-top:2em ;
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
.card2 {
  margin-top:2em ;
  margin: auto;
  position: relative;
  width: 600px;
  background: rgba(255, 255, 255, 0.9);
  border: 1px solid #ccc;
  padding: 15px;
  border-radius: 10px;
  box-shadow: 0 2px 6px rgba(36, 49, 190, 0.81);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.statTitle{

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
<h1 class="title">Κατάσταση Διπλωματικών</h1>
<h2 class="title">Ως Επιβλέπων</h2>
<?php
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$jsonString = file_get_contents("export.json");
$data = json_decode($jsonString, true);
$professors = $data['professors'];
foreach ($professors as $professor) {
  if ($professor['id'] == $id) {
    $last_name = $professor['surname'];
  }
}
$jsonString2 = file_get_contents("dipl.json");
$data2 = json_decode($jsonString2, true);
$subjects = $data2['subjects'];

foreach ($subjects as $subject) {
    if ($subject["professor_id"] == $id) {
        
    echo '<div class="container">';
    echo '<div class="card">';
    echo '<strong>Τίτλος:</strong> ' . htmlspecialchars($subject['name']) . '<br>';
    echo '<strong>Περιγραφή:</strong> ' . htmlspecialchars($subject['description']) . '<br>';
    echo '<strong>Επιβλέπων:</strong> ' . htmlspecialchars($subject['professor_surname']) . '<br>';
    echo '<strong>ΑΜ Φοιτητή:</strong> ' . htmlspecialchars($subject['student_number']) . '<br>';
    echo '<strong>Κατάσταση:</strong> ' . htmlspecialchars($subject['status']) . '<br>';
    echo '<strong>Τριμελής Επιτροπή:</strong>' ;
    if($subject['committee']!=null){
      foreach($subject['committee'] as $prof_id){
        foreach($professors as $professor) {
          if($professor['id'] == $prof_id) {
            echo $professor['surname'].' '.$professor['name'].'<br>Τομέας:'. $professor['department'],'<br><hr style=" margin-left:0;border: 1px solid black; width: 10%;">'; 
          }
      }
      }    
    }
    echo '<strong>Ημερομηνία Ανάθεσης:</strong> ' . htmlspecialchars($subject['assignment_date']) . '<br>';
    $exDate=$subject['pres_date'];
    if($exDate){
      $today = date("Y-m-d");
      $todayDate = new DateTime($today);
      $exDateObj = new DateTime($exDate);
      if ($exDateObj > $todayDate) {
          $interval = $todayDate->diff($exDateObj);
          echo '<strong>Ημέρες για εξέταση:</strong> ' . htmlspecialchars($interval->days) . ' ημέρες<br>';
      } elseif ($exDateObj < $todayDate) {
          echo '<strong>Ημέρες για εξέταση:</strong> Περασμένη ημερομηνία<br>';
          if ($subject['grade']!=null){
          echo '<strong>Βαθμός:</strong> ' . htmlspecialchars($subject['grade']) . '<br>';
          }
      } else {
          
          echo '<strong>Ημέρες για εξέταση:</strong> Η εξέταση είναι σήμερα!<br>';
      }
    }
    echo '</div></div>';
}}

?>

<h2 class="title">Ως Μέλος Τριμελούς Επιτροπής</h2>
<?php
if($subjects!=null){
foreach ($subjects as $subject) {
  if($subject['committee']!=null){
    foreach ($subject['committee'] as $member) { 
        if ($member == $id) {
        echo '<div class="container">';
        echo '<div class="card">';
        echo '<strong>Τίτλος:</strong> ' . htmlspecialchars($subject['name']) . '<br>';
        echo '<strong>Περιγραφή:</strong> ' . htmlspecialchars($subject['description']) . '<br>';
        echo '<strong>Επιβλέπων:</strong> ' . htmlspecialchars($subject['professor_surname']) . '<br>';
        echo '<strong>ΑΜ Φοιτητή:</strong> ' . htmlspecialchars($subject['student_number']) . '<br>';
        echo '<strong>Κατάσταση:</strong> ' . htmlspecialchars($subject['status']) . '<br>';
        echo '<strong>Τριμελής Επιτροπή:</strong>' ;
        foreach($subject['committee'] as $prof_id){
          foreach($professors as $professor) {
            if($professor['id'] == $prof_id) {
              echo $professor['surname'].' '.$professor['name'].'<br>Τομέας:'. $professor['department'],'<br><hr style=" margin-left:0;border: 1px solid black; width: 10%;">'; 
            }
        }
        }    
        echo '<strong>Ημερομηνία Ανάθεσης:</strong> ' . htmlspecialchars($subject['assignment_date']) . '<br>';
        $exDate=$subject['pres_date'];
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
              if ($subject['grade']!=null){
              echo '<strong>Βαθμός:</strong> ' . htmlspecialchars($subject['grade']) . '<br>';
              }
          }
        }
        echo '</div></div>';
}}
  }}}
?>
<h2 class="title">Στατιστικά Καθηγητή</h2>

<div class="card2">
<?php
  $prof_counter=0;
  $member_counter= 0;
  $grade_asProf_counter= 0;
  $grade_asMemb_counter= 0;
  $days_asProf_counter= 0;
  $days_asMemb_counter= 0;
  foreach($subjects as $subject) {
    if(($subject['professor_id'] == $id)&&($subject['status'] == 'Περατωμένη')) {
      $prof_counter++;
      $grade_asProf_counter=$subject['grade']+$grade_asProf_counter;
      $assignmentDate = new DateTime($subject['assignment_date']);
      $presentationDate = new DateTime($subject['pres_date']);
      $interval = $assignmentDate->diff($presentationDate);
      $var2= $interval->days;
      $days_asProf_counter = $days_asProf_counter+$var2;
    }elseif(($subject['status'] == 'Περατωμένη')&&($subject['status'] == 'Περατωμένη')) {
      $member_counter++;
      $grade_asMemb_counter=$subject['grade']+$grade_asMemb_counter;
      $assignmentDate = new DateTime($subject['assignment_date']);
      $presentationDate = new DateTime($subject['pres_date']);
      $interval = $assignmentDate->diff($presentationDate);
      $var = $interval->days;
      $days_asMemb_counter = $days_asMemb_counter+$var;
  }}
  echo "<h2 class='statTitle'>Ως επιβλέπων καθηγητής</h2>";
  if($days_asProf_counter> 0) {$avg_asProf_days=($days_asProf_counter/$prof_counter);echo '<strong>Μέσος χρόνος περάτωσης διπλωματικών:</strong>'.$avg_asProf_days.' μέρες<br><br>';}else{echo "";}
  if($grade_asProf_counter>0) {$avg_asProf_grade=($grade_asProf_counter/$prof_counter);echo '<strong>Μέσος βαθμός διπλωματικών:</strong>'.round($avg_asProf_grade, 2).'<br><br>';}else{echo "";}
  echo '<strong>Συνολικό πλήθος διπλωματικών:</strong>'.$prof_counter.' Διπλωματικές<br><br>';
  echo "<h2 class='statTitle'>Ως μέλος τριμελούς επιτροπής</h2>";
  if($days_asMemb_counter> 0) {$avg_asMemb_days=($days_asMemb_counter/$member_counter);echo '<strong>Μέσος χρόνος περάτωσης διπλωματικών:</strong>'.$avg_asMemb_days.' μέρες<br><br>';}else{echo "Δεν βρέθηκαν μαθήματα<br><br>";}
  if($grade_asMemb_counter>0) {$avg_asMemb_grade=($grade_asMemb_counter/$member_counter);echo '<strong>Μέσος βαθμός διπλωματικών:</strong>'.round($avg_asMemb_grade, 2).'<br><br>';}else{echo "Δεν βρέθηκαν μαθήματα<br><br>";}
  echo '<strong>Συνολικό πλήθος διπλωματικών:</strong>'.$member_counter.' Διπλωματικές';
?>
</div></div>

</body>
</html>



