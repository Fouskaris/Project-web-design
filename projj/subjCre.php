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
  right: 10px;
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

.buttonNotif:hover {
  background:rgba(88, 89, 92, 0.29);
}

.lable {
  font-size: 20px;
  color:black;
}

.button:hover {
  background:rgba(88, 89, 92, 0.29);
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
  position: relative;
  margin-top: 1%;
  bottom: 15px;
  right: 15px;
  padding: 8px 14px;
  background-color: rgba(36, 190, 49, 0.81);
  color: black;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
}

.button:hover {
  background-color: rgba(22, 127, 31, 0.81);
}
.AddFileSpace {
      border: none;
      background-color: white;
      cursor: pointer;
    }

    .filebuts {
      margin-top: 2em;
    }
.dropbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
.subjChoose{margin-top: 2%;}

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
$prof_id = isset($_POST['id']) ? (int)$_POST['id'] : null;
$jsonString = file_get_contents("export.json");
$data = json_decode($jsonString, true);
$professors= $data["professors"];
foreach ($professors as $professor) {
    if ($professor["id"] == $prof_id) {
        $foundprof=$professor;
        $surname=$professor["surname"];
    }
}
?>
    <form action="submSubj.php" method="post" >
    <div class="container">
    <div class="card">
    <h2 style=><strong>Δημιουργία Θέματος Διπλωματικής</strong></h2>
    <strong>Τίτλος:</strong>  <input type="text" name="name" required> <br>
    <strong>Περιγραφή:</strong>   <textarea name="description" rows="10" cols="30"></textarea>  <br>
    <input type="hidden" name="prof_id" value="<?php echo $prof_id; ?>">
    <input type="hidden" name="prof_surname" value="<?php echo $surname; ?>">
    <button class="button" type="submit" onclick="">Υποβολή Θέματος</button>
    </form>
    <form action="upload.php" method="post" enctype="multipart/form-data" style="text-align:center; font-size:20px;">
    </div>
    </div>

    <div class="container">
    <div class="card">
    <strong>Υποβολή Αρχείων Mαθήματος:</strong>
    <div id="fileInputs">
    <?php 
    $jsonString2 = file_get_contents("dipl.json");
    $data2 = json_decode($jsonString2, true);
    $subjects= $data2["subjects"];
    foreach ($subjects as $subject) {
      if (($subject["professor_id"] == $prof_id)&&($subject["status"] != "Περατωμένη")) {
        $subj_id=$subject["id"];
        $subject_name=$subject["name"];
        echo "<input type='checkbox'  name='id' class='subjChoose' value='$subj_id' id='$subj_id' ><label  style='margin-top:2%;margin-bottom:2%;font-size:1em'for='$subj_id'>$subject_name</label><br>";
      }}
    ?>
    <label for="myfile1">1.</label>
      <input type="file" id="myfile1" name="myfile[]"><br><br>  
    </div>


    <div class="filebuts">
      <button class="AddFileSpace" type="button" onclick="addFileInput()">
        <svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' fill='currentColor' class='bi bi-plus-square' viewBox='0 0 16 16'>
          <path d='M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z'/>
          <path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4'/>
        </svg>
      </button>
    <button class="button" type="submit">Υποβολή Αρχείων</button>
    </div></div>
    </form>


<script>
let fileCounter = 2;

function addFileInput() {
  const container = document.getElementById("fileInputs");

  const newDiv = document.createElement("div");
  newDiv.innerHTML = `
    <label for="myfile${fileCounter}">${fileCounter}.</label>
    <input type="file" id="myfile${fileCounter}" name="myfile[]"><br><br>
  `;
  container.appendChild(newDiv);
  fileCounter++;
}
</script>
</body>

</html>