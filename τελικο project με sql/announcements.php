<?php
$format = $_GET['format'] ?? 'html';

$jsonFile = 'dipl.json';
if (!file_exists($jsonFile)) {
    die("Το αρχείο JSON δεν βρέθηκε!");
}

$jsonData = file_get_contents($jsonFile);
$dataArray = json_decode($jsonData, true);

if (!$dataArray || !isset($dataArray['subjects'])) {
    die("Μη έγκυρα δεδομένα JSON!");
}

$announcements = $dataArray['subjects'];

$announcements = array_filter($announcements, function($row) {
    return !empty($row['pres_date']);
});

if ($format === 'json') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($announcements, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

if ($format === 'xml') {
    header('Content-Type: text/xml; charset=utf-8');
    echo "<?xml version='1.0' encoding='UTF-8'?>";
    echo "<announcements>";
    foreach ($announcements as $row) {
        echo "<announcement>";
        echo "<id>".$row['id']."</id>";
        echo "<title>".htmlspecialchars($row['name'])."</title>";
        echo "<presentation_date>".$row['pres_date']."</presentation_date>";
        echo "<description>".htmlspecialchars($row['description'])."</description>";
        echo "</announcement>";
    }
    echo "</announcements>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8">
  <title>Ανακοινώσεις Διπλωματικών</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 2em;
      text-align: center;
    }
    h2 {
      margin-bottom: 1em;
    }
    table {
      width: 90%;
      max-width: 800px;
      margin: auto;
      border-collapse: collapse;
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #252525;
      color: white;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    .back-link {
      display: block;
      margin-top: 2em;
      color: #0645ad;
      text-decoration: none;
    }
    .back-link:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
    table {
    width: 100%;
    font-size: 0.9em; 

    th, td {
    padding: 8px; 
    }

    h2 {
    font-size: 1.5em;
    }

    .back-link {
    font-size: 0.9em;
    }
}
}
  </style>
</head>
<body>
  <h2>Ανακοινώσεις Διπλωματικών</h2>
  <table>
    <tr>
      <th>Τίτλος</th>
      <th>Ημερομηνία Παρουσίασης</th>
      <th>Περιγραφή</th>
    </tr>
    <?php foreach ($announcements as $row) { ?>
    <tr>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= $row['pres_date'] ?? '-' ?></td>
      <td><?= htmlspecialchars($row['description']) ?></td>
    </tr>
    <?php } ?>
  </table>

  <a class="back-link" href="loginScr.php">Επιστροφή στην σελίδα σύνδεσης</a>
</body>
</html>
