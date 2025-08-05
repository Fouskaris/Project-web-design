<?php

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: loginScr.php');
    exit;
}
$id = $_SESSION['id'];

?>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Σύστημα Υποστήριξης Διπλωματικών Εργασιών Πανεπηστιμίου Πατρών</title>
    <img src="upatrasLogo.jpg" alt="Centered Image" style="display: block; margin:  50px auto; width: 20em;">
    <hr style="border: 1px solid black; width: 50%;">
<style>
    .form .btn {
  display: flex;
  justify-content: center;
  flex-direction: row;
  margin-top: 1em;
}

.button1 {
  padding: 0.5em;
  margin:auto;
  width:10%;
  border-radius: 5px;
  border: none;
  outline: none;
  transition: .4s ease-in-out;
  background-color: #252525;
  color: white;
}

.button1:hover {
  background-color: black;
  color: white;
}
.form {
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding-left: 2em;
  padding-right: 2em;
  padding-bottom: 0.4em;
  background-color: white;
  border-radius: 10px;
  
}


#heading, #heading1 {
  text-align: center;
  color: black;
  font-size: 1em;
}

#heading1{
    font-size: 2em;
    color:red;
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
  bottom: 15px;
  right: 15px;
  padding: 8px 14px;
  background-color: rgba(36, 190, 49, 0.81);
  color: black;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  position: absolute;
}

.button:hover {
  background-color: rgba(22, 127, 31, 0.81);
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
    $subjectFound = $subject;}}
if ($subjectFound) {
    echo '<div class="container">';
    echo '<div class="card">';
    echo '<strong>Τίτλος:</strong> ' . htmlspecialchars($subjectFound['name']) . '<br>';
    echo '<strong>Περιγραφή:</strong> ' . htmlspecialchars($subjectFound['description']) . '<br>';
    echo '<strong>Επιβλέπων:</strong> ' . htmlspecialchars($subjectFound['professor_surname']) . '<br>';
    echo '<strong>ΑΜ Φοιτητή:</strong> ' . htmlspecialchars($subjectFound['student_number']) . '<br>';
    echo '<strong>Κατάσταση:</strong> ' . htmlspecialchars($subjectFound['status']) . '<br>';
    echo '<strong>Τριμελής Επιτροπή:</strong>' ;
    foreach($subjectFound['committee'] as $prof_id){
      foreach($professors as $professor) {
        if($professor['id'] == $prof_id) {
          echo $professor['surname'].' '.$professor['name'].'<br>Τομέας:'. $professor['department'],'<br><hr style=" margin-left:0;border: 1px solid black; width: 10%;">'; 
        }
    }
    }    
    echo '<strong>Ημερομηνία Ανάθεσης:</strong> ' . htmlspecialchars($subjectFound['assignment_date']) . '<br>';
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
  echo' <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($id); ?>">';
  echo '<button class="button" onclick="history.back()">Επιστροφή</button>';
  echo '</div>';
  echo '</div>';
  } 
?>

</body>


</html>
