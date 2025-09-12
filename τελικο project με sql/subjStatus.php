<?php
session_start();

if (!isset($_SESSION['Prof_id'])) {
    header('Location: loginScr.php');
    exit;
}
$id = $_SESSION['Prof_id'];

$jsonString2 = file_get_contents("dipl.json");
$data2 = json_decode($jsonString2, true);
$subjects = $data2['subjects'];

$jsonString = file_get_contents("export.json");
$data = json_decode($jsonString, true);
$professors = $data['professors'];

$filter_status = isset($_GET['status']) ? $_GET['status'] : '';
$filter_role = isset($_GET['role']) ? $_GET['role'] : '';

if (isset($_GET['export']) && ($_GET['export'] === 'csv' || $_GET['export'] === 'json')) {
    $exportData = [];

    foreach ($subjects as $subject) {
        // ρόλος
        $isSupervisor = ($subject['professor_id'] == $id);
        $isCommittee = (is_array($subject['committee']) && in_array($id, $subject['committee']));

        if ($filter_role === 'supervisor' && !$isSupervisor) continue;
        if ($filter_role === 'committee' && !$isCommittee) continue;

        if ($filter_status && $subject['status'] !== $filter_status) continue;

        $exportData[] = $subject;
    }

    if ($_GET['export'] === 'json') {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($exportData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    } elseif ($_GET['export'] === 'csv') {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="diplomatikes.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID','Τίτλος','Κατάσταση','Φοιτητής','Επιβλέπων','Ημερομηνία Ανάθεσης','Ημερομηνία Εξέτασης','Βαθμός']);
        foreach ($exportData as $row) {
            fputcsv($output, [
                $row['id'],
                $row['name'],
                $row['status'],
                $row['student_number'],
                $row['professor_surname'],
                $row['assignment_date'],
                $row['pres_date'],
                $row['grade']
            ]);
        }
        fclose($output);
        exit;
    }
}
?>

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
  gap:20px;
  padding: 10px;
  background-color: white;
  box-sizing: border-box;
  min-height: 80vh;
  margin-top: 2em;
}

