<?php
require 'connection.php'; 
$uploadDir = 'uploads/';
if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

if (isset($_GET['delete'])) {
    $fileToDelete = basename($_GET['delete']);
    $fullPath = realpath($uploadDir . $fileToDelete);
    if (strpos($fullPath, realpath($uploadDir)) === 0 && file_exists($fullPath)) {
        unlink($fullPath);
        echo "<script>alert('Το αρχείο διαγράφηκε.'); window.location.href='Import_data.php';</script>";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["jsonFile"])) {
    $file = $_FILES["jsonFile"]["tmp_name"];
    $fileType = pathinfo($_FILES["jsonFile"]["name"], PATHINFO_EXTENSION);
    if (strtolower($fileType) !== "json") {
        echo "<script>alert('Παρακαλώ ανεβάστε αρχείο τύπου JSON.'); window.history.back();</script>";
        exit();
    }

    $filename = basename($_FILES["jsonFile"]["name"]);
    $targetPath = $uploadDir . $filename;
    move_uploaded_file($file, $targetPath);

    $jsonData = file_get_contents($targetPath);
    $data = json_decode($jsonData, true);

    if ($data === null) {
        echo "<script>alert('Σφάλμα κατά την ανάγνωση του JSON.'); window.history.back();</script>";
        exit();
    }

    if (isset($data["students"]) && is_array($data["students"])) {
        $stmtStud = $conn->prepare("
            INSERT INTO Students 
            (name, surname, student_number, username, password, street, number, city, postcode, father_name, landline, mobile, email) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        foreach ($data["students"] as $s) {
            $name = $s["name"] ?? null;
            $surname = $s["surname"] ?? null;
            $student_number = $s["student_number"] ?? null;
            $username = $s["username"] ?? null;
            $password = $s["password"] ?? null;
            $street = $s["street"] ?? null;
            $number = $s["number"] ?? null;
            $city = $s["city"] ?? null;
            $postcode = $s["postcode"] ?? null;
            $father_name = $s["father_name"] ?? null;
            $landline = $s["landline_telephone"] ?? null;
            $mobile = $s["mobile_telephone"] ?? null;
            $email = $s["email"] ?? null;

            if ($name && $surname && $student_number && $username && $password && $email) {
                $stmtStud->bind_param("ssisssisissss", $name, $surname, $student_number, $username, $password, $street, $number, $city, $postcode, $father_name, $landline, $mobile, $email);
                $stmtStud->execute();
            }
        }
        $stmtStud->close();
    }

    if (isset($data["professors"]) && is_array($data["professors"])) {
        $stmtProf = $conn->prepare("
            INSERT INTO Professors 
            (name, surname, department, university, username, password, landline, mobile, email, topic)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        foreach ($data["professors"] as $p) {
            $name = $p["name"] ?? null;
            $surname = $p["surname"] ?? null;
            $department = $p["department"] ?? null;
            $university = $p["university"] ?? null;
            $username = $p["username"] ?? null;
            $password = $p["password"] ?? null;
            $landline = $p["landline"] ?? null;
            $mobile = $p["mobile"] ?? null;
            $email = $p["email"] ?? null;
            $topic = $p["topic"] ?? null;

            if ($name && $surname && $email && $username && $password) {
                $stmtProf->bind_param("ssssssssss", $name, $surname, $department, $university, $username, $password, $landline, $mobile, $email, $topic);
                $stmtProf->execute();
            }
        }
        $stmtProf->close();
    }

    echo "<script>alert('Επιτυχής εισαγωγή δεδομένων!'); window.location.href='Import_data.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Εισαγωγή JSON - Σύστημα Διπλωματικών</title>
<style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
  }

  .top-menu {
    background-color: whitesmoke;
    padding: 10px 20px;
    position: fixed;
    top: 0;
    width: 100%;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
  }

  .top-menu img {
    height: 60px;
    margin-right: 20px;
  }

  .menu-title {
    font-size: 24px;
    font-weight: bold;
    color: #000;
  }

  .container {
    margin-top: 120px;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
    padding: 2em;
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  }

  h2 {
    text-align: center;
    margin-bottom: 20px;
  }

  form {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  input[type="file"] {
    margin: 1em 0;
    font-size: 16px;
  }

  button {
    padding: 10px 20px;
    background-color: #0073b7;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  button:hover {
    background-color: #005a96;
  }

  .back-button {
    display: block;
    text-align: center;
    margin-top: 30px;
    color: #0073b7;
    text-decoration: none;
    font-weight: bold;
  }

  .file-list {
    margin-top: 2em;
    text-align: center;
  }

  .file-list ul {
    list-style: none;
    padding: 0;
    display: inline-block;
    text-align: left;
  }

  .file-list li {
    margin: 8px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .delete-link {
    color: red;
    font-weight: bold;
    text-decoration: none;
  }

  .delete-link:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>
  <div class="top-menu">
    <img src="upatrasLogo.jpg" alt="UPatras Logo">
    <div class="menu-title">Σύστημα Υποστήριξης Διπλωματικών Εργασιών</div>
  </div>

  <div class="container">
    <h2>Εισαγωγή JSON Δεδομένων</h2>
    <form action="Import_data.php" method="post" enctype="multipart/form-data">
      <input type="file" name="jsonFile" accept=".json" required><br>
      <button type="submit">Μεταφόρτωση & Εισαγωγή</button>
    </form>

    <div class="file-list">
      <h3>Ανεβασμένα Αρχεία:</h3>
      <ul>
        <?php
        $jsonFiles = glob($uploadDir . "*.json");
        foreach ($jsonFiles as $file) {
          $basename = basename($file);
          echo "<li>$basename <a href='?delete=$basename' class='delete-link' onclick=\"return confirm('Διαγραφή του $basename;');\">✖</a></li>";
        }
        ?>
      </ul>
    </div>

    <a href="SecretariatHomeScreen.php" class="back-button">Επιστροφή στην αρχική σελίδα</a>
  </div>
</body>
</html>