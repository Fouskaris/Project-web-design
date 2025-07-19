<?php
$id = $_POST['id'] ?? null;

if (!$id) {
    die("Μη έγκυρο αίτημα.");
}

$jsonPath = "dipl.json";
$jsonString = file_get_contents($jsonPath);
$data = json_decode($jsonString, true);

$updated = false;

// Εύρεση και ενημέρωση της διπλωματικής
foreach ($data['subjects'] as &$subject) {
    if ($subject['id'] == $id) {
        // Έλεγχος αν έχει βαθμό και σύνδεσμο Νημερτή
        if (!empty($subject['grade']) && !empty($subject['nimertis_link'])) {
            $subject['status'] = "Περατωμένη";
            $updated = true;
        }
        break;
    }
}

if ($updated) {
    file_put_contents($jsonPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $message = "Η διπλωματική ορίστηκε ως Περατωμένη με επιτυχία.";
} else {
    $message = "Αδυναμία αλλαγής κατάστασης: Δεν έχει οριστεί βαθμός ή σύνδεσμος Νημερτή.";
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Αποτέλεσμα Ενημέρωσης</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
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

    .container {
      max-width: 800px;
      margin: 8em auto;
      padding: 30px;
      text-align: center;
      border: 1px solid #ccc;
      border-radius: 10px;
    }

    .message {
      font-size: 20px;
      margin-bottom: 20px;
    }

    .back-button {
      padding: 10px 20px;
      background-color: rgba(36, 190, 49, 0.81);
      color: black;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      font-size: 16px;
      text-decoration: none;
    }

    .back-button:hover {
      background-color: rgba(22, 127, 31, 0.81);
    }
  </style>
</head>
<body>

<div class="top-menu">
  <img src="upatrasLogo.jpg" alt="Logo" style="width: 10em; margin-right: 20px;">
  <div class="menu-title">Σύστημα Υποστήριξης Διπλωματικών Εργασιών</div>
</div>

<div class="container">
  <div class="message"><?= htmlspecialchars($message) ?></div>
  <a class="back-button" href="view_theses.php">Επιστροφή</a>
</div>

</body>
</html>
