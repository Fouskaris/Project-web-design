<!DOCTYPE html>
<html lang="el">
<?php
session_start();
if (!isset($_SESSION['Stud_id'])) {
    header('Location: login.php');
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
  <button class="buttonNotif">
    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16" width="20" height="20">
      <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
    </svg>
  </button>
  <button class="button">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-backpack3" viewBox="0 0 16 16">
      <path d="M4.04 7.43a4 4 0 0 1 7.92 0 .5.5 0 1 1-.99.14 3 3 0 0 0-5.94 0 .5.5 0 1 1-.99-.14M4 9.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm1 .5v3h6v-3h-1v.5a.5.5 0 0 1-1 0V10z"/>
      <path d="M6 2.341V2a2 2 0 1 1 4 0v.341c.465.165.904.385 1.308.653l.416-1.247a1 1 0 0 1 1.748-.284l.77 1.027a1 1 0 0 1 .15.917l-.803 2.407C13.854 6.49 14 7.229 14 8v5.5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5V8c0-.771.146-1.509.41-2.186l-.802-2.407a1 1 0 0 1 .15-.917l.77-1.027a1 1 0 0 1 1.748.284l.416 1.247A6 6 0 0 1 6 2.34ZM7 2v.083a6 6 0 0 1 2 0V2a1 1 0 1 0-2 0m5.941 2.595.502-1.505-.77-1.027-.532 1.595q.447.427.8.937M3.86 3.658l-.532-1.595-.77 1.027.502 1.505q.352-.51.8-.937M8 3a5 5 0 0 0-5 5v5.5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5V8a5 5 0 0 0-5-5"/>
    </svg>
    <span class="lable">
      <?php
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
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
      if ($subject['student_number']==$stud_num){
        $idSubj=$subject['id'];
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
      $idSubj=$subject['id'];
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
