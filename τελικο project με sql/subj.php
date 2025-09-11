<!DOCTYPE html>
<html lang="el">
<?php
session_start();
if (!isset($_SESSION['Stud_id'])) {
    header('Location: login.php');
    exit;
}
$id = $_SESSION['Stud_id'];
?>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Σύστημα Υποστήριξης Διπλωματικών Εργασιών Πανεπιστημίου Πατρών</title>
<style>
body {
  margin: 0;
  font-family: Arial, sans-serif;
  padding-top: 120px;
  background: #f5f5f5;
}
.top-menu {
  background-color: whitesmoke;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  padding: 10px 20px;
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 2000;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
.top-menu img {
  width: 8em;
  height: auto;
}
.menu-title {
  font-size: 1.5em;
  font-weight: bold;
  margin-left: 1em;
  flex: 1;
  text-align: left;
}

.submBu {
  justify-content: center;
  align-items: center;
  padding: 8px 12px;
  border: 1px solid rgba(78, 79, 81, 0.81);
  height: 40px;
  width: 150px;
  background:white;
  border-radius: 20px;
  cursor: pointer;  
  text-align: center;
  font-size: 1em;
  margin-top: 10px;
}
.submBu:hover { background: rgba(88, 89, 92, 0.2); }
.wrapper {
  position: relative;
  width: 70%;
  margin: 2em auto;
}
.field {
  margin:auto;
  width: 20em;
  height:2em;
  padding: 0.6em;
  border-radius: 25px;
  border: none;
  outline: none;
  box-shadow: inset 2px 5px 10px rgba(5,5,5,0.1);
  display: flex;
  align-items: center;
  gap: 0.5em;
  background-color: white;
}
.input-field {
  background: none;
  border: none;
  outline: none;
  width: 70%;
  color: black;
}
.input-icon { height: 1.3em; width: 1.3em; fill: black; }
.droppage {
  width: 100%;
  max-width: 600px;
  height: 50px;
  margin: auto;
  text-align: center;
  font-size: 1.2em;
  border: 1px solid rgba(10,10,10,0.85);
  border-radius: 20px;
  cursor: default;
  line-height: 50px;
  background: white;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.5em;
  position: relative;
  z-index: 1;
}
.onHover {
  display: none;
  position: absolute;
  top: 100%;
  left: 0;
  width: 100%;
  z-index: 3000; 
  max-height: 400px;
  overflow-y: auto;
  background: white;
  border: 1px solid #ccc;
  border-radius: 0 0 20px 20px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}
.wrapper:hover .onHover { display: block; }
.wrapper:hover .droppage { background: rgba(196, 93, 24, 0.63); border-radius: 20px 20px 0 0; }
.prof-card-container {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  max-height: 400px;
  overflow-y: auto;
  padding: 10px;
  justify-content: center;
}
.prof-card {
  background: #fff;
  border: 1px solid #ccc;
  border-radius: 15px;
  width: 200px;
  padding: 10px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 5px;
}
.prof-card h4 { margin: 0; font-size: 1em; text-align: center; }
.prof-card p { margin: 0; font-size: 0.9em; text-align: center; }
.prof-card input[type="checkbox"] { margin-top: 5px; }
.depclass, .depclasstext { text-align: center; }
.exDate { margin:auto; margin-top:1em; margin-bottom:1em; font-size:1.2em; }
#finalSub { height: 50px; width: 250px; margin-top:1em; }

@media (max-width:768px){
  body { padding-top: 140px; }
  .top-menu { flex-direction: column; align-items: center; }
  .menu-title { text-align:center; font-size:1.2em; margin:0.5em 0; width:100%; }
  .submBu { width:120px; height:35px; font-size:0.9em; margin-top:0.5em; }
  .wrapper { width:90%; }
  .droppage { font-size:1em; height:45px; }
  .prof-card-container { justify-content:center; max-height:300px; }
  .prof-card { width:45%; }
}
@media (max-width:480px){
  body { padding-top:160px; }
  .menu-title { font-size:1em; }
  .submBu { width:100px; height:30px; font-size:0.8em; }
  .droppage { font-size:0.9em; height:40px; }
  .prof-card { width:90%; }
}
</style>
</head>
<body>

<div class="top-menu">
  <img src="upatrasLogo.jpg" alt="Logo">
  <div class="menu-title">Σύστημα Υποστήριξης Διπλωματικών Εργασιών</div>
</div>

<h1 class="depclasstext">Επιλογή τριμελούς επιτροπής και ημερομηνίας εξέτασης</h1>

<div class="depclass">
<form method="get">
  <div class="field">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="input-icon" viewBox="0 0 16 16">
      <path d="M5.793 1a1 1 0 0 1 1.414 0l.647.646a.5.5 0 1 1-.708.708L6.5 1.707 2 6.207V12.5a.5.5 0 0 0 .5.5.5.5 0 0 1 0 1A1.5 1.5 0 0 1 1 12.5V7.207l-.146.147a.5.5 0 0 1-.708-.708zm3 1a1 1 0 0 1 1.414 0L12 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l1.854 1.853a.5.5 0 0 1-.708.708L15 8.207V13.5a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 4 13.5V8.207l-.146.147a.5.5 0 1 1-.708-.708zm.707.707L5 7.207V13.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5V7.207z"/>
    </svg>
    <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($id); ?>">
    <input name="dep" placeholder="Τμήμα" class="input-field" type="text">
  </div>
  <button class="submBu" type="submit">Υποβολή</button>
</form>
</div>

<?php
$dep="Εισάγετε τμήμα πρώτα!";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $id = isset($_GET["stud_id"]) ? (int)$_GET["stud_id"] :0;
  $dep = $_GET["dep"];  
}
?>

