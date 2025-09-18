<!DOCTYPE html>
<html lang="el">
<?php
session_start();
if (!isset($_SESSION['Stud_id'])) {
    header('Location: loginScr.php');
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
  }

  .top-menu {
    background-color: whitesmoke;
    display: flex;
    align-items: center;
    padding: 10px 20px;
    position: fixed;
    top: 0;
    width: 100%;
    box-sizing: border-box;
    flex-wrap: wrap;
    z-index: 1000;
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

  .button, .buttonNotif {
    display: flex;
    justify-content: center;
    align-items: center;
    background: white;
    border-radius: 20px;
    cursor: pointer;
    margin-left: 10px;
  }

  .button {
    padding: 6px 12px;
    gap: 8px;
    height: 40px;
    border: none;
  }

  .buttonNotif {
    padding: 6px 12px;
    border: 1px solid rgba(78, 79, 81, 0.81);
    height: 40px;
    width: 50px;
  }

  .button:hover, .buttonNotif:hover, .submBu:hover, .AddFileSpace:hover {
    background: rgba(88, 89, 92, 0.2);
  }

  .lable {
    font-size: 1em;
    color: black;
  }

  h1 {
    text-align: center;
    margin-top: 6em;
    margin-bottom: 1em;
  }

  .h1file {
    margin-top: 2em;
  }

  .filebuts {
    margin-top: 2em;
    text-align: center;
  }

  .submBu {
    justify-content: center;
    align-items: center;
    padding: 8px 12px;
    gap: 8px;
    border: 1px solid rgba(78, 79, 81, 0.81);
    height: 40px;
    width: 100px;
    background: white;
    border-radius: 20px;
    cursor: pointer;
    text-align: center;
    font-size: 1em;
  }

  .AddFileSpace {
    border: none;
    background-color: white;
    cursor: pointer;
  }

  @media (max-width: 768px) {
    .top-menu {
      flex-direction: column;
      align-items: center;
    }

    .menu-title {
      font-size: 1.2em;
      margin: 0.5em 0;
      text-align: center;
      width: 100%;
    }

    .top-menu img {
      width: 6em;
      margin: auto;
    }

    .button, .buttonNotif {
      margin: 5px 0;
    }

    h1 {
      font-size: 1.5em;
      margin-top: 8em;
    }

    .submBu {
      width: 80px;
      height: 35px;
      font-size: 0.9em;
    }
  }

  @media (max-width: 480px) {
    .menu-title {
      font-size: 1em;
    }

    .lable {
      font-size: 0.9em;
    }

    h1 {
      font-size: 1.2em;
      margin-top: 10em;
    }

    .submBu {
      width: 70px;
      height: 30px;
      font-size: 0.8em;
    }
  }
</style>
</head>
<body>

<div class="top-menu">
  <img src="upatrasLogo.jpg" alt="Image">
  <div class="menu-title">Σύστημα Υποστήριξης Διπλωματικών Εργασιών</div>
  <button class="button">
    <span class="lable">
            <?php
        $jsonString = file_get_contents("export.json");
        $data = json_decode($jsonString, true);
        $students = $data['students'];
        $stud_num = "";
        foreach ($students as $student) {
          if ($student['id'] == $id) {
            $stud_num = $student['student_number'];
            break;
          }
        }
        echo $stud_num;
      ?>
    </span>
  </button>
</div>

<?php
$jsonString = file_get_contents("dipl.json");
$data = json_decode($jsonString, true);
$subjects = $data['subjects'];
$subj_id = 0;
$subj_name = "";
foreach ($subjects as $subject) {
  if ($subject['student_number'] == $stud_num) {
    $subj_id = $subject['id'];
    $subj_name = $subject['name'];
    break;
  }
}

if ($subj_id == 0) {
  echo "<h1 style='color:red;'>Πρέπει να υπάρχει ενεργή διπλωματική εργασία για να ανεβάσεις αρχεία</h1>";
} else {
  echo "<h1>$subj_name</h1>";
  echo "<h1 class='h1file'>Ανεβασμένα Αρχεία:</h1>";
  echo "<div style='margin:auto; text-align:center;'>";
  $fileCount = 0;
  foreach ($subjects as $subject) {
    if ($subject['id'] === $subj_id && isset($subject['file']) && is_array($subject['file'])) {
      $fileCount = count($subject['file']);
      foreach ($subject["file"] as $filename) {
        echo "<a href='uploads/$filename' download>$filename</a><br>";
      }
      break;
    }
  }
  if ($fileCount === 0) echo '<h2>Δεν βρέθηκαν αρχεία</h2>';
  echo "</div>";
}
?>

<?php if ($subj_id != 0): ?>
<h1 class="h1file">Ανέβασε Αρχεία:</h1>
<form action="upload.php" method="post" enctype="multipart/form-data" style="text-align:center; font-size:1em;">
  <div id="fileInputs">
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
    <input type="hidden" name="stud_id" value="<?php echo $id; ?>">
    <input type="hidden" name="subj_id" value="<?php echo $subj_id; ?>">
    <button class="submBu" type="submit">Υποβολή</button>
  </div>
</form>
<div style="text-align:center; margin-top:20px;">
  <a href="StudentHomeScreen.php?id=<?php echo $id; ?>" class="submBu" style="text-decoration: none;">Επιστροφή</a>
</div>
<?php endif; ?>

<script>
let fileCounter = 2;
function addFileInput() {
  const container = document.getElementById("fileInputs");
  const newDiv = document.createElement("div");
  newDiv.innerHTML = `<label for="myfile${fileCounter}">${fileCounter}.</label>
    <input type="file" id="myfile${fileCounter}" name="myfile[]"><br><br>`;
  container.appendChild(newDiv);
  fileCounter++;
}
</script>

</body>
</html>

