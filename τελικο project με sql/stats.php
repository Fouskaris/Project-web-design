<?php

session_start();

if (!isset($_SESSION['Prof_id'])) {
    header('Location: loginScr.php');
    exit;
}
$id = $_SESSION['Prof_id'];

?>
<html>
<head>
 
<style>


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
.title{
    margin: auto;
    text-align: center;
    color: rgba(36, 49, 190, 0.81);;
}
</style>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
     <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Σύστημα Υποστήριξης Διπλωματικών Εργασιών Πανεπηστιμίου Πατρών</title>
    <img src="upatrasLogo.jpg" alt="Centered Image" style="display: block; margin:  50px auto; width: 20em;">
    <hr style="border: 1px solid black; width: 50%;">
<h1 class="title">Αναλυτικά Στατιστικά Καθηγητή</h1>
<h2 class="title" style="margin-top: 1em;">Ως επιβλέπον καθηγητής</h2>
<canvas id="myChart1" style="width: 600px; height: 300px; display: block; margin: 20px auto;"></canvas>
<h2 class="title" style="margin-top: 1em;">Ως μέλος τριμελούς επιτροπής</h2>
<canvas id="myChart2" style="width: 600px; height: 300px; display: block; margin: 20px auto;"></canvas>

<?php
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
$found=false;
$grades = [];
$counter = array_fill(0, 11, 0); 
$counter2 = array_fill(0, 11, 0); 

foreach ($subjects as $subject) {
    if ($subject['status'] == 'Περατωμένη' && $subject['professor_id'] == $id) {
        if (isset($subject['grade']) && is_numeric($subject['grade'])) {
            $counter[$subject['grade']]=$counter[$subject['grade']]+1;
        }
    }
}
foreach ($subjects as $subject) {
  if(($subject['committee']!=null)&&($subject['status']=='Περατωμένη')){
    foreach ($subject['committee'] as $member) { 
        if ($member == $id) {
            $counter2[$subject['grade']]=$counter2[$subject['grade']]+1;
        }}}}
?>
<script>
const ctx = document.getElementById('myChart1').getContext('2d');
const counter = <?php echo json_encode($counter); ?>;

const myChart1 = new Chart(ctx, {
  type: 'bar', 
  data: {
    labels: [0,1,2,3,4,5,6,7,8,9,10], 
    datasets: [{
      label: 'Βαθμολογία',
      data: counter, 
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          precision: 0
        }
      }
    }
  }
});

const ctx2 = document.getElementById('myChart2').getContext('2d');
const counter2 = <?php echo json_encode($counter2); ?>;

const myChart2 = new Chart(ctx2, {
  type: 'bar', 
  data: {
    labels: [0,1,2,3,4,5,6,7,8,9,10], 
    datasets: [{
      label: 'Βαθμολογία',
      data: counter2, 
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          precision: 0
        }
      }
    }
  }
});
</script>

<?php    
  echo '<button class="button" onclick="history.back()">Επιστροφή</button>';
?>

</body>


</html>