<form action="profReq.php" class="diplForm" style="text-align: center;" method="POST" >
<div class="wrapper">
  <div class="droppage">-Επιλογή Τριμελούς Επιτροπής&nbsp;&nbsp;&nbsp;
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
      <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"/>
    </svg>
  </div>
  <div class="onHover">
  <?php
    if($dep!="Εισάγετε τμήμα πρώτα!"){  
      $jsonString = file_get_contents("export.json");
      $data = json_decode($jsonString, true);
      $professors = $data['professors'];
      $ok=0;
      foreach ($professors as $professor) {
        if ($professor['department']==$dep){$ok=1; break;}
      }
      if($ok==1){
        echo '<div class="prof-card-container">';
        foreach ($professors as $professor) {
          if ($professor['department']==$dep){
            $value=htmlspecialchars($professor['id']); 
            echo '<div class="prof-card">
                    <h4>'.htmlspecialchars($professor['surname']).'</h4>
                    <p><strong>ID:</strong> '.htmlspecialchars($professor['id']).'</p>
                    <p><strong>Τομέας:</strong> '.htmlspecialchars($professor['topic']).'</p>
                    <p><strong>Email:</strong> '.htmlspecialchars($professor['email']).'</p>
                    <input type="checkbox" name="selectedProfs[]" value="'.$value.'">
                  </div>';
          }
        }
        echo '</div>';
      } else { 
        echo "<h1>Δεν βρέθηκαν καθηγητές από αυτό το τμήμα</h1>";
      }
    } else {
      echo "<h1 class='warn'>$dep</h1>";
    }
  ?>
  </div>
</div>
<input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($id); ?>">
<button class="submBu" id="finalSub" type="submit">Υποβολή Αιτημάτων</button>
</form>

<hr style="border: 1px solid black; width: 90%;">

<form class="diplForm" action="progrDipl.php" style="text-align: center;" method="POST">
<div class="wrapper">
  <div class="droppage">-Ορισμός Ημερομηνίας Εξέτασης&nbsp;&nbsp;&nbsp;
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
      <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
    </svg>
  </div>
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
<hr style="border: 1px solid black; width: 50%;">

<div class="wrapper">
  <div class="droppage">-Ορισμός Αίθουσας&nbsp;&nbsp;&nbsp;
   <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flask" viewBox="0 0 16 16">
  <path d="M4.5 0a.5.5 0 0 0 0 1H5v5.36L.503 13.717A1.5 1.5 0 0 0 1.783 16h12.434a1.5 1.5 0 0 0 1.28-2.282L11 6.359V1h.5a.5.5 0 0 0 0-1zM10 2H9a.5.5 0 0 0 0 1h1v1H9a.5.5 0 0 0 0 1h1v1H9a.5.5 0 0 0 0 1h1.22l.61 1H10a.5.5 0 1 0 0 1h1.442l.611 1H11a.5.5 0 1 0 0 1h1.664l.611 1H12a.5.5 0 1 0 0 1h1.886l.758 1.24a.5.5 0 0 1-.427.76H1.783a.5.5 0 0 1-.427-.76l4.57-7.48A.5.5 0 0 0 6 6.5V1h4z"/>
  </svg>  
  </div>
  <div class="onHover">
    <label for="exDate">Αίθουσα Εξέτασης:</label>
    <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($id); ?>">
    <select class="exDate" id="pres_class" name="time">
      <option value="δια ζώσης">Δια ζώσης</option>
      <option value="διαδικτυακά">Διαδικτυακά</option>
    </select>
    <div class="class">

  <div class="field">
    <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($id); ?>">
    <input name="class" placeholder="Link ή Αίθουσα" class="input-field" type="text">
    

  </div><hr style="border: 1px solid black; width: 90%;">
</div>
  </div>
</div>
<button class="submBu" id="finalSub" type="submit" onclick="alert('Η υποβολή έγινε με επιτυχία!')">Υποβολή Ημερομηνίας και Αίθουσας</button>
</form>
<hr style="border: 1px solid black; width: 90%;">

</body>
</html>
