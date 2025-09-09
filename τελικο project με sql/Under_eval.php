<?php
$id = $_POST['ia'] ?? null;
$jsonString = file_get_contents("dipl.json");
$data = json_decode($jsonString, true);
$subjects = $data['subjects'];

$selected = null;
foreach ($subjects as $subject) {
    if ($subject['id'] == $id) {
        $selected = $subject;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Διπλωματική Υπό Εξέταση</title>
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

    .container {
      margin-top: 8em;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
    }

    .info-row {
      margin-bottom: 15px;
    }

    .label {
      font-weight: bold;
    }

    .status-button {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: rgba(36, 190, 49, 0.81);
      color: black;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      font-size: 16px;
    }

    .status-button:hover {
      background-color: rgba(22, 127, 31, 0.81);
    }

    .back-button {
      position: fixed;
      bottom: 30px;
      right: 30px;
      padding: 10px 20px;
      background-color: rgba(36, 190, 49, 0.81);
      color: black;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      font-size: 16px;
    }

    .back-button:hover {
      background-color: rgba(22, 127, 31, 0.81);
    }

    .note {
      margin-top: 1em;
      color: #b00;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="top-menu">
  <img src="upatrasLogo.jpg" alt="Logo" style="width: 10em; margin-right: 20px;">
  <div class="menu-title">Σύστημα Υποστήριξης Διπλωματικών Εργασιών</div>
</div>

<div class="container">
  <?php if ($selected): ?>
    <div class="info-row"><span class="label">Κωδικός:</span> <?= htmlspecialchars($selected['id']) ?></div>
    <div class="info-row"><span class="label">Τίτλος:</span> <?= htmlspecialchars($selected['name']) ?></div>
    <div class="info-row"><span class="label">Καθηγητής:</span> <?= htmlspecialchars($selected['professor_surname']) ?></div>
    <div class="info-row"><span class="label">Κατάσταση:</span> <?= htmlspecialchars($selected['status']) ?></div>
    <div class="info-row"><span class="label">Βαθμός:</span> <?= htmlspecialchars($selected['grade'] ?? 'Δεν έχει καταχωρηθεί') ?></div>
    <div class="info-row"><span class="label">Σύνδεσμος Νημερτή:</span>
      <?php
        if (!empty($selected['nimertis_link'])) {
          echo '<a href="' . htmlspecialchars($selected['nimertis_link']) . '" target="_blank">Προβολή</a>';
        } else {
          echo 'Δεν έχει καταχωρηθεί';
        }
      ?>
    </div>

    <?php if (!empty($selected['grade']) && !empty($selected['nimertis_link'])): ?>
      <form method="post" action="Completed.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($selected['id']) ?>">
        <button type="submit" class="status-button">Ορισμός ως Περατωμένη</button>
      </form>
    <?php else: ?>
      <div class="note">Δεν είναι δυνατή η περάτωση. Βεβαιωθείτε ότι έχει καταχωρηθεί βαθμός και σύνδεσμος προς το Νημερτή.</div>
    <?php endif; ?>

  <?php else: ?>
    <div class="note">Δεν βρέθηκε η Διπλωματική.</div>
  <?php endif; ?>
</div>

<form action="Manage_Theses.php" method="get">
  <button class="back-button" type="submit">Επιστροφή</button>
</form>

</body>
</html>