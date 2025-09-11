<?php
  $stud_id = $_POST['stud_id'] ?? '';
    $exDate = $_POST['exDate'] ?? '';
    $time = $_POST['time'] ?? '';
    $pres_class = $_POST['class'] ?? '';

    $stud_id = htmlspecialchars(trim($stud_id));
    $exDate = htmlspecialchars(trim($exDate));
    $time = htmlspecialchars(trim($time));
    

    echo "Student ID: " . $stud_id . "<br>";
    echo "Date: " . $exDate . "<br>";
    echo "Time Slot: " . $time . "<br>";

  $jsonString= file_get_contents("export.json");
  $data= json_decode($jsonString,true);
  $students = $data['students']; 

  foreach($students as $student){ ;
    if ($student['id']==$stud_id){
      $stud_num = $student['student_number'];
      $surname = $student['surname'];
      $name= $student['name'];
    }
  }
  $jsonString2= file_get_contents("dipl.json");
  $data2= json_decode($jsonString2,true);
  $subjects = &$data2["subjects"];
  foreach($subjects as &$subject){   
    if ($subject["student_number"]==$stud_num){
        $subj_name = $subject["name"];
        $subject['pres_date']= $exDate;
        $subject['pres_class']=$pres_class;
    }}
date_default_timezone_set('Europe/Athens');
$today = date("Y-m-d");
if ($exDate){
  $todayDate =new DateTime($today);
  $exDateObj = new DateTime($exDate);
  if ($exDateObj > $todayDate) {
    $interval = $todayDate->diff($exDateObj);
    echo "Μένουν " . $interval->days . " ημέρες μέχρι την εξέταση.";
} elseif ($exDateObj == $todayDate) {
    echo "Η εξέταση είναι σήμερα!";
} else {
    echo "Περασμένη ημερομηνία";
}
}
file_put_contents("dipl.json", json_encode($data2, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo '<script>history.back();</script>';
?>


