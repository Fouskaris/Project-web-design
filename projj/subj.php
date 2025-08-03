<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Σύστημα Υποστήριξης Διπλωματικών Εργασιών Πανεπηστιμίου Πατρών</title>
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
 
  .button1 {
  margin-left: auto;
  font-size: 30px;
  margin-top:15px;
}
  .button1 svg{
    width: 100px; 
    height: 100px;
  }
.button {
  margin-left: auto;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 8px 12px 8px 16px;
  gap: 8px;
  height: 40px;
  width: 250px;
  border: none;
  background:white;
  border-radius: 20px;
  cursor: pointer;
}
.buttonNotif{
  position:absolute;
  right: 1px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 8px 12px 8px 12px;
  gap: 8px;
  border: 1px solid rgba(78, 79, 81, 0.81);
  height: 40px;
  width: 60px;
  background:white;
  border-radius: 20px;
  cursor: pointer;
}
.buttonNotif .submBu :hover {
  background:rgba(88, 89, 92, 0.29);
}

.lable {
  font-size: 20px;
  color:black;
}

.button:hover {
  background:rgba(88, 89, 92, 0.29);
}
.wrapper {
  position: relative;
  width: 70%;
  margin: 2em auto;
}
.field {
  margin:auto;
  width: 20em;
  height:2em;
  align-items: center;
  justify-content: center;
  gap: 0.5em;
  border-radius: 25px;
  padding: 0.6em;
  border: none;
  outline: none;
  color: white;
  background-color: white;
  box-shadow: inset 2px 5px 10px rgb(5, 5, 5);
}
.input-field {
  background: none;
  border: none;
  outline: none;
  width: 70%;
  color: black;
}
.input-icon {
  height: 1.3em;
  width: 1.3em;
  fill: black;
}
.droppage {
  width: 100%;
  height: 50px;
  text-align: center;
  font-size: 1.5em;
  border: 1px solid rgba(10, 10, 10, 0.85);
  border-radius: 20px;
  cursor: default;
  line-height: 50px;
  background: white;
}
.onHover {
  display: none;
  position: absolute;
  top: 100%;
  left: 0;
  text-align: center;
  width: 100%;
  height: fit-content;
  text-align: center;
  background: white;
  border: 1px solid #ccc;
  font-size: 1em;
  border-radius: 0 0 20px 20px;
  cursor: pointer;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  z-index: 1000;
}
.wrapper:hover .onHover {
  display: block;
}
.wrapper:hover .droppage {
  background: rgba(196, 93, 24, 0.63);
  border-radius: 20px 20px 0 0;
}
.depclass{
  margin: 0;
  margin-top: 2em;
  align-items: center; 
  text-align: center;
  justify-content: center; 
  }
.depclasstext{
    margin-top: 4em;
    align-items: center; 
    text-align: center;
    justify-content: center; 
  }
.warn{
    color: red;
  }
