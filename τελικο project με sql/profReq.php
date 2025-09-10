
<?php
  $id = isset($_POST['stud_id']) ? (int)$_POST['stud_id'] : 0;
  $jsonString= file_get_contents("export.json");
  $data= json_decode($jsonString,true);
  $students = $data['students']; 
  foreach($students as $student){ ;
    if ($student['id']==$id){
      $stud_num = $student['student_number'];
      $surname = $student['surname'];
      $name= $student['name'];
    }
  }
  $jsonString2= file_get_contents("dipl.json");
  $data2= json_decode($jsonString2,true);
  $subjects = $data2["subjects"];
  foreach($subjects as $subject){   
    if ($subject["student_number"]==$stud_num){
        $subj_name = $subject["name"];
    }}
date_default_timezone_set('Europe/Athens');
$today = date("d-m-Y H:i:s");
if (isset($_POST['selectedProfs'])) {
    $selected = $_POST['selectedProfs']; 
    foreach ($selected as $professor) {
        $newNotification = [
    "message" => "O φοιτητής $surname $name με αριθμό μητρώου $stud_num, υπέβαλε αίτημα συμμετοχής σας στην τριμελή επιτροπή για την εξέταση του θέματος $subj_name. ",
    "date" => $today,
    "by" => $stud_num,             
    "to" => $professor,
    "seen" => "no",
    "type"=>"request" 
    ];
    
    $professors=&$data['professors'];
    foreach ($professors as &$prof) {
      if ($prof['id']==$professor) {
        $newNotification['id'] = uniqid();
        $prof['notifications'][] = $newNotification;
        break;
    }
    }}
    file_put_contents('export.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "<h1 style='margin-left:auto;margin-top:5em;'>Επιτυχής Αποστολή Αιτημάτων" ."</h1>";  
} else {
    echo "Δεν επιλέχθηκαν καθηγητές";
}
?>




