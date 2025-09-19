<?php
session_start();
if (!isset($_SESSION['Stud_id'])) {
    header('Location: loginScr.php');
    exit;
}

$id = $_SESSION['Stud_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $post_id = (int)$_POST['id'];
    $jsonString = file_get_contents("export.json");
    $data = json_decode($jsonString, true);
    $stud_num = "";

    foreach ($data['students'] as $student) {
        if ($student['id'] == $post_id) {
            $stud_num = $student['student_number'];
            break;
        }
    }

    header("Location: " . $_SERVER['PHP_SELF'] . "?stud_num=" . urlencode($stud_num));
    exit;
}

$stud_num = isset($_GET['stud_num']) ? $_GET['stud_num'] : '';
?>
<!DOCTYPE html>
<html lang="el">
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

  .button:hover, .buttonNotif:hover {
    background: rgba(88, 89, 92, 0.2);
  }

  .lable {
    font-size: 1em;
    color: black;
  }

  .table-wrapper {
    margin: auto;
    margin-top: 8em;
    width: 90%;
    max-width: 1000px;
    overflow-x: auto;
  }

  table {
    border-collapse: collapse;
    width: 100%;
    min-width: 500px;
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

  .tabletitle, .tabletitle2 {
    text-align: center;
    font-size: 1.8em;
    margin-top: 4em;
    margin-bottom: 1em;
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

    .table-wrapper {
      margin-top: 10em;
    }

    .tabletitle, .tabletitle2 {
      font-size: 1.4em;
    }
  }

  @media (max-width: 480px) {
    .menu-title {
      font-size: 1em;
    }

    .lable {
      font-size: 0.9em;
    }

    th, td {
      font-size: 0.9em;
      padding: 8px;
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
      <?php echo htmlspecialchars($stud_num); ?>
    </span>
  </button>
</div>

<div class="table-wrapper">
<?php
$jsonString = file_get_contents("dipl.json");
$data = json_decode($jsonString, true);

if (isset($data['subjects']) && is_array($data['subjects'])) {
    $subjects = $data['subjects'];

    echo "<h1 class='tabletitle'>Η διπλωματική μου</h1>";
    echo "<table>
        <tr>
          <th></th>
          <th>Θέμα</th>
          <th>Καθηγητής</th>
          <th>Κατάσταση</th>
          <th>Ενέργεια</th>
        </tr>";
    foreach ($subjects as $subject) {
      if ($subject['student_number'] == $stud_num){
        $idSubj = $subject['id'];
        echo "<tr>
          <td>" . htmlspecialchars($subject['id']) . "</td>
          <td>" . htmlspecialchars($subject['name']) . "</td>
          <td>" . htmlspecialchars($subject['professor_surname']) . "</td>
          <td>" . htmlspecialchars($subject['status']) . "</td>
          <td>
            <form action='details.php' method='post'>
            <input type='hidden' name='ia' value='$idSubj'>
            <button class='listButton' type='submit'>
              <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-arrow-right-square-fill' viewBox='0 0 16 16'>
                <path d='M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1'/>
              </svg>
            </button>
            </form>
          </td>
        </tr>";
      }
    }
    echo "</table>";

    echo "<h1 class='tabletitle2'>Θέματα</h1>";
    echo "<table>
      <tr>
        <th>Κωδικός</th>
        <th>Θέμα</th>
        <th>Καθηγητής</th>
        <th>Ενέργεια</th>
      </tr>";
    foreach ($subjects as $subject) {
      $idSubj = $subject['id'];
        echo "<tr>
          <td>" . htmlspecialchars($subject['id']) . "</td>
          <td>" . htmlspecialchars($subject['name']) . "</td>
          <td>" . htmlspecialchars($subject['professor_surname']) . "</td>
          <td>
            <form action='details.php' method='post'>
            <input type='hidden' name='ia' value='$idSubj'>
            <button class='listButton' type='submit'>
              <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-arrow-right-square-fill' viewBox='0 0 16 16'>
                <path d='M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1'/>
              </svg>
            </button>
            </form>
          </td>
        </tr>";
    }
    echo "</table>";
}
?>
</div>

</body>
</html>