.card {
  margin-top:2em ;
  position: relative;
  width: 500px;
  background: rgba(255, 255, 255, 0.9);
  border: 1px solid #ccc;
  padding: 10px;
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
.button2 {
  margin-top: 1%;
  bottom: 15px;
  right: 15px;
  padding: 8px 14px;
  background-color: rgba(36, 49, 190, 0.81);
  color: black;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
}

.button2:hover {
  background-color: rgba(27, 22, 127, 0.81);
}

</style>
    </head>
<body>
  <div class="top-menu">
  <img src="upatrasLogo.jpg" alt="Image" style="display: block; margin: 0px; width: 10em;">
  <div class="menu-title">Σύστημα Υποστήριξης Διπλωματικών Εργασιών</div>
</div>

<h1 class="title">Κατάσταση Διπλωματικών</h1>

<form method="get" style="text-align:center; margin-top:2em;">
    <label>Κατάσταση:
        <select name="status">
            <option value="">Όλες</option>
            <option value="Υπό Ανάθεση" <?= $filter_status==="Υπό Ανάθεση"?"selected":"" ?>>Υπό Ανάθεση</option>
            <option value="Ενεργή" <?= $filter_status==="Ενεργή"?"selected":"" ?>>Ενεργή</option>
            <option value="Περατωμένη" <?= $filter_status==="Περατωμένη"?"selected":"" ?>>Περατωμένη</option>
            <option value="Ακυρωμένη" <?= $filter_status==="Ακυρωμένη"?"selected":"" ?>>Ακυρωμένη</option>
            <option value="Υπό Εξέταση" <?= $filter_status==="Υπό Εξέταση"?"selected":"" ?>>Υπό Εξέταση</option>
        </select>
    </label>

    <label>Ρόλος:
        <select name="role">
            <option value="">Όλοι</option>
            <option value="supervisor" <?= $filter_role==="supervisor"?"selected":"" ?>>Επιβλέπων</option>
            <option value="committee" <?= $filter_role==="committee"?"selected":"" ?>>Μέλος Τριμελούς</option>
        </select>
    </label>

    <button type="submit">Φιλτράρισμα</button>
    <button type="submit" name="export" value="csv">Εξαγωγή CSV</button>
    <button type="submit" name="export" value="json">Εξαγωγή JSON</button>
</form>

<div class="container">

<?php
foreach ($subjects as $subject) {
    $isSupervisor = ($subject['professor_id'] == $id);
    $isCommittee = (is_array($subject['committee']) && in_array($id, $subject['committee']));

    if ($filter_role === 'supervisor' && !$isSupervisor) continue;
    if ($filter_role === 'committee' && !$isCommittee) continue;
    if ($filter_status && $subject['status'] !== $filter_status) continue;

    echo '<div class="card">';
    echo '<h3>'.$subject['name'].'</h3>';
    echo '<p><strong>Περιγραφή:</strong> '.$subject['description'].'</p>';
    echo '<p><strong>Επιβλέπων:</strong> '.$subject['professor_surname'].'</p>';
    echo '<p><strong>Κατάσταση:</strong> '.$subject['status'].'</p>';
    if ($subject['student_number']) {
        echo '<p><strong>ΑΜ Φοιτητή:</strong> '.$subject['student_number'].'</p>';
    }
    if ($subject['assignment_date']) {
        echo '<p><strong>Ημερομηνία Ανάθεσης:</strong> '.$subject['assignment_date'].'</p>';
    }
    if ($subject['pres_date']) {
        echo '<p><strong>Ημερομηνία Παρουσίασης:</strong> '.$subject['pres_date'].'</p>';
    }
    if ($subject['grade'] !== null) {
        echo '<p><strong>Βαθμός:</strong> '.$subject['grade'].'</p>';
    }
    if ($subject['status'] === 'Περατωμένη') {
        echo '<p><a href="https://nemertes.library.upatras.gr/home" target="_blank">
              Δείτε το τελικό κείμενο στο αποθετήριο της βιβλιοθήκης</a></p>';
    }
    echo '</div>';
}
?>
</div>

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
    if($days_asProf_counter> 0) {
      $avg_asProf_days=($days_asProf_counter/$prof_counter);
      echo '<strong>Μέσος χρόνος περάτωσης διπλωματικών:</strong>'.$avg_asProf_days.' μέρες<br><br>';
    }else{echo "";}
    if($grade_asProf_counter>0) {
      $avg_asProf_grade=($grade_asProf_counter/$prof_counter);
      echo '<strong>Μέσος βαθμός διπλωματικών:</strong>'.round($avg_asProf_grade, 2).'<br><br>';
    }else{echo "";}
  echo '<strong>Συνολικό πλήθος διπλωματικών:</strong>'.$prof_counter.' Διπλωματικές<br><br>';

  echo "<h2 class='statTitle'>Ως μέλος τριμελούς επιτροπής</h2>";
    if($days_asMemb_counter> 0) {
      $avg_asMemb_days=($days_asMemb_counter/$member_counter);
      echo '<strong>Μέσος χρόνος περάτωσης διπλωματικών:</strong>'.$avg_asMemb_days.' μέρες<br><br>';
    }else{echo "Δεν βρέθηκαν μαθήματα<br><br>";}
    if($grade_asMemb_counter>0) {
      $avg_asMemb_grade=($grade_asMemb_counter/$member_counter);
      echo '<strong>Μέσος βαθμός διπλωματικών:</strong>'.round($avg_asMemb_grade, 2).'<br><br>';
    }else{echo "Δεν βρέθηκαν μαθήματα<br><br>";}
  echo '<strong>Συνολικό πλήθος διπλωματικών:</strong>'.$member_counter.' Διπλωματικές';

  echo '<form action="stats.php" method="post">
    <button class="button2" type="submit">Αναλυτική Προβολή Στατιστικών</button>';
?>
</div></div>

</body>
</html>

