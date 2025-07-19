<?php
$id = $_POST['ia'] ?? null;

$jsonString = file_get_contents("dipl.json");
$data = json_decode($jsonString, true);
$subjects = &$data['subjects'];

$selected = null;
foreach ($subjects as &$subject) {
    if ($subject['id'] == $id) {
        $selected = &$subject;
        break;
    }
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'assign') {
        $protocol_number = $_POST['protocol_number'] ?? '';
        $selected['assignment_protocol'] = $protocol_number;
        $message = "Ο ΑΠ ανάθεσης καταχωρήθηκε.";
    }

    if ($_POST['action'] === 'cancel') {
        $cancel_protocol = $_POST['cancel_protocol'] ?? '';
        $cancel_year = $_POST['cancel_year'] ?? '';
        $reason = "Κατόπιν αίτησης φοιτητή/τριας";

        $selected['status'] = "Ακυρωμένη";
        $selected['cancel_protocol'] = $cancel_protocol;
        $selected['cancel_year'] = $cancel_year;
        $selected['cancel_reason'] = $reason;

        $message = "Η ανάθεση ακυρώθηκε επιτυχώς.";
    }

    // Save changes to JSON
    file_put_contents("dipl.json", json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Διπλωματική Ενεργή</title>
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

    .form-section {
      margin-top: 2em;
    }

    input[type="text"], input[type="number"] {
      width: 100%;
      padding: 10px;
      margin: 5px 0 15px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .form-button {
      padding: 10px 20px;
      background-color: rgba(36, 190, 49, 0.81);
      color: black;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      font-size: 16px;
    }

    .form-button:hover {
      background-color: rgba(22, 127, 31, 0.81);
    }

    .message {
      margin-top: 1em;
      color: #317a2e;
      font-weight: bold;
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

    <?php if ($message): ?>
      <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- Καταχώρηση ΑΠ Ανάθεσης -->
    <div class="form-section">
      <form method="post">
        <input type="hidden" name="ia" value="<?= htmlspecialchars($selected['id']) ?>">
        <input type="hidden" name="action" value="assign">
        <label for="protocol_number" class="label">Αριθμός Πρακτικού Ανάθεσης:</label>
        <input type="text" id="protocol_number" name="protocol_number" required>
        <button type="submit" class="form-button">Καταχώρηση ΑΠ Ανάθεσης</button>
      </form>
    </div>

    <!-- Ακύρωση Ανάθεσης -->
    <div class="form-section">
      <form method="post">
        <input type="hidden" name="ia" value="<?= htmlspecialchars($selected['id']) ?>">
        <input type="hidden" name="action" value="cancel">
        <label for="cancel_protocol" class="label">Αριθμός Πρακτικού Ακύρωσης:</label>
        <input type="text" id="cancel_protocol" name="cancel_protocol" required>

        <label for="cancel_year" class="label">Έτος Ακύρωσης:</label>
        <input type="number" id="cancel_year" name="cancel_year" required>

        <button type="submit" class="form-button" style="background-color: #cc3333; color: white;">Ακύρωση Ανάθεσης</button>
      </form>
    </div>

  <?php else: ?>
    <div class="message" style="color: red;">Η διπλωματική δεν βρέθηκε.</div>
  <?php endif; ?>
</div>

<form action="view_theses.php" method="get">
  <button class="back-button" type="submit">Επιστροφή</button>
</form>

</body>
</html>
