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
  }
  
  .menu-title {
    font-size: 30px;
  }
 
  .button1 {
  margin-left: auto;
  font-size: 30px;
  margin-top:15px;
}
  
  .button1 svg{
    width: 100px; 
    height: 100px;
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
  background:white;
  border-radius: 20px;
  cursor: pointer;
}
  
.buttonNotif{
  position:absolute;
  right: 1px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 8px 12px 8px 12px;
  gap: 8px;
  border: 1px solid rgba(78, 79, 81, 0.81);
  height: 40px;
  width: 60px;
  background:white;
  border-radius: 20px;
  cursor: pointer;
  z-index: 1;
}
  
.buttonNotif:hover {
  background:rgba(88, 89, 92, 0.29);
}

.lable {
  font-size: 20px;
  color:black;
}

.button:hover {
  background:rgba(88, 89, 92, 0.29);
}
  
.menu{
      width: 30%;          
      max-width: 40%;   
      padding: 8px 12px 8px 16px;
      gap: 8px;
      background-color:white;
      border:none;
      border-radius: 8px;
}
  
.button_menu{
  border:none;
  background:none;
  font-size: 20px;
  margin: 10px;
}
  
.button_menu:hover,.button_menu:focus{
  color:blue;
}
  
.pic{
   margin-top:3em; 
   height=100%;
   width: 50em;
   border-radius: 15px;
   margin-left:5px;
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
  background-color:rgb(209, 206, 206);
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
  background-color:rgb(240, 204, 146);
}

.announcement-item.alert {
  border-left: 5px solid #e74c3c;
  background-color:rgb(243, 179, 179);
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

  
</style>
</head>
<?php $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
  $jsonString= file_get_contents("export.json");
  $data= json_decode($jsonString,true);
  $students = $data['students']; 
  $foundstud=null;
  foreach($students as $student){ ;
    if ($student['id']==$id){
      $foundstud =$student;
      $stud_num = $student['student_number']; }
  }?>
<body>
<form action="profileScr.php" method="post">
<div class="top-menu">
  <img src="upatrasLogo.jpg" alt="Image" style="display: block; margin: 0px; width: 10em;">
  <div class="menu-title">Σύστημα Υποστήριξης Διπλωματικών Εργασιών</div>
    <?php
    foreach ($foundstud["notifications"] as $notif) {
    if ($notif["seen"]=="no"){echo "<button class='buttonNotif' style='background-color:red;'>";}
    else{echo "<button class='buttonNotif'>";}}
    ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
      <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
    </svg>
  </svg>
<input type="hidden" name="id" value="<?php echo $id; ?>">
</button>
  <button class="button">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-backpack3" viewBox="0 0 16 16">
      <path d="M4.04 7.43a4 4 0 0 1 7.92 0 .5.5 0 1 1-.99.14 3 3 0 0 0-5.94 0 .5.5 0 1 1-.99-.14M4 9.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm1 .5v3h6v-3h-1v.5a.5.5 0 0 1-1 0V10z"/>
      <path d="M6 2.341V2a2 2 0 1 1 4 0v.341c.465.165.904.385 1.308.653l.416-1.247a1 1 0 0 1 1.748-.284l.77 1.027a1 1 0 0 1 .15.917l-.803 2.407C13.854 6.49 14 7.229 14 8v5.5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5V8c0-.771.146-1.509.41-2.186l-.802-2.407a1 1 0 0 1 .15-.917l.77-1.027a1 1 0 0 1 1.748.284l.416 1.247A6 6 0 0 1 6 2.34ZM7 2v.083a6 6 0 0 1 2 0V2a1 1 0 1 0-2 0m5.941 2.595.502-1.505-.77-1.027-.532 1.595q.447.427.8.937M3.86 3.658l-.532-1.595-.77 1.027.502 1.505q.352-.51.8-.937M8 3a5 5 0 0 0-5 5v5.5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5V8a5 5 0 0 0-5-5"/>
  </svg>
  
  <span class="lable"><?php echo $stud_num; ?></span>
</button>
</form>
</div>
</div>
<div style="display: flex; align-items: center;margin-top:5em;">
  <img class="pic" src="gptimage.png" alt="Image" style=" border-radius: 15px;">
  <div class="menu" style="margin-left: 2em;">
    <h1>Keimenooo</h1>
    <form action="subjList.php" method="post">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <button class="button_menu" type="submit">Προβολή θεμάτων</button>
    </form>
    <form action="subj.php" method="post">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <button class="button_menu" type="submit">Διαχείριση Διπλωματικών</button>
    </form>
    <form action="subjMater.php" method="post">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <button class="button_menu" type="submit">Υλικό Διπλωματικής</button>
    </form>
    <form action="subjSituation.php" method="post">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <button class="button_menu" type="submit">Κατάσταση Διπλωματικής</button>
    </form>
  </div>

  <div class="announcement-sidebar">
  <div class="announcement-header">Ανακοινώσεις</div>
  <div class="announcement-list" id="announcementList">
  </div>

  <div class="bottom-menu">
  <a class="footer-button helpdesk-button" href="https://helpdesk.upnet.gr/" target="_blank">
    Επικοινωνία με Helpdesk για πρόβλημα σύνδεσης
  <a class="footer-link" href="https://eclass.upatras.gr/" target="_blank">eClass Upatras</a>
  <a class="footer-link" href="https://www.upatras.gr/" target="_blank">Πανεπιστήμιο Πατρών</a>
  <button class="footer-button logout-button" onclick="window.location.href='loginScr.php'">Αποσύνδεση</button>
  </a>
  </div>
    
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