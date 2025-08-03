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
      display: none;
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
  $id = isset($_POST['stud_id']) ? (int)$_POST['stud_id'] : 0;
  $jsonString= file_get_contents("export.json");
  $data= json_decode($jsonString,true);
  $students = $data['students']; 
  echo $id;
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
      echo $professor;
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
        echo $professor;
        $newNotification['id'] = uniqid();
        $prof['notifications'][] = $newNotification;
        break;
    }
    }}
    file_put_contents('export.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "<h1 style='margin-left:auto;margin-top:5em;'>Επιτυχής Αποστολή Αιτημάτων: " . htmlspecialchars($newNotification['message']) . "</h1>";  
} else {
    echo "Δεν επιλέχθηκαν καθηγητές";
}
?>


<button class="retbut" onclick="history.back()">Επιστροφή</button>
</body>
</html>



