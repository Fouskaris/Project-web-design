<!DOCTYPE html>
<html lang="en">
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
    color: black;
    display: flex;
    align-items: center;
    padding: 10px 20px;
    position: fixed;
    top: 0;
    width: 100%;
    box-sizing: border-box;
    z-index: 2;
    flex-wrap: wrap;
  }

  .menu-title {
    font-size: 30px;
    flex: 1;
  }

  .button {
    margin-left: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 8px 12px 8px 16px;
    gap: 8px;
    height: 40px;
    width: 250px;
    border: none;
    background: white;
    border-radius: 20px;
    cursor: pointer;
  }

  .buttonNotif {
    position: absolute;
    right: 2vw;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 8px 12px;
    gap: 8px;
    border: 1px solid rgba(78, 79, 81, 0.81);
    height: 40px;
    width: 60px;
    background: white;
    border-radius: 20px;
    cursor: pointer;
  }

  .buttonNotif:hover {
    background: rgba(88, 89, 92, 0.29);
  }

  .lable {
    font-size: 20px;
    color: black;
  }

  .button:hover {
    background: rgba(88, 89, 92, 0.29);
  }

  .menu {
    width: 30%;
    max-width: 40%;
    padding: 8px 12px;
    gap: 8px;
    background-color: white;
    border: none;
    border-radius: 8px;
  }

  .button_menu {
    border: none;
    background: none;
    font-size: 20px;
    margin: 10px;
    cursor: pointer;
  }

  .button_menu:hover,
  .button_menu:focus {
    color: blue;
  }

  .pic {
    margin-top: 3em;
    width: 100%;
    max-width: 768px;
    height: auto;
    border-radius: 15px;
    margin-left: 15px;
  }

  .announcement-sidebar {
    position: fixed;
    top: 80px;
    right: 0;
    width: 300px;
    height: calc(100vh - 80px);
    background-color: #fff;
    border-left: 1px solid #ccc;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    z-index: 1;
    margin-bottom: 15vw;
  }

  .announcement-header {
    padding: 15px;
    font-weight: bold;
    font-size: 20px;
    background-color: #f5f5f5;
    border-bottom: 1px solid #ddd;
    text-align: center;
  }

  .announcement-list {
    overflow-y: auto;
    flex: 1;
    padding-bottom: 60px;
  }

  .announcement-item {
    padding: 12px 16px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
  }

  .announcement-item:hover {
    background-color: rgb(209, 206, 206);
  }

  .announcement-title {
    font-weight: bold;
    font-size: 0.95em;
    margin-bottom: 5px;
    color: #0073b7;
  }

  .announcement-message {
    font-size: 0.9em;
    color: #333;
  }

  .announcement-date {
    font-size: 0.8em;
    color: #777;
    text-align: right;
    margin-top: 6px;
  }

  .announcement-item.info {
    border-left: 5px solid #3498db;
  }

  .announcement-item.warning {
    border-left: 5px solid #f39c12;
    background-color: rgb(240, 204, 146);
  }

  .announcement-item.alert {
    border-left: 5px solid #e74c3c;
    background-color: rgb(243, 179, 179);
  }

  .bottom-menu {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: whitesmoke;
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 10px 2px;
    flex-wrap: wrap;
    z-index: 2;
  }

  .footer-button,
  .footer-link {
    font-size: 16px;
    padding: 8px 16px;
    margin: 5px;
    border-radius: 15px;
    border: none;
    background-color: white;
    color: black;
    cursor: pointer;
    text-align: center;
  }

  .footer-button:hover,
  .footer-link:hover {
    background: rgba(88, 89, 92, 0.29);
  }

  .logout-button {
    border: 1px solid red;
    color: red;
  }

  .logout-button:hover {
    background-color: rgba(255, 0, 0, 0.1);
  }

  .helpdesk-button {
    border: 1px solid #0073b7;
    color: #0073b7;
    background-color: white;
  }

  .helpdesk-button:hover {
    background-color: rgba(0, 115, 183, 0.1);
  }

  @media (max-width: 768px) {
    .top-menu {
      flex-direction: column;
      align-items: flex-start;
    }

    .menu-title {
      font-size: 20px;
      margin-top: 10px;
    }

    .button,
    .buttonNotif {
      width: auto;
      justify-content: flex-start;
      margin-top: 0.5em;
    }

    .main-layout {
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .menu {
      width: 90%;
      max-width: none;
      margin: 2em 0;
    }

    .announcement-sidebar {
      position: relative;
      width: 100%;
      height: auto;
      box-shadow: none;
      border-left: none;
      border-top: 1px solid #ccc;
      margin-top: 1em;
    }

    .announcement-list {
      max-height: 300px;
    }

    /* ✅ Responsive footer changes */
    .bottom-menu {
      flex-direction: column;
      align-items: center;
      position: static;
      padding: 10px;
    }

    .footer-button,
    .footer-link {
      width: 100%;
      max-width: 400px;
      margin: 5px auto;
      display: block;
    }
  }
</style>
</head>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$jsonString = file_get_contents("export.json");
$data = json_decode($jsonString, true);
$students = $data['students'];
$foundstud = null;
foreach ($students as $student) {
  if ($student['id'] == $id) {
    $foundstud = $student;
    $stud_num = $student['student_number'];
  }
}
?>

<body>
<form action="profileScr.php" method="post">
  <div class="top-menu">
    <img src="upatrasLogo.jpg" alt="Image" style="display: block; margin: 0px; width: 20vw; max-width: 100px; height: auto;">
    <div class="menu-title">Σύστημα Υποστήριξης Διπλωματικών Εργασιών</div>

    <?php
    $has_unseen = false;
    foreach ($foundstud["notifications"] as $notif) {
      if ($notif["seen"] == "no") {
        $has_unseen = true;
        break;
      }
    }
    echo $has_unseen ? "<button class='buttonNotif' style='background-color:red;'>" : "<button class='buttonNotif'>";
    ?>
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
      <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
      </svg>
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    </button>

    <button class="button">
      <span class="lable"><?php echo $stud_num; ?></span>
    </button>
</form>
</div>

<div class="main-layout" style="display: flex; align-items: center; margin-top:10vw;">
  <img class="pic" src="gptimage.png" alt="Image">
  <div class="menu" style="margin-left: 3vw;">
    <h1>Keimenooo</h1>
    <form action="subjList.php" method="post"><input type="hidden" name="id" value="<?php echo $id; ?>"><button class="button_menu" type="submit">Προβολή θεμάτων</button></form>
    <form action="subj.php" method="post"><input type="hidden" name="id" value="<?php echo $id; ?>"><button class="button_menu" type="submit">Διαχείριση Διπλωματικών</button></form>
    <form action="subjMater.php" method="post"><input type="hidden" name="id" value="<?php echo $id; ?>"><button class="button_menu" type="submit">Υλικό Διπλωματικής</button></form>
    <form action="subjSituation.php" method="post"><input type="hidden" name="id" value="<?php echo $id; ?>"><button class="button_menu" type="submit">Κατάσταση Διπλωματικής</button></form>
  </div>

  <div class="announcement-sidebar">
    <div class="announcement-header">Ανακοινώσεις</div>
    <div class="announcement-list" id="announcementList"></div>
  </div>
</div>

<div class="bottom-menu">
  <a class="footer-button helpdesk-button" href="https://helpdesk.upnet.gr/" target="_blank">Επικοινωνία με Helpdesk για πρόβλημα σύνδεσης</a>
  <a class="footer-link" href="https://eclass.upatras.gr/" target="_blank">eClass Upatras</a>
  <a class="footer-link" href="https://www.upatras.gr/" target="_blank">Πανεπιστήμιο Πατρών</a>
  <button class="footer-button logout-button" onclick="window.location.href='loginScr.php'">Αποσύνδεση</button>
</div>

<script>
fetch('announcements.json')
  .then(response => response.json())
  .then(data => {
    const container = document.getElementById('announcementList');
    data.announcements.forEach(item => {
      const div = document.createElement('div');
      div.className = `announcement-item ${item.type}`;
      div.innerHTML = `
        <div class="announcement-title">${item.title}</div>
        <div class="announcement-message">${item.message}</div>
        <div class="announcement-date">${item.date}</div>
      `;
      container.appendChild(div);
    });
  })
  .catch(error => {
    console.error("Σφάλμα φόρτωσης ανακοινώσεων:", error);
  });
</script>
