<?php
$jsonString = file_get_contents("dipl.json");
$data = json_decode($jsonString, true);
$subjects = $data["subjects"];
?>

<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Προβολή Διπλωματικών</title>
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

    table {
      border-collapse: collapse;
      width: 80%;
      margin: auto;
      margin-top: 7em;
    }

    th, td {
      border: 1px solid #000;
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    .listButton {
      background-color: white;
      color: rgba(36, 190, 49, 0.81);
      border: none;
      cursor: pointer;
    }

    .listButton:hover {
      color: rgba(22, 127, 31, 0.81);
    }

    .tabletitle {
      margin-top: 6em;
      text-align: center;
    }

    .button {
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

    .button:hover {
      background-color: rgba(22, 127, 31, 0.81);
    }
  </style>
</head>
<body>

<div class="top-menu">
  <img src="upatrasLogo.jpg" alt="Logo" style="width: 10em; margin-right: 20px;">
  <div class="menu-title">Σύστημα Υποστήριξης Διπλωματικών Εργασιών</div>
</div>

<h2 class="tabletitle">Προβολή Ενεργών & Υπό Εξέταση Διπλωματικών</h2>

<table>
  <tr>
    <th>Κωδικός</th>
    <th>Θέμα</th>
    <th>Καθηγητής</th>
    <th>Κατάσταση</th>
    <th>Λεπτομέρειες</th>
  </tr>

<?php
foreach ($subjects as $subject) {
    $status = $subject['status'];
    if ($status === "Ενεργή" || $status === "Υπό Εξέταση") {
        $id = $subject['id'];
        echo "<tr>
            <td>" . htmlspecialchars($id) . "</td>
            <td>" . htmlspecialchars($subject['name']) . "</td>
            <td>" . htmlspecialchars($subject['professor_surname']) . "</td>
            <td>" . htmlspecialchars($status) . "</td>
            <td>
              <form action='details.php' method='post'>
                <input type='hidden' name='ia' value='" . htmlspecialchars($id) . "'>
                <button class='listButton' type='submit'>
                  <svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' fill='currentColor' class='bi bi-arrow-right-square-fill' viewBox='0 0 16 16'>
                    <path d='M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1'/>
                  </svg>
                </button>
              </form>
            </td>
          </tr>";
    }
}
?>
</table>

<form action="SecretariatHomeScreen.php" method="get">
  <button class="button" type="submit">Επιστροφή</button>
</form>

</body>
</html>