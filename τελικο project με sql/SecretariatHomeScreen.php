<!DOCTYPE html>
<html lang="el">
  <?php

session_start();

if (!isset($_SESSION['Sec_id'])) {
    header('Location: loginScr.php');
    exit;
}
$id = $_SESSION['Sec_id'];

?>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Σύστημα Υποστήριξης Διπλωματικών Εργασιών</title>
<style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f9f9f9;
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
    z-index: 10;
    flex-wrap: wrap;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  }

  .menu-title {
    font-size: 1.5rem;
    flex: 1;
    margin-left: 1em;
  }

  .button {
    margin-left: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 8px 16px;
    gap: 8px;
    height: 40px;
    border: none;
    background: white;
    border-radius: 20px;
    cursor: pointer;
  }


  .buttonNotif:hover, .button:hover {
    background: rgba(88, 89, 92, 0.15);
  }

  .lable {
    font-size: 1rem;
    color: black;
  }

  .main-layout {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 2em;
    padding: 120px 2em 80px 2em;
    box-sizing: border-box;
  }

  .pic {
    width: 100%;
    max-width: 600px;
    height: auto;
    border-radius: 15px;
    object-fit: cover;
  }

  .menu {
    flex: 0.7;
    background: white;
    padding: 1em 2em;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  }

  .menu h1 {
    font-size: 1.4rem;
    margin-bottom: 1em;
  }

  .button_menu {
    border: none;
    background: none;
    font-size: 18px;
    margin: 10px 0;
    cursor: pointer;
    text-align: left;
    display: block;
    width: 100%;
  }

  .button_menu:hover {
    color: blue;
  }

  .announcement-sidebar {
    width: 300px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    height: fit-content;
  }

  .announcement-header {
    padding: 5px;
    font-weight: bold;
    font-size: 20px;
    background-color: #f5f5f5;
    border-bottom: 1px solid #ddd;
    text-align: center;
    border-radius: 12px 12px 0 0;
  }

  .announcement-list {
    max-height: 400px;
    overflow-y: auto;
    padding: 10px;
  }

  .announcement-item {
    padding: 12px;
    margin-bottom: 8px;
    border-radius: 8px;
    cursor: pointer;
    background: #fafafa;
  }

  .announcement-item:hover {
    background: #eee;
  }

  .announcement-title {
    font-weight: bold;
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
    background-color: #fff4e0;
  }

  .announcement-item.alert {
    border-left: 5px solid #e74c3c;
    background-color: #ffe0e0;
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
    padding: 12px;
    flex-wrap: wrap;
    z-index: 10;
    box-shadow: 0 -2px 6px rgba(0,0,0,0.1);
  }

  .footer-button,
  .footer-link {
    font-size: 14px;
    padding: 3px 12px;
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
    background: rgba(88, 89, 92, 0.15);
  }

  .logout-button {
    border: 1px solid red;
    color: red;
  }

  .logout-button:hover {
    background: rgba(255,0,0,0.1);
  }

  .helpdesk-button {
    border: 1px solid #0073b7;
    color: #0073b7;
  }

  .helpdesk-button:hover {
    background: rgba(0,115,183,0.1);
  }

  @media (max-width: 992px) {
    .main-layout {
      flex-direction: column;
      align-items: center;
    }

    .pic {
      max-width: 90%;
    }

    .menu {
      width: 100%;
      margin-top: 1em;
    }

    .announcement-sidebar {
      width: 100%;
      margin-top: 0em;
      margin-bottom: 4em;
    }
  }

  @media (max-width: 600px) {
    .menu-title {
      font-size: 18px;
    }

    .button, .buttonNotif {
      padding: 6px 10px;
      font-size: 14px;
    }

    .pic {
      max-width: 90%;
    }

    .bottom-menu {
      flex-direction: column;
      align-items: center;
    }

    .footer-button,
    .footer-link {
      width: 100%;
      max-width: 350px;
    }
  }
</style>
</head>

<body>
<div class="top-menu">
  <img src="upatrasLogo.jpg" alt="Image" style="display:block; width:20vw; max-width:100px; height:auto;">
  <div class="menu-title">Σύστημα Υποστήριξης Διπλωματικών Εργασιών</div>
  <button class="button">
    <span class="lable">Γραμματεία</span>
  </button>
</div>

<div class="main-layout">
  <img class="pic" src="upatras.jpg" alt="Image" style="display:block; width:100vw; max-width:650px; height:auto;">
  <div class="menu">
    <h1>Κεντρική σελίδα Γραμματείας</h1>
    <form action="View_Theses.php" method="get">
      <button class="button_menu" type="submit">Προβολή Διπλωματικών</button>
    </form>
    <form action="Import_data.php" method="get">
      <button class="button_menu" type="submit">Εισαγωγή Δεδομένων</button>
    </form>
    <form action="Manage_Theses.php" method="get">
      <button class="button_menu" type="submit">Διαχείρηση Διπλωματικών</button>
    </form>
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
</body>
</html>


