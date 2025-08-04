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
<h1 class="title">Διαχείρηση Κατάστασης Διπλωματικών</h1>
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
$found=false;
foreach ($subjects as $subject) {
    if (($subject['status'] != 'Περατωμένη') && ($subject['professor_id'] == $id)) {
      $found=true;
      break;
    }}
if($found==true){
echo "<table border='1' style='border-collapse: collapse;'>
        <tr>
          <th>Θέμα</th>
          <th>Φοιτητής</th>
          <th>Κατάσταση</th>
          <th>Ενέργεια</th>
          
        </tr>";
foreach ($subjects as $subject) {
    if (($subject['professor_id'] == $id)&&($subject['status'] != "Περατωμένη")) {
        echo "<tr>
          <td>" . htmlspecialchars($subject['name']) . "</td>";
         if ($subject["student_number"] == 0) {echo "<td>" .'Δεν έχει ανατεθεί' . "</td>";}else{
            echo "<td>" .htmlspecialchars($subject['student_number']) . "</td>";}
         echo "<td>" . "<form action='changeStatus.php' method='post'>
          <label>";
          if ($subject["status"] == "Διαθέσιμη") {
            echo "<label><input type='radio' name='choice' value=1 checked>Διαθέσιμη</label><br>
                  <label><input type='radio' name='choice' value=2 >Ενεργή</label><br>
                  <label><input type='radio' name='choice' value=3 >Υπό Εξέταση</label><br>" . "</td>";
          }elseif ($subject["status"] == "Ενεργή") {
            echo "
                  <label><input type='radio' name='choice' value=2 checked>Ενεργή</label><br>
                  <label><input type='radio' name='choice' value=3 >Υπό Εξέταση</label><br>" ;
                  $exDate=$subject['assignment_date'];
            if($exDate){
              $today = date("Y-m-d");
              $todayDate = new DateTime($today);
              $exDateObj = new DateTime($exDate);
              $interval = $exDateObj->diff($todayDate);
              $totalDays= $interval->days;
              $subj_id=$subject["id"];
              if ($totalDays > 731) {
                echo "<p style='color:red'>Έχουν περάσει πάνω από δύο χρόνια από την ημερομηνία ανάθεσης(". $totalDays ." μέρες)</p>
                <label><input type='radio' name='choice' value=4>Ακύρωση</label><br></td>";
              }
            }
          }elseif ($subject["status"] == "Υπό Εξέταση"){
                  echo "<label><input type='radio' name='choice' value=1>Διαθέσιμη</label><br>
                  <label><input type='radio' name='choice' value=2>Ενεργή</label><br>
                  <label><input type='radio' name='choice' value=3 checked>Υπό Εξέταση</label><br>" . "</td>";
                }
          $subj_id=$subject['id'];
          echo " <td>
            <input type='hidden' name='id' value='$subj_id'><button class='listButton' type='submit'>
            <svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' fill='currentColor' class='bi bi-arrow-right-square-fill' viewBox='0 0 16 16'>
            <path d='M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1'/>
            </svg></button></form></td>";
    }}
    echo "</table>";
  }else{
      echo "<h2 class='title' >Δεν υπάρχουν μη περατωμένα μαθήματα</h1>";   
  }
?>
<h1 style="margin-top:1em;text-align: center;">Ανάθεση και Αλλαγή Διπλωματικών</h1>
<?php
$found=false;
foreach ($subjects as $subject) {
    if (($subject['status'] == 'Διαθέσιμη') && ($subject['professor_id'] == $id)) {
      $found=true;
      break;
    }}
if($found==true){
echo "<table border='1' style='border-collapse: collapse;'>
        <tr>
          <th>Θέμα</th>
          <th>Περιγραφή</th>
          <th>Ανάθεση</th>
          <th>Ενέργεια</th>
        </tr>";
foreach ($subjects as $subject) {
    if (($subject['status'] == 'Διαθέσιμη') && ($subject['professor_id'] == $id)) {
    echo "<tr><form action='change_assign.php' method='POST'>";
    echo "<td><textarea class='inp' name='name' style='width:100%;'>" . 
     htmlspecialchars($subject['name'], ENT_QUOTES, 'UTF-8') . 
     "</textarea></td>";   
    echo "<td><textarea class='inp' name='description' style='width:100%;'>" . 
     htmlspecialchars($subject['description'], ENT_QUOTES, 'UTF-8') . 
     "</textarea></td>";    
    echo "<input type='hidden' name='subj_id' value='" . htmlspecialchars($subject['id'], ENT_QUOTES, 'UTF-8') . "'>";
    echo "<input type='hidden' name='id' value='" . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . "'>";
    echo "<td><input class='inp'  style='width: 150px;' type='text' name='student' placeholder='Όνομα ή ΑΜ Φοιτητή'> </td>";
    echo "<td><button class='listButton' type='submit'>Υποβολή</button></td>";
    echo "</form></tr>";}}
    echo "</table>";
     }else{
        echo "<h2 class='title' >Δεν υπάρχουν μαθήματα για ανάθεση ή αλλαγή</h1>";   
       }    
echo "<h1 class='title' >Βαθμολόγηση Διπλωματικών</h1>";
$found=false;
foreach ($subjects as $subject) {
    if (($subject['status'] == 'Υπό Εξέταση') && ($subject['professor_id'] == $id)) {
      $found=true;
      break;
    }}
if($found==true){
echo "<table border='1' style='border-collapse: collapse; margin-bottom:1em;'>
        <tr>
          <th>Θέμα</th>
          <th>Φοιτητής</th>
          <th>Βαθμός</th>
          <th>Ενέργεια</th>
        </tr>"; 
foreach ($subjects as $subject) {
    if (($subject["status"] == "Υπό Εξέταση") && ($subject["professor_id"] == $id)) {
        echo "<tr><form action='grade_subj.php' method='POST'>";
        echo "<td>" . htmlspecialchars($subject['name'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>AM: " . $subject['student_number']. "</td>";
        echo "<td><input class='inp' style='width: 150px;' type='text' name='student_grade' placeholder='1-10' required></td>";
        echo "<td>
                <input type='hidden' name='id' value='" . htmlspecialchars($subject['id'], ENT_QUOTES, 'UTF-8') . "'>
                <input type='submit' name='grade' class='listButton' value='Υποβολή Βαθμού'>
              </td>";

        echo "</form></tr>";
    }
}

echo "</table>";
}else{
  echo "<h2 class='title' >Δεν υπάρχουν μαθήματα για βαθμολόγηση</h1>";   
}

    ?>
    

</body>
</html>