.submBu{
  justify-content: center;
  align-items: center;
  padding: 8px 12px 8px 12px;
  gap: 8px;
  border: 1px solid rgba(78, 79, 81, 0.81);
  height: 40px;
  width: 100px;
  background:white;
  border-radius: 20px;
  cursor: pointer;  
  text-align: center;
}
.submBu:hover{
  background:rgba(88, 89, 92, 0.29);
}
#finalSub{
  height: 80px;
  width: 300px;
  margin-left:auto;
  font-size:1.5em;
}
.exDate{
    margin:auto;
    margin-top:1em;
    margin-bottom:1em;
    font-size:2em;
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
  <?php 
  $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
  $jsonString= file_get_contents("export.json");
  $data= json_decode($jsonString,true);
  $students = $data['students']; 
  foreach($students as $student){ ;
    if ($student['id']==$id){
      $stud_num = $student['student_number']; }
  }
  ?>
</button>
</div >
<h1 class="depclasstext">Κείμενο</h1>
  <div class="depclass"><form  method="get">
    <div class="field">
       <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="input-icon" viewBox="0 0 16 16">
          <path d="M5.793 1a1 1 0 0 1 1.414 0l.647.646a.5.5 0 1 1-.708.708L6.5 1.707 2 6.207V12.5a.5.5 0 0 0 .5.5.5.5 0 0 1 0 1A1.5 1.5 0 0 1 1 12.5V7.207l-.146.147a.5.5 0 0 1-.708-.708zm3 1a1 1 0 0 1 1.414 0L12 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l1.854 1.853a.5.5 0 0 1-.708.708L15 8.207V13.5a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 4 13.5V8.207l-.146.147a.5.5 0 1 1-.708-.708zm.707.707L5 7.207V13.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5V7.207z"/>
        </svg>
        <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($id); ?>">
        <input  name="dep" placeholder="Τμήμα" class="input-field" type="text" >
        </div>
    <button class="submBu" type="submit">Υποβολή</button>
  </form></div>

  <?php
  $dep="Εισάγετε τμήμα πρώτα!";
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
      $id = isset($_GET["stud_id"]) ? (int)$_GET["stud_id"] :0;
      $dep = $_GET["dep"];  
    }
  ?>
  <form action="profReq.php" class="diplForm" style="text-align: center;" method="POST" >
    <div class="wrapper">
    <div class="droppage" >-Επιλογή Τριμελούς Επιτροπής&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
    <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"/>
    </svg></div>
    <div class="onHover">
    <?php 
    if($dep!="Εισάγετε τμήμα πρώτα!"){  $jsonString = file_get_contents("export.json");
        $data = json_decode($jsonString, true);
        $professors = $data['professors'];
        $ok=0;
        foreach ($professors as $professor) {
          if ($professor['department']==$dep){$ok=1; break;}}
        if($ok==1){echo "<h2>Αίτημα καθηγητών τμήματος $dep $id</h2>";
        echo "<table border='1' style='border-collapse: collapse;margin:auto;'>
            <tr>
              <th>Κωδικός Καθηγητή</th>
              <th>Όνομα</th>
              <th>Τομέας</th>
              <th>Email</th>
              <th>Πρόσκληση</th>
            </tr>";        
          foreach ($professors as $professor) {
            if ($professor['department']==$dep){
              $value=htmlspecialchars($professor['id']); 
              echo "<tr>
                <td>" . htmlspecialchars($professor['id']) . "</td>
                <td>" . htmlspecialchars($professor['surname']) . "</td>
                <td>" . htmlspecialchars($professor['topic']) . "</td>
                <td>" . htmlspecialchars($professor['email']) . "</td>
                <td><label>
                <input type='checkbox' name='selectedProfs[]'  value='$value'>
                </label></td>
              </tr>";
            }}
              echo "</table>";}else{ echo "<h1>Δεν βρέθηκαν καθηγητές από αυτό το τμήμα</h1>";}
      }else{echo "<h1 class='warn'>$dep</h1>";}
      
    ?></div>
  </div>
<input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($id); ?>">
<button class="submBu" id="finalSub" type="submit" >Υποβολή Αιτημάτων</button>
</form>
  <hr style="border: 1px solid black; width: 90%;">
  <form class="diplForm" action="progrDipl.php" style="text-align: center;" method="POST" >
    <div class="wrapper">
    <div class="droppage" >-Ορισμός Ημερομηνίας Εξέτασης&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
    </svg></div>
    <div class="onHover">
      <label for="exDate">Ημερομηνία Εξέτασης:</label>
      <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($id); ?>">
      <input type="date" class="exDate" name="exDate">
      <label for="time">&nbsp;&nbsp;&nbsp;Ώρα:</label>
      <select class="exDate" id="time" name="time">
        <option value="9.00-11.00">9.00-11.00</option>
        <option value="11.00-13.00">11.00-13.00</option>
        <option value="13.00-15.00">13.00-15.00</option>
        <option value="15.00-17.00">15.00-17.00</option>
        <option value="17.00-19.00">17.00-19.00</option>
        <option value="19.00-21.00">19.00-21.00</option>
      </select>
    </div>
    </div>

    <button class="submBu" id="finalSub" type="submit" onclick="alert('Η υποβολή έγινε με επιτυχία!')" >Υποβολή Ημερομηνίας</button>
</form>

</body>
</html>
