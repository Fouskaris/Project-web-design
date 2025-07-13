<?php
require 'connection.php';

$thesis_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($thesis_id <= 0) {
    die("Μη έγκυρο ID διπλωματικής.");
}

$sql = "
SELECT T.*, 
       S.name AS student_name, S.surname AS student_surname,
       P.name AS professor_name, P.surname AS professor_surname,
       TT.title, TT.summary
FROM Theses T
JOIN Students S ON T.student_id = S.id
JOIN Theses_Topics TT ON T.topic_id = TT.id
JOIN Professors P ON TT.professor_id = P.id
WHERE T.id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $thesis_id);
$stmt->execute();
$result = $stmt->get_result();
$thesis = $result->fetch_assoc();
if (!$thesis) {
    die("Δεν βρέθηκε η διπλωματική.");
}

// Υπολογισμός ημερών από ανάθεση
$days_since_assignment = null;
if (!empty($thesis['assignment_date']) && $thesis['assignment_date'] !== '0000-00-00') {
    $assignment_date = new DateTime($thesis['assignment_date']);
    $today = new DateTime();
    $interval = $today->diff($assignment_date);
    $days_since_assignment = $interval->days;
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Λεπτομέρειες Διπλωματικής</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
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
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      z-index: 1000;
    }

    .menu-title {
      font-size: 24px;
      font-weight: bold;
      margin-left: 1em;
    }

    .container {
      max-width: 800px;
      margin: 100px auto 30px auto;
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    h2 {
      color: #0073b7;
      margin-bottom: 20px;
    }

    .row {
      margin-bottom: 15px;
    }

    .label {
      font-weight: bold;
      color: #333;
      display: block;
      margin-bottom: 5px;
    }

    .value {
      color: #555;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      padding: 8px 14px;
      background-color: #0073b7;
      color: white;
      text-decoration: none;
      border-radius: 8px;
    }

    .back-link:hover {
      background-color: #005a94;
    }

  </style>
</head>
<body>

<div class="top-menu">
  <img src="upatrasLogo.jpg" alt="Logo" style="width: 6em; height: auto;">
  <div class="menu-title">Σύστημα Υποστήριξης Διπλωματικών Εργασιών</div>
</div>

<div class="container">
  <h2>Λεπτομέρειες Διπλωματικής</h2>

  <div class="row">
    <span class="label">Τίτλος:</span>
    <span class="value"><?= htmlspecialchars($thesis['title']) ?></span>
  </div>

  <div class="row">
    <span class="label">Περίληψη:</span>
    <span class="value"><?= nl2br(htmlspecialchars($thesis['summary'])) ?></span>
  </div>

  <div class="row">
    <span class="label">Κατάσταση:</span>
    <span class="value"><?= htmlspecialchars($thesis['status']) ?></span>
  </div>

  <div class="row">
    <span class="label">Ημερομηνία Ανάθεσης:</span>
    <span class="value"><?= htmlspecialchars($thesis['assignment_date']) ?></span>
  </div>

  <?php if ($days_since_assignment !== null): ?>
  <div class="row">
    <span class="label">Ημέρες από την Ανάθεση:</span>
    <span class="value"><?= $days_since_assignment ?> ημέρες</span>
  </div>
  <?php endif; ?>

  <div class="row">
    <span class="label">Φοιτητής:</span>
    <span class="value"><?= htmlspecialchars($thesis['student_name'] . ' ' . $thesis['student_surname']) ?></span>
  </div>

  <div class="row">
    <span class="label">Καθηγητής:</span>
    <span class="value"><?= htmlspecialchars($thesis['professor_name'] . ' ' . $thesis['professor_surname']) ?></span>
  </div>

  <?php if ($thesis['status'] === 'cancelled'): ?>
  <div class="row">
    <span class="label">Λόγος Ακύρωσης:</span>
    <span class="value"><?= nl2br(htmlspecialchars($thesis['cancellation_reason'])) ?></span>
  </div>
  <?php endif; ?>

  <a class="back-link" href="view_theses.php">← Επιστροφή στη λίστα</a>
</div>

</body>
</html>


